<div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl p-8 text-center">
    <h3 class="text-2xl font-bold mb-3">{{ $title }}</h3>
    @if($text)
    <p class="text-blue-100 mb-6">{{ $text }}</p>
    @endif
    <a href="{{ $buttonLink }}" class="inline-block bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
        {{ $buttonText }}
    </a>
</div>

