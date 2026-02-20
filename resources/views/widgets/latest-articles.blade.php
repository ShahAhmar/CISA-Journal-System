<div class="space-y-4">
    <h3 class="text-2xl font-bold text-gray-900 mb-6">Latest Articles</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($articles as $article)
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
            <div class="p-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-2">
                    <a href="{{ route('journals.article', [$article->journal->slug, $article]) }}" class="hover:text-blue-600">
                        {{ $article->title }}
                    </a>
                </h4>
                @if($showExcerpt && $article->abstract)
                <p class="text-sm text-gray-600 line-clamp-3">{{ Str::limit($article->abstract, 150) }}</p>
                @endif
                <div class="mt-4 flex items-center justify-between text-xs text-gray-500">
                    <span>{{ $article->journal->name }}</span>
                    <span>{{ $article->formatted_published_at ?? '' }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

