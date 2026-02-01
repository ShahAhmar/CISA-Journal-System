<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CISA Interdisciplinary Journal (CIJ)')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        cisa: {
                            base: '#0f172a', /* Deep Slate Blue */
                            light: '#1e293b',
                            accent: '#f59e0b', /* Gold/Amber */
                            text: '#f8fafc',
                            muted: '#94a3b8',
                        }
                    },
                    boxShadow: {
                        'glass': '0 8px 32px 0 rgba(15, 23, 42, 0.1)',
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Playfair Display', serif;
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .cisa-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        .btn-cisa-primary {
            @apply px-6 py-2.5 rounded-full font-semibold text-white transition-all transform hover:scale-105 shadow-md;
            background: linear-gradient(to right, #f59e0b, #d97706);
        }

        .btn-cisa-outline {
            @apply px-6 py-2.5 rounded-full font-semibold transition-all border-2;
            border-color: #0f172a;
            color: #0f172a;
        }

        .btn-cisa-outline:hover {
            @apply bg-cisa-base text-white;
        }

        /* Alpine.js cloak */
        [x-cloak] {
            display: none !important;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.4s ease-out forwards;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="glass-header sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('journals.index') }}" class="flex items-center space-x-3 group">
                        @if(isset($siteSettings) && $siteSettings->logo)
                            <img src="{{ asset($siteSettings->logo) }}" alt="{{ $siteSettings->homepage_title }}"
                                class="h-10 w-auto object-contain">
                        @else
                            <div
                                class="w-10 h-10 bg-cisa-base rounded-lg flex items-center justify-center text-cisa-accent shadow-lg group-hover:bg-cisa-accent group-hover:text-cisa-base transition-colors">
                                <span class="font-serif font-bold text-xl">C</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-2xl font-bold font-serif text-cisa-base leading-none">CISA</span>
                            </div>
                        @endif
                    </a>
                </div>

                @php
                    // Only show journal-specific navigation if we are on a journal-specific route
                    // and not on the main portal page.
                    $routeName = request()->route() ? request()->route()->getName() : '';
                    $isJournalContext = $routeName && str_starts_with($routeName, 'journals.') && $routeName !== 'journals.index';
                    $navJournal = ($isJournalContext && isset($journal) && $journal instanceof \App\Models\Journal) ? $journal : null;
                @endphp

                <div
                    class="hidden xl:flex items-center space-x-6 text-[13px] uppercase tracking-wider font-bold text-gray-600 ml-10">
                    @if($navJournal)
                        <a href="{{ route('journals.show', $navJournal) }}"
                            class="hover:text-cisa-accent whitespace-nowrap transition-colors relative group {{ request()->routeIs('journals.show') ? 'text-cisa-base' : '' }}">
                            Home
                            <span
                                class="absolute -bottom-1 left-0 w-0 h-0.5 bg-cisa-accent transition-all group-hover:w-full"></span>
                        </a>

                        @if($navJournal->pageSettings->count() > 0)
                            @foreach($navJournal->pageSettings->where('is_enabled', true)->sortBy('display_order') as $page)
                                @php
                                    $routeMap = [
                                        'about' => 'journals.about',
                                        'info' => 'journals.info',
                                        'publications' => 'journals.publications',
                                        'call_for_papers' => 'journals.call-for-papers',
                                        'apc' => 'journals.apc-submission',
                                        'editorial' => 'journals.editorial-ethics',
                                        'partnerships' => 'journals.partnerships',
                                        'contact' => 'journals.contact',
                                    ];
                                    $routeName = $routeMap[$page->page_key] ?? null;
                                @endphp
                                @if($routeName)
                                    @php
                                        $skipPage = false;
                                        if ($page->page_key === 'partnerships') {
                                            $skipPage = empty($navJournal->partnerships_content) && ($navJournal->partners->count() == 0);
                                        }
                                    @endphp

                                    @if(!$skipPage)
                                        <a href="{{ route($routeName, $navJournal) }}"
                                            class="hover:text-cisa-accent whitespace-nowrap transition-colors relative group {{ request()->routeIs($routeName) ? 'text-cisa-base' : '' }}">
                                            {{ $page->menu_label }}
                                            <span
                                                class="absolute -bottom-1 left-0 w-0 h-0.5 bg-cisa-accent transition-all group-hover:w-full"></span>
                                        </a>
                                    @endif
                                @endif
                            @endforeach
                        @else
                            {{-- Fallback for safety --}}
                            <a href="{{ route('journals.about', $navJournal) }}"
                                class="hover:text-cisa-accent whitespace-nowrap transition-colors relative group">About CIJ</a>
                        @endif
                    @else
                        {{-- Generic Portal Menu --}}
                        <a href="{{ route('journals.index') }}"
                            class="hover:text-cisa-accent whitespace-nowrap transition-colors relative group {{ request()->routeIs('journals.index') ? 'text-cisa-base' : '' }}">
                            Portal Home
                            <span
                                class="absolute -bottom-1 left-0 w-0 h-0.5 bg-cisa-accent transition-all group-hover:w-full"></span>
                        </a>
                        <a href="{{ route('publish.index') }}"
                            class="hover:text-cisa-accent whitespace-nowrap transition-colors relative group">
                            Our Journals
                            <span
                                class="absolute -bottom-1 left-0 w-0 h-0.5 bg-cisa-accent transition-all group-hover:w-full"></span>
                        </a>
                    @endif

                    <div class="h-8 w-px bg-gray-200 ml-2"></div>

                    @auth
                        <div class="mr-4">
                            @include('partials.language_switcher')
                        </div>
                        <div class="relative ml-4" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center space-x-2 text-gray-700 hover:text-cisa-base font-medium focus:outline-none">
                                <span
                                    class="w-8 h-8 rounded-full bg-cisa-base text-white flex items-center justify-center text-xs font-bold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </span>
                                <span>{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak style="display: none;"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-glass py-1 border border-gray-100 animate-fade-in z-50">
                                <a href="{{ route('dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Dashboard</a>
                                <a href="{{ route('profile.show') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                                <a href="{{ route('author.payments.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">My Payments</a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-4 ml-4">
                            @include('partials.language_switcher')
                            <a href="{{ route('login') }}"
                                class="text-gray-500 font-medium hover:text-cisa-base transition-colors px-2">
                                Login
                            </a>
                            <a href="{{ $navJournal ? route('author.submissions.create', $navJournal) : route('register') }}"
                                class="px-3 py-1.5 bg-cisa-base text-white font-bold rounded-full border border-cisa-base hover:bg-cisa-accent hover:border-cisa-accent transition-all duration-300 shadow-md text-[11px] uppercase tracking-tight whitespace-nowrap">
                                Submit
                            </a>
                        </div>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center space-x-4">
                    @include('partials.language_switcher')
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                        class="text-gray-700 hover:text-cisa-base focus:outline-none transition-colors">
                        <i class="fas fa-bars text-2xl" x-show="!mobileMenuOpen"></i>
                        <i class="fas fa-times text-2xl" x-show="mobileMenuOpen" x-cloak></i>
                    </button>

                    <!-- Mobile Dropdown Menu -->
                    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-4" @click.away="mobileMenuOpen = false"
                        class="absolute top-20 left-0 right-0 bg-white shadow-xl border-t border-gray-100 z-50 py-4 px-6 overflow-hidden hidden"
                        :class="{ 'hidden': !mobileMenuOpen }" x-cloak>

                        <div class="space-y-4">
                            @if($navJournal)
                                <a href="{{ route('journals.show', $navJournal) }}"
                                    class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-cisa-accent hover:bg-gray-50 rounded-md">Home</a>
                                <a href="{{ route('journals.about', $navJournal) }}"
                                    class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-cisa-accent hover:bg-gray-50 rounded-md">About</a>
                                <a href="{{ route('journals.info', $navJournal) }}"
                                    class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-cisa-accent hover:bg-gray-50 rounded-md">Journal
                                    Info</a>
                                <a href="{{ route('journals.publications', $navJournal) }}"
                                    class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-cisa-accent hover:bg-gray-50 rounded-md">Publications</a>
                                <a href="{{ route('journals.call-for-papers', $navJournal) }}"
                                    class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-cisa-accent hover:bg-gray-50 rounded-md">Call
                                    for Papers</a>
                                <a href="{{ route('journals.contact', $navJournal) }}"
                                    class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-cisa-accent hover:bg-gray-50 rounded-md">Contact</a>
                            @else
                                <a href="{{ route('journals.index') }}"
                                    class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-cisa-accent hover:bg-gray-50 rounded-md">Portal
                                    Home</a>
                                <a href="{{ route('publish.index') }}"
                                    class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-cisa-accent hover:bg-gray-50 rounded-md">Our
                                    Journals</a>
                            @endif

                            <hr class="border-gray-100">

                            @auth
                                <div class="flex items-center space-x-3 py-2 mb-2">
                                    <div
                                        class="w-10 h-10 rounded-full bg-cisa-base text-white flex items-center justify-center font-bold">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <p class="font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('dashboard') }}"
                                    class="block py-2 text-gray-700 hover:text-cisa-accent font-medium">Dashboard</a>
                                <a href="{{ route('profile.show') }}"
                                    class="block py-2 text-gray-700 hover:text-cisa-accent font-medium">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left py-2 text-red-600 font-medium">Logout</button>
                                </form>
                            @else
                                <div class="flex flex-col space-y-3 pt-2">
                                    <a href="{{ $navJournal ? route('author.submissions.create', $navJournal) : route('register') }}"
                                        class="text-center py-2.5 bg-cisa-accent text-cisa-base font-bold rounded-md hover:bg-white transition-all shadow-md text-sm">
                                        Submit Your Manuscript
                                    </a>
                                    <a href="{{ route('login') }}"
                                        class="text-center py-2.5 text-gray-600 font-medium border border-gray-300 rounded-md hover:bg-gray-50 transition-all text-sm">
                                        Login
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="flex-grow">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-6">
                <div
                    class="bg-emerald-50 border border-emerald-100 p-4 text-emerald-700 shadow-lg rounded-2xl flex items-center animate-fadeIn">
                    <i class="fas fa-check-circle mr-3 text-emerald-500"></i>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 mt-6">
                <div
                    class="bg-rose-50 border border-rose-100 p-4 text-rose-700 shadow-lg rounded-2xl flex items-center animate-fadeIn">
                    <i class="fas fa-exclamation-circle mr-3 text-rose-500"></i>
                    <span class="font-bold text-sm">{{ session('error') }}</span>
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-cisa-base text-white pt-16 pb-8 border-t-4 border-cisa-accent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- Brand -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        @if(isset($siteSettings) && $siteSettings->logo)
                            <img src="{{ asset($siteSettings->logo) }}" alt="Logo"
                                class="h-10 w-auto object-contain bg-white rounded-lg p-1">
                        @else
                            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-cisa-base">
                                <span class="font-serif font-bold text-xl">C</span>
                            </div>
                            <span class="text-2xl font-bold font-serif text-white">CISA</span>
                        @endif
                    </div>
                    <p class="text-cisa-muted text-sm leading-relaxed">
                        {{ $siteSettings->footer_description ?? 'Excellence in Management & Academic Network Publishing. Advancing global knowledge through open-access research.' }}
                    </p>
                    <div class="pt-4">
                        @if(!empty($siteSettings->support_button_text) && !empty($siteSettings->support_button_url))
                            <a href="{{ $siteSettings->support_button_url }}"
                                class="inline-block bg-cisa-accent text-cisa-base text-xs font-bold px-4 py-2 rounded-full hover:bg-white transition-colors">
                                {{ $siteSettings->support_button_text }}
                            </a>
                        @endif
                    </div>
                    <div class="flex space-x-4 pt-2">
                        @if(isset($siteSettings) && $siteSettings->twitter_url)
                            <a href="{{ $siteSettings->twitter_url }}" target="_blank"
                                class="text-gray-400 hover:text-cisa-accent transition-colors"><i
                                    class="fab fa-twitter text-lg"></i></a>
                        @endif
                        @if(isset($siteSettings) && $siteSettings->linkedin_url)
                            <a href="{{ $siteSettings->linkedin_url }}" target="_blank"
                                class="text-gray-400 hover:text-cisa-accent transition-colors"><i
                                    class="fab fa-linkedin text-lg"></i></a>
                        @endif
                        @if(isset($siteSettings) && $siteSettings->facebook_url)
                            <a href="{{ $siteSettings->facebook_url }}" target="_blank"
                                class="text-gray-400 hover:text-cisa-accent transition-colors"><i
                                    class="fab fa-facebook text-lg"></i></a>
                        @endif
                        @if(isset($siteSettings) && $siteSettings->instagram_url)
                            <a href="{{ $siteSettings->instagram_url }}" target="_blank"
                                class="text-gray-400 hover:text-cisa-accent transition-colors"><i
                                    class="fab fa-instagram text-lg"></i></a>
                        @endif
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-serif font-bold mb-6 text-cisa-accent">
                        {{ $siteSettings->footer_section_1_title ?? 'Resources' }}
                    </h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li><a href="{{ route('login') }}"
                                class="hover:text-white transition-colors flex items-center"><i
                                    class="fas fa-chevron-right text-cisa-accent text-[10px] mr-2"></i>For Authors</a>
                        </li>
                        <li><a href="{{ route('login') }}"
                                class="hover:text-white transition-colors flex items-center"><i
                                    class="fas fa-chevron-right text-cisa-accent text-[10px] mr-2"></i>For Editors</a>
                        </li>
                        <li><a href="{{ route('login') }}"
                                class="hover:text-white transition-colors flex items-center"><i
                                    class="fas fa-chevron-right text-cisa-accent text-[10px] mr-2"></i>For Reviewers</a>
                        </li>
                        <li><a href="{{ isset($navJournal) ? route('journals.call-for-papers', $navJournal) : route('login') }}"
                                class="hover:text-white transition-colors flex items-center"><i
                                    class="fas fa-chevron-right text-cisa-accent text-[10px] mr-2"></i>Submission
                                Guidelines</a></li>
                    </ul>
                </div>

                <!-- Journals -->
                <div>
                    <h4 class="text-lg font-serif font-bold mb-6 text-cisa-accent">
                        {{ $siteSettings->footer_section_2_title ?? 'Journals' }}
                    </h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li><a href="{{ route('journals.index') }}"
                                class="hover:text-white transition-colors flex items-center"><i
                                    class="fas fa-chevron-right text-cisa-accent text-[10px] mr-2"></i>Browse All</a>
                        </li>
                        <li><a href="{{ isset($navJournal) ? route('journals.about', $navJournal) : '#' }}"
                                class="hover:text-white transition-colors flex items-center"><i
                                    class="fas fa-chevron-right text-cisa-accent text-[10px] mr-2"></i>Open Access
                                Policy</a></li>
                        <li><a href="{{ isset($navJournal) ? route('journals.editorial-ethics', $navJournal) : '#' }}"
                                class="hover:text-white transition-colors flex items-center"><i
                                    class="fas fa-chevron-right text-cisa-accent text-[10px] mr-2"></i>Peer Review
                                Process</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-serif font-bold mb-6 text-cisa-accent">
                        {{ $siteSettings->footer_section_3_title ?? 'Contact' }}
                    </h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-cisa-accent"></i>
                            <span>{{ $siteSettings->contact_address ?? '123 Academic Way, Research City, RC 10010' }}</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-cisa-accent"></i>
                            <span>{{ $siteSettings->contact_email ?? 'editor@cisajournal.com' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div
                class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
                <div class="mb-4 md:mb-0">
                    <p>{!! $siteSettings->footer_text ?? '&copy; ' . date('Y') . ' CISA Interdisciplinary Journal. All rights reserved.' !!}
                    </p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>