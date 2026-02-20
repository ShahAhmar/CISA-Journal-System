@extends('layouts.app')

@section('title', 'Submission Successful - ' . $submission->journal->name . ' | EMANP')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-green-600 to-green-700 text-white py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <div class="inline-block mb-6">
                <div class="w-24 h-24 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto">
                    <i class="fas fa-check-circle text-6xl"></i>
                </div>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4 font-display">Paper Successfully Submitted!</h1>
            <p class="text-lg text-green-100 max-w-3xl mx-auto">
                Your manuscript has been received and is now in the review process
            </p>
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<div class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('journals.index') }}" class="text-[#0056FF] hover:text-[#0044CC] transition-colors">
                <i class="fas fa-home"></i> Home
            </a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <a href="{{ route('author.submissions.index') }}" class="text-[#0056FF] hover:text-[#0044CC] transition-colors">
                My Submissions
            </a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <span class="text-gray-600">Submission Successful</span>
        </nav>
    </div>
</div>

<!-- Success Content -->
<section class="bg-white py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-100 p-8 md:p-12">
            <!-- Submission Details -->
            <div class="text-center mb-8">
                <div class="inline-block bg-green-100 rounded-full p-4 mb-4">
                    <i class="fas fa-check-circle text-green-600 text-4xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-[#0F1B4C] mb-2">Submission Received</h2>
                <p class="text-gray-600">Your submission has been successfully submitted to the editorial office.</p>
            </div>

            <!-- Submission Info Card -->
            <div class="bg-[#F7F9FC] rounded-xl p-6 mb-8 border-2 border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Paper ID</label>
                        <p class="text-2xl font-bold text-[#0056FF]">#{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Status</label>
                        <span class="inline-block px-4 py-2 bg-blue-100 text-blue-800 rounded-lg font-semibold">
                            <i class="fas fa-clock mr-2"></i>Waiting for Editor Review
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Journal</label>
                        <p class="text-lg font-semibold text-[#0F1B4C]">{{ $submission->journal->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Submitted Date</label>
                        <p class="text-lg font-semibold text-[#0F1B4C]">
                            @if($submission->submitted_at)
                                {{ \Carbon\Carbon::parse($submission->submitted_at)->format('F d, Y') }}
                            @else
                                {{ \Carbon\Carbon::parse($submission->created_at)->format('F d, Y') }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Submission Details -->
            <div class="space-y-4 mb-8">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="font-semibold text-[#0F1B4C] mb-2">Title</h3>
                    <p class="text-gray-700">{{ $submission->title }}</p>
                </div>
                
                @if($submission->journalSection)
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="font-semibold text-[#0F1B4C] mb-2">Section</h3>
                    <p class="text-gray-700">{{ $submission->journalSection->title }}</p>
                </div>
                @endif

                <div class="border-b border-gray-200 pb-4">
                    <h3 class="font-semibold text-[#0F1B4C] mb-2">Authors</h3>
                    <ul class="list-disc list-inside text-gray-700">
                        @foreach($submission->authors as $author)
                        <li>{{ $author->first_name }} {{ $author->last_name }} 
                            @if($author->is_corresponding)
                            <span class="text-blue-600 text-sm">(Corresponding Author)</span>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-blue-50 rounded-xl p-6 mb-8 border-2 border-blue-200">
                <h3 class="font-semibold text-[#0F1B4C] mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>What Happens Next?
                </h3>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1"></i>
                        <span>Your submission will be reviewed by the editorial team</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1"></i>
                        <span>You will receive email notifications about status updates</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1"></i>
                        <span>You can track your submission status in your dashboard</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-2 mt-1"></i>
                        <span>Average review time: 3-6 weeks</span>
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('author.submissions.show', $submission) }}" 
                   class="px-8 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors shadow-lg text-center">
                    <i class="fas fa-eye mr-2"></i>View Submission Details
                </a>
                <a href="{{ route('author.submissions.index') }}" 
                   class="px-8 py-3 bg-white hover:bg-gray-50 text-[#0F1B4C] border-2 border-[#0F1B4C] rounded-lg font-semibold transition-colors text-center">
                    <i class="fas fa-list mr-2"></i>My Submissions
                </a>
                <a href="{{ route('journals.show', $submission->journal) }}" 
                   class="px-8 py-3 bg-white hover:bg-gray-50 text-[#0F1B4C] border-2 border-[#0F1B4C] rounded-lg font-semibold transition-colors text-center">
                    <i class="fas fa-book mr-2"></i>Back to Journal
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

