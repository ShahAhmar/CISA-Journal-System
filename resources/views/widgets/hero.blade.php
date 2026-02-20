<div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-16 px-4 rounded-xl">
    <div class="max-w-4xl mx-auto text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $title }}</h1>
        @if($subtitle)
        <p class="text-xl md:text-2xl mb-8 text-blue-100">{{ $subtitle }}</p>
        @endif
        @if($buttonText)
        <a href="{{ $buttonLink }}" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
            {{ $buttonText }}
        </a>
        @endif
    </div>
</div>

