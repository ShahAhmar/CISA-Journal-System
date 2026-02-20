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
        $input = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $loginType = filter_var($input['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [
            $loginType => $input['login'],
            'password' => $input['password'],
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Check if user is active
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'login' => 'Your account has been deactivated. Please contact support.',
                ]);
            }

            // Role-based redirect
            if (in_array($user->role, ['admin', 'administrator', 'super-admin'])) {
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
            'login' => 'The provided credentials do not match our records.',
        ])->onlyInput('login');
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

