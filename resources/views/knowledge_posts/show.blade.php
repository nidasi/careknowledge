<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ナレッジ詳細
        </h2>
    </x-slot>

    <div class="bg-white shadow-md rounded-lg p-6">

        {{-- タイトル --}}
        <h1 class="text-2xl font-bold mb-4">{{ $post->knowledge_title }}</h1>

        {{-- 投稿者・公開日 --}}
        <p class="text-sm text-gray-500 mb-2">
            投稿者: {{ $post->user?->name ?? '不明なユーザー' }}
            / 投稿日: {{ $post->published_at?->format('Y/m/d') ?? '未公開' }}
        </p>

        {{-- 入居者 --}}
        <p class="text-sm text-gray-600 mb-4">
            対象入居者:{{ $post->resident?->resident_name ?? '未設定' }}
        </p>


        {{-- 本文 --}}
        <div class="prose max-w-none mb-6">
            {!! nl2br(e($post->knowledge_content)) !!}
        </div>

        {{-- タグ --}}
        <div class="mb-6">
            @if ($post->tags->isNotEmpty())
                @foreach ($post->tags as $tag)
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1">
                        {{ $tag->tag_name }}
                    </span>
                @endforeach
            @else
                <span class="text-gray-400 text-sm">タグなし</span>
            @endif
        </div>

        {{-- ステータス --}}
        <p class="text-sm mb-6">
            ステータス:
            <span class="{{ $post->status === 'published' ? 'text-green-600' : 'text-gray-600' }}">
                {{ $post->status === 'published' ? '公開' : '下書き' }}
            </span>
        </p>

        {{-- ボタン群 --}}
        <div class="flex justify-between">
            <a href="{{ route('knowledge-posts.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                一覧へ戻る
            </a>
            @if (auth()->id() === $post->user_id)
                <div class="flex gap-2">
                    <a
                        href="{{ route('knowledge-posts.edit', $post) }}"class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                        編集
                    </a>

                    <form action="{{ route('knowledge-posts.destroy', $post) }}" method="POST"
                        onsubmit="return confirm('削除してもよろしいですか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                            削除
                        </button>
                    </form>
                </div>
            @endif
        </div>


    </div>
</x-app-layout>
