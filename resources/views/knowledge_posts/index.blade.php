<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ナレッジ一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 成功メッセージ --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- 検索フォーム --}}
            <form method="GET" action="{{ route('knowledge-posts.index') }}" class ="mb-6 flex gap-2">
                <input type="text" name="keyword" placeholder="タイトル検索" value="{{ request('keyword') }}"
                    class= "border px-3 py-2 rounded w-full sm:w-1/3">

                <button class="bg-gray-700 text-white px-4 py-2 rounded">
                    検索
                </button>
            </form>

            {{-- 新規投稿ボタン --}}
            <div class="mb-4">
                <a href="{{ route('knowledge-posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                    新規投稿
                </a>
            </div>

            {{-- 一覧 --}}
            @forelse($posts as $post)
                <div class="bg-white p-4 mb-4 rounded shadow">

                    {{-- タイトル --}}
                    <h3 class="font-bold text-lg">
                        <a href="{{ route('knowledge-posts.show', $post) }}" class="text-blue-600 hover:underline">
                            {{ $post->knowledge_title }}
                        </a>
                    </h3>

                    {{-- 投稿・日付 --}}
                    <p class="text-sm text-gray-500 mt-1">
                        投稿 : {{ $post->user->name }}
                        {{ optional($post->published_at)->format('Y/m/d') ?? '未公開' }}
                    </p>

                    {{-- タグ --}}
                    <div class="mt-2">
                        @if ($post->tags->isNotEmpty())
                            @foreach ($post->tags as $tag)
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1">
                                    {{ $tag->tag_name }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-gray-400 text-xs">タグなし</span>
                        @endif
                    </div>

                </div>
            @empty
                <p class="text-gray-600">まだ投稿がありません</p>
            @endforelse

            {{-- ページネーション --}}
            <div class="mt-6">
                {{ $posts->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
