@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 py-12">
    <div class="max-w-6xl mx-auto px-4">
        @php
            $currentRole = $user->role ? ucfirst($user->role) : 'Not set';
        @endphp
        <div class="mb-8 flex items-start justify-between gap-4 flex-wrap">
            <div>
                <p class="text-xs uppercase tracking-[0.25em] text-blue-600 font-semibold mb-1">Account</p>
                <h1 class="text-3xl md:text-4xl font-bold text-slate-900">Profile & Preferences</h1>
                <p class="text-slate-600 mt-2">Identity, contact, roles, public profile, password, notifications.</p>
                <div class="mt-3 inline-flex items-center gap-2 bg-blue-50 text-blue-800 px-3 py-1.5 rounded-full text-sm font-semibold">
                    <i class="fas fa-user-shield"></i>
                    <span>Current role: {{ $currentRole }}</span>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-white/70 backdrop-blur border border-slate-100 rounded-xl px-4 py-3 shadow-sm">
                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                    {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-800">{{ $user->first_name }} {{ $user->last_name }}</p>
                    <p class="text-xs text-slate-500">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-green-800">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-red-800">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div x-data="{ tab: 'identity' }" class="bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden">
            <div class="flex flex-wrap border-b border-slate-100 bg-gradient-to-r from-slate-50 via-white to-blue-50">
                @php
                    $tabs = [
                        'identity' => 'Identity',
                        'contact' => 'Contact',
                        'public' => 'Public',
                        'password' => 'Password',
                        'notifications' => 'Notifications',
                    ];
                @endphp
                @foreach ($tabs as $key => $label)
                    <button type="button"
                            @click="tab = '{{ $key }}'"
                            :class="tab === '{{ $key }}' ? 'text-blue-700 border-blue-600 bg-white shadow-sm' : 'text-slate-600 border-transparent hover:text-slate-900'"
                            class="relative px-5 py-4 text-sm font-semibold border-b-2 transition-all duration-150">
                        <span>{{ $label }}</span>
                        <span x-show="tab === '{{ $key }}'" class="absolute inset-x-5 -bottom-[3px] h-[3px] rounded-full bg-blue-600" aria-hidden="true"></span>
                    </button>
                @endforeach
            </div>

            <div class="p-6 space-y-8 bg-slate-50/60">
                {{-- Identity --}}
                <div x-show="tab === 'identity'" x-cloak class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Identity</h3>
                            <p class="text-sm text-slate-500">Update your basic account information.</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('profile.update.identity') }}" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">First Name</label>
                                <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required
                                       class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Last Name</label>
                                <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required
                                       class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-md">
                                Save Identity
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Contact --}}
                <div x-show="tab === 'contact'" x-cloak class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Contact</h3>
                            <p class="text-sm text-slate-500">How people can reach you.</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('profile.update.contact') }}" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Phone</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                       class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Affiliation</label>
                                <input type="text" name="affiliation" value="{{ old('affiliation', $user->affiliation) }}"
                                       class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">ORCID</label>
                            <input type="text" name="orcid" value="{{ old('orcid', $user->orcid) }}"
                                   class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200" placeholder="0000-0000-0000-0000">
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-md">
                                Save Contact
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Public --}}
                <div x-show="tab === 'public'" x-cloak class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Public Profile</h3>
                            <p class="text-sm text-slate-500">Photo and bio visible to others.</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('profile.update.public') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="flex items-center space-x-4">
                            <div class="w-20 h-20 rounded-full overflow-hidden bg-slate-100 border">
                                @if($user->profile_image)
                                    <img src="{{ Storage::url($user->profile_image) }}" alt="Profile" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">No photo</div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Profile Image</label>
                                <input type="file" name="profile_image" accept="image/*"
                                       class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="text-xs text-gray-500 mt-1">Max 2MB. Square images look best.</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Bio</label>
                            <textarea name="bio" rows="4" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200" placeholder="Tell readers about yourself">{{ old('bio', $user->bio) }}</textarea>
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-md">
                                Save Public Profile
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Password --}}
                <div x-show="tab === 'password'" x-cloak class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Password</h3>
                            <p class="text-sm text-slate-500">Keep your account secure.</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('profile.update.password') }}" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Current Password</label>
                                <input type="password" name="current_password" required
                                       class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">New Password</label>
                                <input type="password" name="password" required
                                       class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Confirm Password</label>
                                <input type="password" name="password_confirmation" required
                                       class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            </div>
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-md">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Notifications --}}
                <div x-show="tab === 'notifications'" x-cloak class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Notifications</h3>
                            <p class="text-sm text-slate-500">Choose what emails you receive.</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('profile.update.notifications') }}" class="space-y-4">
                        @csrf
                        <div class="space-y-3">
                            <label class="flex items-start space-x-3 bg-white border border-slate-200 rounded-xl p-3 shadow-sm hover:border-blue-400 transition">
                                <input type="checkbox" name="notify_system" value="1" @checked(old('notify_system', $user->notify_system))
                                       class="h-5 w-5 text-blue-600 border-slate-300 focus:ring-blue-500 rounded">
                                <div>
                                    <p class="font-semibold text-slate-800">System & submission updates</p>
                                    <p class="text-sm text-slate-500">Emails about submissions, reviews, and status changes.</p>
                                </div>
                            </label>
                            <label class="flex items-start space-x-3 bg-white border border-slate-200 rounded-xl p-3 shadow-sm hover:border-blue-400 transition">
                                <input type="checkbox" name="notify_marketing" value="1" @checked(old('notify_marketing', $user->notify_marketing))
                                       class="h-5 w-5 text-blue-600 border-slate-300 focus:ring-blue-500 rounded">
                                <div>
                                    <p class="font-semibold text-slate-800">Announcements & newsletters</p>
                                    <p class="text-sm text-slate-500">Journal news, calls for papers, and occasional updates.</p>
                                </div>
                            </label>
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-md">
                                Save Notifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

