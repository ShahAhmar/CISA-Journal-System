@extends('layouts.admin')

@section('title', 'Language Management - EMANP')
@section('page-title', 'Language Management')
@section('page-subtitle', 'Manage system languages and translations')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
        <div>
            <h3 class="text-xl font-bold text-[#0F1B4C]">Available Languages</h3>
            <p class="text-gray-600 mt-1">Manage system languages and set default language</p>
        </div>
    </div>

    <!-- Languages Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($languages as $code => $data)
        <div class="bg-white rounded-xl border-2 {{ $data['is_active'] ? 'border-[#0056FF]' : 'border-gray-200' }} p-6 hover:shadow-lg transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <span class="text-4xl">{{ $data['info']['flag'] }}</span>
                    <div>
                        <h4 class="text-lg font-bold text-[#0F1B4C]">{{ $data['info']['name'] }}</h4>
                        <p class="text-sm text-gray-600">{{ $data['info']['native'] }}</p>
                    </div>
                </div>
                @if($data['is_active'])
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                    Active
                </span>
                @endif
            </div>
            
            <div class="mb-4">
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-gray-600">Translation Files:</span>
                    <span class="font-semibold text-[#0F1B4C]">{{ $data['files'] }}</span>
                </div>
            </div>
            
            @if(!$data['is_active'])
            <form method="POST" action="{{ route('admin.languages.set-default') }}" class="mt-4">
                @csrf
                <input type="hidden" name="locale" value="{{ $code }}">
                <button type="submit" class="w-full px-4 py-2 bg-[#0056FF] text-white rounded-lg hover:bg-[#0044CC] transition-colors font-semibold">
                    <i class="fas fa-check mr-2"></i>Set as Default
                </button>
            </form>
            @else
            <div class="mt-4 px-4 py-2 bg-green-50 text-green-700 rounded-lg text-center font-semibold">
                <i class="fas fa-check-circle mr-2"></i>Current Default
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Language Switcher Info -->
    <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-6">
        <div class="flex items-start space-x-3">
            <i class="fas fa-info-circle text-blue-600 text-xl mt-1"></i>
            <div>
                <h4 class="font-bold text-blue-900 mb-2">Language Switcher</h4>
                <p class="text-sm text-blue-800">
                    Users can switch languages using the language switcher on the frontend. 
                    The default language is used when no language is selected.
                </p>
                <p class="text-sm text-blue-800 mt-2">
                    <strong>Current Default:</strong> {{ $currentLocale === 'en' ? 'English' : ($currentLocale === 'ur' ? 'Urdu' : 'Arabic') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

