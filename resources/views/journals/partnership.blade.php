@extends('layouts.app')

@section('title', 'Partnership - CISA Interdisciplinary Journal')

@section('content')
    <!-- Ultra Professional Partnership Hero -->
    <section class="relative bg-[#0F1B4C] text-white py-24 md:py-32 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0"
                style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div
                class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-6">
                <i class="fas fa-handshake text-yellow-300 mr-2 text-sm"></i>
                <span class="text-white text-sm font-semibold">Join Our Global Mission</span>
            </div>
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight"
                style="font-family: 'Playfair Display', serif; letter-spacing: -0.02em;">
                Partnership for Impact
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 mb-10 font-medium leading-relaxed max-w-3xl mx-auto">
                Bridging international knowledge gaps through interdisciplinary research and global collaboration.
            </p>
            <div class="flex flex-wrap justify-center gap-6">
                <a href="#donors"
                    class="px-8 py-4 bg-white text-[#0F1B4C] rounded-xl text-lg font-bold shadow-2xl hover:bg-blue-50 transition-all duration-200 transform hover:scale-105">
                    Support as Donor
                </a>
                <a href="#universities"
                    class="px-8 py-4 bg-transparent border-2 border-white/50 text-white rounded-xl text-lg font-bold hover:bg-white/10 transition-all duration-200">
                    University Membership
                </a>
            </div>
        </div>
    </section>

    <!-- Why Partner With Us -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-[#0F1B4C] mb-4 font-display">Why Partner with CIJ?</h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto rounded-full mb-8"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">We offer a unique platform for institutions and
                    individuals to contribute to the global academic landscape.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 bg-gray-50 rounded-3xl border border-gray-100 hover:shadow-xl transition-all duration-300">
                    <div
                        class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-3xl mb-6">
                        <i class="fas fa-globe-africa"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-[#0F1B4C] mb-4">Global Reach</h3>
                    <p class="text-gray-600 leading-relaxed">Our open-access model ensures that your research or
                        institutional support reaches scholars in over 150 countries, especially in developing regions.</p>
                </div>

                <div class="p-8 bg-gray-50 rounded-3xl border border-gray-100 hover:shadow-xl transition-all duration-300">
                    <div
                        class="w-16 h-16 bg-purple-600 rounded-2xl flex items-center justify-center text-white text-3xl mb-6">
                        <i class="fas fa-microscope"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-[#0F1B4C] mb-4">Quality & Ethics</h3>
                    <p class="text-gray-600 leading-relaxed">We maintain rigorous double-blind peer review standards and
                        strict anti-plagiarism policies, supported by advanced technology.</p>
                </div>

                <div class="p-8 bg-gray-50 rounded-3xl border border-gray-100 hover:shadow-xl transition-all duration-300">
                    <div
                        class="w-16 h-16 bg-emerald-600 rounded-2xl flex items-center justify-center text-white text-3xl mb-6">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-[#0F1B4C] mb-4">Resource Access</h3>
                    <p class="text-gray-600 leading-relaxed">Partners receive priority access to our training workshops,
                        author resources, and professional editorial support services.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Donors Section -->
    <section id="donors" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-[3rem] p-12 md:p-20 shadow-2xl border border-blue-50 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-600/5 rounded-full -mr-32 -mt-32"></div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center relative z-10">
                    <div>
                        <h2 class="text-4xl font-bold text-[#0F1B4C] mb-6 font-display">Support as a Donor</h2>
                        <p class="text-lg text-gray-700 mb-8 leading-relaxed">
                            Your donations directly support low-income researchers, provide APC waivers, and help us
                            maintain our robust technical infrastructure. Help us keep knowledge accessible to all.
                        </p>
                        <ul class="space-y-4 mb-10 text-gray-700">
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i> Fund APC waivers
                                for authors from developing nations</li>
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i> Sponsor specific
                                interdisciplinary research series</li>
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i> Recognition on
                                our "Supporters" wall</li>
                        </ul>
                        <a href="#"
                            class="inline-flex items-center px-10 py-5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-2xl font-bold text-lg shadow-xl hover:shadow-blue-500/50 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-heart mr-2"></i> Make a Donation
                        </a>
                    </div>
                    <div class="hidden lg:block">
                        <img src="https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?auto=format&fit=crop&q=80&w=1000"
                            alt="Donate" class="rounded-3xl shadow-2xl">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- University Membership -->
    <section id="universities" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-[#0F1B4C] rounded-[3rem] p-12 md:p-20 shadow-2xl relative overflow-hidden text-white">
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full -ml-32 -mb-32"></div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center relative z-10">
                    <div class="order-2 lg:order-1 hidden lg:block">
                        <img src="https://images.unsplash.com/photo-1523050853063-913ec989e9c3?auto=format&fit=crop&q=80&w=1000"
                            alt="University" class="rounded-3xl shadow-2xl opacity-90">
                    </div>
                    <div class="order-1 lg:order-2">
                        <h2 class="text-4xl font-bold mb-6 font-display">University Membership</h2>
                        <p class="text-lg text-blue-100 mb-8 leading-relaxed">
                            Institutions can join as Member Partners to provide their faculty and students with unlimited
                            publishing opportunities and premium research tools.
                        </p>
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 mb-8 border border-white/20">
                            <h4 class="font-bold mb-4 text-white">Membership Benefits:</h4>
                            <ul class="space-y-3 text-blue-100 text-sm">
                                <li class="flex items-center"><i class="fas fa-star text-yellow-400 mr-3"></i> Annual
                                    flat-fee for all faculty publications</li>
                                <li class="flex items-center"><i class="fas fa-star text-yellow-400 mr-3"></i> Dedicated
                                    institutional dashboard</li>
                                <li class="flex items-center"><i class="fas fa-star text-yellow-400 mr-3"></i> Priority
                                    peer-review for institutional submissions</li>
                            </ul>
                        </div>
                        <a href="#"
                            class="inline-flex items-center px-10 py-5 bg-white text-[#0F1B4C] rounded-2xl font-bold text-lg shadow-xl hover:bg-blue-50 transition-all duration-300 transform hover:scale-105">
                            Inquire for Membership
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection