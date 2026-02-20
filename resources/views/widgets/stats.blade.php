<div class="grid grid-cols-2 md:grid-cols-4 gap-6">
    @foreach($items as $item)
    <div class="text-center">
        <div class="text-4xl font-bold text-blue-600 mb-2">{{ $item['number'] ?? '0' }}</div>
        <div class="text-sm text-gray-600">{{ $item['label'] ?? 'Stat' }}</div>
    </div>
    @endforeach
</div>

