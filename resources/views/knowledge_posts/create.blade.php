<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ナレッジ新規投稿
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- エラーメッセージ --}}
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('knowledge-posts.store') }}" method="POST">
                @csrf

                {{-- タイトル --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">タイトル</label>
                    <input type="text" name="knowledge_title" value="{{ old('knowledge_title') }}"
                        class="border rounded w-full px-3 py-2" required>
                </div>

                {{-- 本文 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">本文</label>
                    <textarea name="knowledge_content" rows="6" class="border rounded w-full px-3 py-2" required>{{ old('knowledge_content') }}</textarea>
                </div>

                {{-- 入居者 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">入居者 (任意) </label>
                    <select name="resident_id" class="border rounded w-full px-3 py-2">
                        <option value="">選択しない</option>
                        @foreach ($residents as $resident)
                            <option value="{{ $resident->id }}"
                                {{ old('resident_id') == $resident->id ? 'selected' : '' }}>
                                {{ $resident->resident_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ステータス --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">ステータス</label>
                    <select name="status" class="border rounded w-full px-3 py-2" required>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>下書き</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>公開</option>
                    </select>
                </div>

                {{-- タグ --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">タグ</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($tags as $tag)
                            <label class="flex items-center space-x-1">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                    {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'checked' : '' }}>
                                <span>{{ $tag->tag_name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    投稿する
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
