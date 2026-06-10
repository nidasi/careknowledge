<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KnowledgePost;
use App\Models\Tag;
use App\Models\Resident;

class KnowledgePostController extends Controller
{
    public function index(Request $request)
    {
        $query = KnowledgePost::with('user', 'resident', 'tags')
            ->where('status', 'published')
            ->orderBy('published_at', 'desc');

        if ($request->filled('keyword')) {
            $query->where('knowledge_title', 'like', '%' . $request->keyword . '%');
        }

        $posts = $query->paginate(10);

        //
        return view('knowledge_posts.index', compact('posts'));
    }

    public function create()
    {
        $tags = Tag::orderBy('tag_name')->get();
        $residents = Resident::orderBy('resident_name')->get();

        return view('knowledge_posts.create', compact('tags', 'residents'));
    }

    public function store(Request $request)
    {
        //バリデーション
        $validated = $request->validate([
            'knowledge_title' => 'required|string|max:255',
            'knowledge_content' => 'required|string',
            'resident_id' => 'nullable|exists:residents,id',
            'status' => 'required|in:draft,published',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ]);

        $post = KnowledgePost::create([
            ...collect($validated)->except('tags')->toArray(),
            'published_at' => $validated['status'] === 'published' ? now() : null,
            'user_id' => auth()->id(),
        ]);

        if (!empty($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        return redirect()->route('knowledge-posts.index')
            ->with('success', '投稿を作成しました');
    }

    public function show(KnowledgePost $post)
    {
        $post->load(['resident', 'tags', 'user']);
        return view('knowledge_posts.show', compact('post'));
    }

    public function edit(KnowledgePost $post)
    {
        //権限チェック(本人のみ編集可)
        abort_if(auth()->id() !== $post->user_id, 403);

        $post->load('tags');

        $residents = Resident::orderBy('resident_name')->get();
        $tags = Tag::orderBy('tag_name')->get();

        return view('knowledge_posts.edit', compact('post', 'residents', 'tags',));
    }

    public function update(Request $request, KnowledgePost $post)
    {
        abort_if(auth()->id() !== $post->user_id, 403);

        $validated = $request->validate([
            'knowledge_title' => ['required', 'string', 'max:255'],
            'knowledge_content' => ['required', 'string'],
            'resident_id' => ['nullable', 'exists:residents,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $data = collect($validated)
            ->except('tags')->toArray();
        if ($validated['status'] === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        }

        if ($validated['status'] === 'draft') {
            $data['published_at'] = null;
        }

        $post->update($data);

        $post->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('knowledge-posts.show', $post)
            ->with('success', '投稿を更新しました');
    }

    public function destroy(KnowledgePost $post)
    {
        //本人のみ削除可
        abort_if(auth()->id() !== $post->user_id, 403);

        $post->delete();
        return redirect()->route('knowledge-posts.index')
            ->with('success', '投稿を削除しました');
    }
}
