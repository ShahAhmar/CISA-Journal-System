@extends('layouts.app')

@section('title', $customPage->meta_title ?? $customPage->title . ' - ' . $journal->name)

@section('meta_description', $customPage->meta_description)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-8 mb-8">
            <h1 class="text-4xl font-bold text-[#0F1B4C] mb-4">{{ $customPage->title }}</h1>
            @if($customPage->meta_description)
            <p class="text-lg text-gray-600">{{ $customPage->meta_description }}</p>
            @endif
        </div>

        <!-- Page Content -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-8 mb-8">
            @if($customPage->content)
            <div class="prose max-w-none">
                {!! $customPage->content !!}
            </div>
            @endif

            <!-- Render Widgets -->
            @if($customPage->widgets && count($customPage->widgets) > 0)
            <div class="mt-8 space-y-8">
                @foreach($customPage->widgets as $widget)
                <div class="widget-container">
                    {!! \App\Helpers\WidgetRenderer::render($widget) !!}
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

