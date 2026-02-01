<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // First, check if user exists and get the user
        $user = User::where('email', $credentials['email'])->first();
        
        // Check if user account is terminated
        if ($user && $user->terminated_at) {
            return back()->withErrors([
                'email' => 'Your account has been terminated. Please contact the administrator.',
            ])->onlyInput('email');
        }
        
        // Check if user account is suspended
        if ($user && $user->suspended_at) {
            return back()->withErrors([
                'email' => 'Your account has been suspended. Please contact the administrator.',
            ])->onlyInput('email');
        }
        
        // Check if user account is disabled
        if ($user && !$user->is_active) {
            return back()->withErrors([
                'email' => 'Your account has been disabled. Please contact the administrator.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Double check after login (in case status changed during login)
            if ($user->terminated_at) {
                Auth::logout();
                $request->session()->invalidate();
                return back()->withErrors([
                    'email' => 'Your account has been terminated. Please contact the administrator.',
                ])->onlyInput('email');
            }
            
            if ($user->suspended_at) {
                Auth::logout();
                $request->session()->invalidate();
                return back()->withErrors([
                    'email' => 'Your account has been suspended. Please contact the administrator.',
                ])->onlyInput('email');
            }
            
            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                return back()->withErrors([
                    'email' => 'Your account has been disabled. Please contact the administrator.',
                ])->onlyInput('email');
            }
            
            // Role-based redirect
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->role === 'copyeditor') {
                return redirect()->intended(route('copyeditor.dashboard'));
            } elseif ($user->role === 'proofreader') {
                return redirect()->intended(route('proofreader.dashboard'));
            } elseif ($user->role === 'reviewer') {
                return redirect()->intended(route('reviewer.dashboard'));
            } elseif ($user->role === 'layout_editor') {
                return redirect()->intended(route('layout-editor.dashboard'));
            }
            
            // Check if user has layout_editor role in any journal
            $layoutEditorJournals = $user->journals()
                ->wherePivot('role', 'layout_editor')
                ->wherePivot('is_active', true)
                ->get();
            
            if ($layoutEditorJournals->count() > 0) {
                return redirect()->intended(route('layout-editor.dashboard'));
            }
            
            // Check if user has editor/journal_manager/section_editor role in any journal
            $editorJournals = $user->journals()
                ->wherePivotIn('role', ['journal_manager', 'editor', 'section_editor'])
                ->wherePivot('is_active', true)
                ->get();
            
            // Also check if user's global role is editor/journal_manager/section_editor
            // This handles cases where user has global editor role but no journal assignment yet
            if (in_array($user->role, ['editor', 'journal_manager', 'section_editor'])) {
                // If user has global editor role, check if they have any journals
                $allJournals = $user->journals()->wherePivot('is_active', true)->get();
                if ($allJournals->count() > 0) {
                    // If journals exist, add them to editorJournals
                    $editorJournals = $editorJournals->merge($allJournals)->unique('id');
                } else {
                    // If no journals assigned, get first active journal from system
                    $firstJournal = \App\Models\Journal::where('is_active', true)->first();
                    if ($firstJournal) {
                        // Auto-assign user to journal with their global role
                        $user->journals()->syncWithoutDetaching([
                            $firstJournal->id => [
                                'role' => $user->role,
                                'is_active' => true
                            ]
                        ]);
                        $editorJournals = collect([$firstJournal]);
                    }
                }
            }
            
            if ($editorJournals->count() > 0) {
                // If only one journal, redirect directly to editor dashboard
                if ($editorJournals->count() === 1) {
                    return redirect()->intended(route('editor.dashboard', $editorJournals->first()));
                }
                // If multiple journals, redirect to dashboard which will show selection
                return redirect()->intended(route('dashboard'));
            }
            
            // Default: Author or other roles
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'affiliation' => ['nullable', 'string', 'max:500'],
            'orcid' => ['nullable', 'string', 'max:255'],
            'terms' => ['accepted'],
        ]);

        try {
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'affiliation' => $validated['affiliation'] ?? null,
                'orcid' => $validated['orcid'] ?? null,
                'role' => 'reader', // Default role is Reader (OJS-style)
            ]);

            Auth::login($user);

            return redirect()->route('profile.show');
        } catch (\Throwable $e) {
            \Log::error('Registration failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['register' => 'Registration failed. Please try again or contact support.'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

