<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KnowledgePost;

class KnowledgePostController extends Controller
{
    public function index()
    {
        //
        $posts = KnowledgePost::with('user', 'resident', 'tags')
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        //
        return view('knowledge_posts.index', compact('posts'));
    }

    public function create() {}

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
            'knowledge_title' => $validated['knowledge_title'],
            'knowledge_content' => $validated['knowledge_content'],
            'resident_id' => $validated['resident_id'] ?? null,
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published' ? now() : null,
            'user_id' => auth()->id(),
        ]);

        if (!empty($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        return redirect()->route('knowledge-posts.index')
            ->with('success', '投稿を作成しました');
    }

    public function show() {}

    public function edit() {}

    public function update()
    {
        //
    }

    public function destroy()
    {
        //
    }
}
