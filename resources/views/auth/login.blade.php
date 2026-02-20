@extends('layouts.app')

@section('title', 'Login - CISA Interdisciplinary Journal')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-50 via-purple-100 to-purple-50 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute top-0 right-0 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse-slow">
            </div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse-slow"
                style="animation-delay: 2s;"></div>
        </div>

        <div class="max-w-md w-full relative z-10">
            <!-- Logo & Header -->
            <div class="text-center mb-10">
                <div class="inline-block mb-6">
                    <div
                        class="w-24 h-24 bg-gradient-to-br from-purple-600 to-purple-800 rounded-3xl flex items-center justify-center shadow-2xl transform hover:rotate-6 transition-transform duration-300 mx-auto">
                        <i class="fas fa-book-open text-white text-4xl"></i>
                    </div>
                </div>
                <h1
                    class="text-5xl font-bold font-display bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent mb-3">
                    Welcome Back
                </h1>
                <p class="text-lg text-gray-600">Sign in to CISA Interdisciplinary Journal</p>
            </div>

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

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-5 rounded-xl shadow-lg animate-slide-down">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 text-2xl mr-4"></i>
                        <span class="text-sm font-bold text-green-800">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Login Form -->
            <div
                class="bg-white rounded-2xl shadow-2xl border-t-4 border-t-purple-600 p-8 transform hover:shadow-3xl transition-all duration-300">
                <form class="space-y-6" method="POST" action="{{ route('login') }}" id="loginForm"
                    x-data="{ showPassword: false, loading: false }" @submit="loading = true">
                    @csrf

                    <!-- Email or Phone Field -->
                    <div>
                        <label for="login" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-purple-600"></i>Email or Phone Number
                        </label>
                        <div class="relative">
                            <input id="login" name="login" type="text" autocomplete="username" required
                                class="w-full px-4 py-4 pl-12 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 {{ $errors->has('login') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}"
                                placeholder="your.email@example.com or phone" value="{{ old('login') }}"
                                @input="loading = false">
                            <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            @error('login')
                                <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                                    <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                                </div>
                            @enderror
                        </div>
                        @error('login')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-purple-600"></i>Password
                        </label>
                        <div class="relative">
                            <input id="password" name="password" :type="showPassword ? 'text' : 'password'"
                                autocomplete="current-password" required
                                class="w-full px-4 py-4 pl-12 pr-12 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 {{ $errors->has('password') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}"
                                placeholder="Enter your password">
                            <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-purple-600 transition-colors duration-300 focus:outline-none">
                                <i class="fas text-lg" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                            @error('password')
                                <div class="absolute right-12 top-1/2 transform -translate-y-1/2">
                                    <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                                </div>
                            @enderror
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox"
                                class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded cursor-pointer">
                            <label for="remember"
                                class="ml-3 block text-sm font-medium text-gray-700 cursor-pointer hover:text-purple-600 transition-colors">
                                Remember me
                            </label>
                        </div>
                        <a href="{{ route('password.request') }}"
                            class="text-sm font-semibold text-purple-600 hover:text-purple-800 transition-all duration-300 hover:underline">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 relative overflow-hidden disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="loading">
                            <span x-show="!loading" class="flex items-center justify-center">
                                <i class="fas fa-sign-in-alt mr-3"></i>
                                <span class="text-lg">Sign In</span>
                            </span>
                            <span x-show="loading" class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-3 h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <span class="text-lg">Signing in...</span>
                            </span>
                        </button>
                    </div>

                    <!-- Divider -->
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t-2 border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500 font-semibold">New to CISA?</span>
                        </div>
                    </div>

                    <!-- Register Link -->
                    <div>
                        <a href="{{ route('register') }}"
                            class="w-full bg-white border-2 border-purple-600 text-purple-600 hover:bg-purple-50 font-bold py-4 px-6 rounded-xl shadow-md hover:shadow-lg transform hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 inline-flex items-center justify-center">
                            <i class="fas fa-user-plus mr-3"></i>
                            <span class="text-lg">Create New Account</span>
                        </a>
                    </div>
                </form>
            </div>

            <!-- Security Info -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600 flex items-center justify-center">
                    <i class="fas fa-shield-alt mr-2 text-purple-600 text-lg"></i>
                    Your data is secure and encrypted with SSL
                </p>
            </div>
        </div>
    </div>
@endsection