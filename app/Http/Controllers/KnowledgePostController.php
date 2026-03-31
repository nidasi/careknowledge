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
        $post->load(['resident', 'tags','user']);
        return view('knowledge_posts.show', compact('post'));
    }

    public function edit(KnowledgePost $post)
    {
        $tags = Tag::all();
        $post->load('tags');
        return view('knowledge_post.edit',compact('post','tags'));
    }

    public function update(Request $request, KnowledgePost $post)
    {
        $validated = $request->validate([
            'knowlede_title' => 'required|string|max:255',
            'knowlede_content' => 'required|string',
            'resident_id' => 'nullable|exists:residents,id',
            'status' => 'array',
            'tags.*' => 'exists:tags,id',
        ]);

        $post
    }

    public function destroy()
    {
        //
    }
}
