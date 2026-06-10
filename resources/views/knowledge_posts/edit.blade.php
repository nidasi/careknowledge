<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ナレッジ編集
        </h2>
    </x-slot>

    <div class="bg-white shadow-md rounded-lg p-6">

        {{-- バリデーションエラー表示 --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded">
                <ul class="list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- フォーム --}}
        <form action="{{ route('knowledge-posts.update', $post) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- タイトル --}}
            <div class="mb-4">
                <label for="knowledge_title" class="block text-sm font-medium text-gray-700 mb-1">
                    タイトル <span class="text-red-500">*</span>
                </label>
                <input type="text" id="knowledge_title" name="knowledge_title"
                    value="{{ old('knowledge_title', $post->knowledge_title) }}"
                    class="w-full border rounded px-3 py-2 text-sm @error('knowledge_title') border-red-500 @enderror">
                @error('knowledge_title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 本文 --}}
            <div class="mb-4">
                <label for="knowledge_content" class="block text-sm font-medium text-gray-700 mb-1">
                    本文 <span class="text-red-500">*</span>
                </label>
                <textarea id="knowledge_content" name="knowledge_content" rows="8"
                    class="w-full border rounded px-3 py-2 text-sm @error('knowledge_content') border-red-500 @enderror">{{ old('knowledge_content', $post->knowledge_content) }}</textarea>
                @error('knowledge_content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 対象入居者 --}}
            <div class="mb-4">
                <label for="resident_id" class="block text-sm font-medium text-gray-700 mb-1">
                    対象入居者
                </label>
                <select id="resident_id" name="resident_id"
                    class="w-full border rounded px-3 py-2 text-sm @error('resident_id') border-red-500 @enderror">
                    <option value="">未設定</option>
                    @foreach ($residents as $resident)
                        <option value="{{ $resident->id }}"
                            {{ old('resident_id', $post->resident_id) == $resident->id ? 'selected' : '' }}>
                            {{ $resident->resident_name }}
                        </option>
                    @endforeach
                </select>
                @error('resident_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- タグ --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">タグ</label>
                <div class="flex flex-wrap gap-2">
                    @foreach ($tags as $tag)
                        <label class="flex items-center gap-1 text-sm">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
                            {{ $tag->tag_name }}
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- ステータス --}}
            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                    ステータス
                </label>
                <select id="status" name="status" class="border rounded px-3 py-2 text-sm">
                    <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>下書き
                    </option>
                    <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>公開
                    </option>
                </select>
            </div>

            {{-- ボタン群 --}}
            <div class="flex justify-between">
                <a href="{{ route('knowledge-posts.show', $post) }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">キャンセル</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">更新する
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
