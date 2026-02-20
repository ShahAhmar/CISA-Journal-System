@extends('layouts.app')

@section('title', 'Register - CISA Interdisciplinary Journal')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-50 via-purple-100 to-purple-50 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse-slow"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse-slow" style="animation-delay: 2s;"></div>
    </div>

    <div class="max-w-3xl w-full relative z-10">
        <!-- Logo & Header -->
        <div class="text-center mb-10">
            <div class="inline-block mb-6">
                <div class="w-24 h-24 bg-gradient-to-br from-purple-600 to-purple-800 rounded-3xl flex items-center justify-center shadow-2xl transform hover:rotate-6 transition-transform duration-300 mx-auto">
                    <i class="fas fa-user-plus text-white text-4xl"></i>
                </div>
            </div>
            <h1 class="text-5xl font-bold font-display bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent mb-3">
                Create Your Account
            </h1>
            <p class="text-lg text-gray-600">Join CISA Interdisciplinary Journal and publish your research</p>
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

        <!-- Registration Form -->
        <div class="bg-white rounded-2xl shadow-2xl border-t-4 border-t-purple-600 p-8 transform hover:shadow-3xl transition-all duration-300">
            <form class="space-y-6" method="POST" action="{{ route('register') }}" id="registerForm" 
                  x-data="{ 
                      showPassword: false, 
                      showConfirmPassword: false,
                      loading: false,
                      password: '',
                      passwordStrength: 0,
                      checkPasswordStrength(pwd) {
                          if (!pwd) return 0;
                          let strength = 0;
                          if (pwd.length >= 8) strength++;
                          if (pwd.match(/[a-z]+/)) strength++;
                          if (pwd.match(/[A-Z]+/)) strength++;
                          if (pwd.match(/[0-9]+/)) strength++;
                          if (pwd.match(/[$@#&!]+/)) strength++;
                          return strength;
                      }
                  }"
                  @submit="loading = true">
                @csrf
                
                <!-- Name Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-purple-600"></i>First Name <span class="text-red-500">*</span>
                        </label>
                        <input id="first_name" name="first_name" type="text" required 
                               class="w-full px-4 py-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 {{ $errors->has('first_name') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}" 
                               placeholder="John" 
                               value="{{ old('first_name') }}">
                        @error('first_name')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-purple-600"></i>Last Name <span class="text-red-500">*</span>
                        </label>
                        <input id="last_name" name="last_name" type="text" required 
                               class="w-full px-4 py-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 {{ $errors->has('last_name') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}" 
                               placeholder="Doe" 
                               value="{{ old('last_name') }}">
                        @error('last_name')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-purple-600"></i>Email Address <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input id="email" name="email" type="email" required 
                               class="w-full px-4 py-4 pl-12 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 {{ $errors->has('email') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}" 
                               placeholder="your.email@example.com" 
                               value="{{ old('email') }}">
                        <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        @error('email')
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                            </div>
                        @enderror
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-purple-600"></i>Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input id="password" name="password" 
                                   :type="showPassword ? 'text' : 'password'" 
                                   required 
                                   class="w-full px-4 py-4 pl-12 pr-12 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 {{ $errors->has('password') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}" 
                                   placeholder="Min. 8 characters"
                                   x-model="password"
                                   @input="passwordStrength = checkPasswordStrength($event.target.value)">
                            <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <button type="button" 
                                    @click="showPassword = !showPassword"
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-purple-600 transition-colors duration-300 focus:outline-none">
                                <i class="fas text-lg" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        
                        <!-- Password Strength Indicator -->
                        <div x-show="password && password.length > 0" x-cloak class="mt-3">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-semibold text-gray-600">Password Strength:</span>
                                <span class="text-xs font-bold" 
                                      :class="{
                                          'text-red-500': passwordStrength <= 1,
                                          'text-orange-500': passwordStrength === 2,
                                          'text-yellow-500': passwordStrength === 3,
                                          'text-green-500': passwordStrength === 4,
                                          'text-green-600': passwordStrength >= 5
                                      }"
                                      x-text="{
                                          0: 'Very Weak',
                                          1: 'Weak',
                                          2: 'Fair',
                                          3: 'Good',
                                          4: 'Strong',
                                          5: 'Very Strong'
                                      }[passwordStrength] || 'Very Weak'"></span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                <div class="h-2.5 rounded-full transition-all duration-500"
                                     :class="{
                                         'bg-red-500 w-1/5': passwordStrength <= 1,
                                         'bg-orange-500 w-2/5': passwordStrength === 2,
                                         'bg-yellow-500 w-3/5': passwordStrength === 3,
                                         'bg-green-500 w-4/5': passwordStrength === 4,
                                         'bg-green-600 w-full': passwordStrength >= 5
                                     }"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>Use 8+ characters with uppercase, lowercase, numbers & symbols
                            </p>
                        </div>
                        
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-purple-600"></i>Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input id="password_confirmation" name="password_confirmation" 
                                   :type="showConfirmPassword ? 'text' : 'password'" 
                                   required 
                                   class="w-full px-4 py-4 pl-12 pr-12 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 {{ $errors->has('password_confirmation') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '' }}" 
                                   placeholder="Re-enter password">
                            <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <button type="button" 
                                    @click="showConfirmPassword = !showConfirmPassword"
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-purple-600 transition-colors duration-300 focus:outline-none">
                                <i class="fas text-lg" :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Affiliation Field -->
                <div>
                    <label for="affiliation" class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-university mr-2 text-purple-600"></i>Affiliation <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                    </label>
                    <input id="affiliation" name="affiliation" type="text" 
                           class="w-full px-4 py-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300" 
                           placeholder="University/Institution" 
                           value="{{ old('affiliation') }}">
                    <p class="mt-2 text-xs text-gray-500 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>Your university or research institution
                    </p>
                </div>

                <!-- ORCID Field -->
                <div>
                    <label for="orcid" class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-id-card mr-2 text-purple-600"></i>ORCID ID <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                    </label>
                    <div class="relative">
                        <input id="orcid" name="orcid" type="text" 
                               class="w-full px-4 py-4 pl-12 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300" 
                               placeholder="0000-0000-0000-0000" 
                               value="{{ old('orcid') }}"
                               pattern="[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}">
                        <i class="fas fa-id-card absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>Your unique researcher identifier (format: 0000-0000-0000-0000)
                    </p>
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-start bg-purple-50 p-5 rounded-xl border-2 border-purple-100">
                    <input id="terms" name="terms" type="checkbox" required
                           class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded mt-1 cursor-pointer">
                    <label for="terms" class="ml-3 block text-sm text-gray-700 cursor-pointer">
                        I agree to the <a href="#" class="text-purple-600 hover:text-purple-800 font-bold underline transition-colors duration-300">Terms & Conditions</a> 
                        and <a href="#" class="text-purple-600 hover:text-purple-800 font-bold underline transition-colors duration-300">Privacy Policy</a>
                        <span class="text-red-500">*</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 relative overflow-hidden"
                            :disabled="loading">
                        <span x-show="!loading" class="flex items-center justify-center">
                            <i class="fas fa-user-plus mr-3"></i>
                            <span class="text-lg">Create Account</span>
                        </span>
                        <span x-show="loading" class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-lg">Creating account...</span>
                        </span>
                    </button>
                </div>

                <!-- Divider -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t-2 border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500 font-semibold">Already have an account?</span>
                    </div>
                </div>

                <!-- Login Link -->
                <div>
                    <a href="{{ route('login') }}" class="w-full bg-white border-2 border-purple-600 text-purple-600 hover:bg-purple-50 font-bold py-4 px-6 rounded-xl shadow-md hover:shadow-lg transform hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 inline-flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-3"></i>
                        <span class="text-lg">Sign In Instead</span>
                    </a>
                </div>
            </form>
        </div>

        <!-- Security Info -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-600 flex items-center justify-center">
                <i class="fas fa-shield-alt mr-2 text-purple-600 text-lg"></i>
                Your information is protected and secure with SSL encryption
            </p>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
