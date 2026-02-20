@extends('layouts.app')

@section('title', 'Plagiarism Check Service - CISA Interdisciplinary Journal')

@section('content')
    <div class="bg-gradient-to-br from-[#0F1B4C] to-[#1a2b6d] py-20 text-white relative overflow-hidden">
        <!-- Animated background -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0"
                style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 30px 30px;">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div
                class="inline-block px-4 py-1.5 bg-blue-500/20 rounded-full border border-blue-400/30 text-blue-300 font-semibold text-sm mb-6 backdrop-blur-sm">
                <i class="fas fa-shield-alt mr-2"></i>Institutional Grade Analysis
            </div>
            <h1 class="text-4xl md:text-6xl font-bold mb-6 italic" style="font-family: 'Playfair Display', serif;">
                Professional Plagiarism Check
            </h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto mb-10 leading-relaxed font-light">
                Ensure your manuscript's integrity with our comprehensive similarity analysis.
                We use industry-leading tools to provide a detailed report within 24-48 hours.
            </p>

            <div class="flex flex-wrap justify-center gap-6">
                <div class="flex items-center space-x-2 text-blue-200">
                    <i class="fas fa-check-circle text-green-400"></i>
                    <span class="text-sm font-medium">Turnitin Powered</span>
                </div>
                <div class="flex items-center space-x-2 text-blue-200">
                    <i class="fas fa-check-circle text-green-400"></i>
                    <span class="text-sm font-medium">Certificated Report</span>
                </div>
                <div class="flex items-center space-x-2 text-blue-200">
                    <i class="fas fa-check-circle text-green-400"></i>
                    <span class="text-sm font-medium">10% Threshold Guarantee</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-5">
                    <!-- Pricing/Info Side -->
                    <div class="md:col-span-2 bg-[#F7F9FC] p-8 md:p-12 border-r border-gray-100">
                        <div class="mb-8">
                            <span class="text-gray-500 text-sm font-bold uppercase tracking-wider">Service Fee</span>
                            <div class="flex items-baseline mt-2">
                                <span class="text-4xl font-bold text-[#0F1B4C]">$20</span>
                                <span class="text-gray-500 ml-2">/ manuscript</span>
                            </div>
                        </div>

                        <ul class="space-y-4 mb-10">
                            <li class="flex items-start">
                                <i class="fas fa-file-pdf text-[#0056FF] mt-1 mr-3"></i>
                                <span class="text-sm text-gray-700">Full similarity report PDF</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-clock text-[#0056FF] mt-1 mr-3"></i>
                                <span class="text-sm text-gray-700">24-hour turnaround</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-search text-[#0056FF] mt-1 mr-3"></i>
                                <span class="text-sm text-gray-700">Source-by-source breakdown</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-user-shield text-[#0056FF] mt-1 mr-3"></i>
                                <span class="text-sm text-gray-700">Privacy guaranteed</span>
                            </li>
                        </ul>

                        <div class="p-4 bg-white rounded-xl border border-gray-200 shadow-sm">
                            <p class="text-xs text-gray-500 italic">
                                "High-quality plagiarism checks are essential for academic career growth. Our reports are
                                recognized by top journals worldwide."
                            </p>
                        </div>
                    </div>

                    <!-- Form Side -->
                    <div class="md:col-span-3 p-8 md:p-12">
                        <h2 class="text-2xl font-bold text-[#0F1B4C] mb-6">Upload Your Manuscript</h2>

                        <form action="{{ route('plagiarism.process') }}" method="POST" enctype="multipart/form-data"
                            class="space-y-6">
                            @csrf

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Select File</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 hover:border-[#0056FF] hover:bg-blue-50/30 transition-all group text-center cursor-pointer"
                                    onclick="document.getElementById('manuscript').click()">
                                    <input type="file" name="manuscript" id="manuscript" class="hidden" required
                                        accept=".doc,.docx,.pdf">
                                    <i
                                        class="fas fa-cloud-upload-alt text-4xl text-gray-300 group-hover:text-[#0056FF] transition-colors mb-4"></i>
                                    <p class="text-sm text-gray-600 group-hover:text-gray-900 transition-colors">
                                        Click to upload or drag and drop
                                    </p>
                                    <p class="text-xs text-gray-400 mt-2">DOC, DOCX, or PDF (Max 10MB)</p>
                                    <div id="filename-display" class="mt-4 text-sm font-bold text-green-600 hidden"></div>
                                </div>
                                @error('manuscript')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-start">
                                <input type="checkbox" id="terms" required
                                    class="mt-1 h-4 w-4 text-[#0056FF] rounded border-gray-300">
                                <label for="terms" class="ml-3 text-sm text-gray-600">
                                    I agree to the terms of service and recognize that this service fee is non-refundable
                                    once the analysis begins.
                                </label>
                            </div>

                            <button type="submit"
                                class="w-full bg-[#0056FF] hover:bg-[#0044CC] text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.01] transition-all flex items-center justify-center space-x-3">
                                <span>Proceed to Payment</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('manuscript').addEventListener('change', function (e) {
            const display = document.getElementById('filename-display');
            if (this.files && this.files.length > 0) {
                display.textContent = 'Selected: ' + this.files[0].name;
                display.classList.remove('hidden');
            } else {
                display.classList.add('hidden');
            }
        });
    </script>
@endsection