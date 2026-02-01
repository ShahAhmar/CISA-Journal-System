@extends('layouts.app')

@section('title', 'Reset Password - EMANP')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse-slow"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse-slow" style="animation-delay: 2s;"></div>
    </div>

    <div class="max-w-md w-full relative z-10">
        <!-- Logo & Header -->
        <div class="text-center mb-10">
            <div class="inline-block mb-6">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl flex items-center justify-center shadow-2xl transform hover:rotate-6 transition-transform duration-300 mx-auto">
                    <i class="fas fa-lock text-white text-4xl"></i>
                </div>
            </div>
            <h1 class="text-5xl font-bold font-display bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-3">
                Reset Password
            </h1>
            <p class="text-lg text-gray-600">Enter your new password below</p>
        </div>

        <!-- Status Messages -->
        @if (session('status'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-5 rounded-xl shadow-lg animate-slide-down">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-2xl mr-4"></i>
                    <span class="text-sm font-bold text-green-800">{{ session('status') }}</span>
                </div>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-5 rounded-xl shadow-lg animate-slide-down">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 text-2xl"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-sm font-bold text-red-800 mb-2">Please fix the following errors:</h3>
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Reset Password Form -->
        <div class="bg-white rounded-2xl shadow-2xl border-t-4 border-t-blue-600 p-8 transform hover:shadow-3xl transition-all duration-300">
            <form class="space-y-6" method="POST" action="{{ route('password.update') }}" x-data="{ showPassword: false, showPasswordConfirmation: false, loading: false }" @submit="loading = true">
                @csrf
                
                <input type="hidden" name="token" value="{{ $token }}">
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-blue-600"></i>Email Address
                    </label>
                    <div class="relative">
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               class="w-full px-4 py-4 pl-12 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 {{ $errors->has('email') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}" 
                               placeholder="your.email@example.com" 
                               value="{{ old('email', $email) }}">
                        <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-blue-600"></i>New Password
                    </label>
                    <div class="relative">
                        <input id="password" name="password" 
                               :type="showPassword ? 'text' : 'password'" 
                               autocomplete="new-password" required 
                               class="w-full px-4 py-4 pl-12 pr-12 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 {{ $errors->has('password') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}" 
                               placeholder="Enter your new password">
                        <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <button type="button" 
                                @click="showPassword = !showPassword"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-600 transition-colors duration-300 focus:outline-none">
                            <i class="fas text-lg" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Confirmation Field -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-blue-600"></i>Confirm New Password
                    </label>
                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" 
                               :type="showPasswordConfirmation ? 'text' : 'password'" 
                               autocomplete="new-password" required 
                               class="w-full px-4 py-4 pl-12 pr-12 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 {{ $errors->has('password_confirmation') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}" 
                               placeholder="Confirm your new password">
                        <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <button type="button" 
                                @click="showPasswordConfirmation = !showPasswordConfirmation"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-600 transition-colors duration-300 focus:outline-none">
                            <i class="fas text-lg" :class="showPasswordConfirmation ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 relative overflow-hidden disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="loading">
                        <span x-show="!loading" class="flex items-center justify-center">
                            <i class="fas fa-key mr-3"></i>
                            <span class="text-lg">Reset Password</span>
                        </span>
                        <span x-show="loading" class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-lg">Resetting...</span>
                        </span>
                    </button>
                </div>

                <!-- Back to Login -->
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-all duration-300 hover:underline">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

