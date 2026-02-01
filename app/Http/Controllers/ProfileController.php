<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    public function updateIdentity(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update($data);

        return back()->with('status', 'Identity updated successfully.');
    }

    public function updateContact(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'phone' => ['nullable', 'string', 'max:50'],
            'affiliation' => ['nullable', 'string', 'max:500'],
            'orcid' => ['nullable', 'string', 'max:255'],
        ]);

        $user->update($data);

        return back()->with('status', 'Contact details updated successfully.');
    }

    public function updatePublic(Request $request)
    {
        $user = Auth::user();

        // Allow large images; we'll resize client-side rendering with object-fit
        $data = $request->validate([
            'bio' => ['nullable', 'string', 'max:2000'],
            'profile_image' => ['nullable', 'image', 'max:8192'], // up to ~8MB
        ]);

        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $path = $request->file('profile_image')->store('users/profiles', 'public');
            $data['profile_image'] = $path;
        }

        $user->update($data);

        return back()->with('status', 'Public profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return back()->with('status', 'Password updated successfully.');
    }

    public function updateRoles(Request $request)
    {
        $user = Auth::user();

        // Only allow 'author' role for users
        $validated = $request->validate([
            'role' => ['required', Rule::in(['author'])],
        ]);

        $user->update([
            'role' => $validated['role'],
        ]);

        return back()->with('status', 'Role updated successfully.');
    }

    public function updateNotifications(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'notify_system' => ['sometimes', 'boolean'],
            'notify_marketing' => ['sometimes', 'boolean'],
        ]);

        $user->update([
            'notify_system' => $request->boolean('notify_system'),
            'notify_marketing' => $request->boolean('notify_marketing'),
        ]);

        return back()->with('status', 'Notification preferences updated successfully.');
    }
}

