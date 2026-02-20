@extends('layouts.app')

@section('title', $journal->name . ' - Issues')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $journal->name }}</h1>
    <h2 class="text-2xl font-semibold text-gray-800 mb-8">Issues</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($issues as $issue)
            <div class="card hover:shadow-xl transition-shadow">
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $issue->display_title }}</h3>
                @if($issue->description)
                    <p class="text-gray-600 mb-4">{{ Str::limit($issue->description, 100) }}</p>
                @endif
                @if($issue->published_date)
                    <p class="text-sm text-gray-500 mb-4">Published: {{ $issue->published_date->format('F d, Y') }}</p>
                @endif
                <a href="{{ route('journals.issue', [$journal, $issue]) }}" class="btn btn-primary">
                    View Issue
                </a>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-600 text-lg">No published issues available.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $issues->links() }}
    </div>
</div>
@endsection

