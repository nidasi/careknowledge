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
        //$posts = KnowledgePost::with('user', 'resident', 'tags')
        //->where('status', 'published')
        //->orderBy('published_at', 'desc')
        //->paginate(10);

        //
        return view('knowledge_posts.index', compact('posts'));
    }

    public function create()
    {
        $tags = Tag::all();
        $residents = Resident::all();

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
        $tags = Tag::all();
        $residents = Resident::all();
        $post->load('tags');

        return view('knowledge_posts.edit', compact('post', 'tags', 'residents'));
    }

    public function update(Request $request, KnowledgePost $post)
    {
        $validated = $request->validate([
            'knowledge_title' => 'required|string|max:255',
            'knowledge_content' => 'required|string',
            'resident_id' => 'nullable|exists:residents,id',
            'status' => 'required|in:draft,published',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ]);

        $post->update([
            ...collect($validated)->except('tags')->toArray(),
            'published_at' => $validated['status'] === 'published'
                ? ($post->published_at ?? now())
                : null,
        ]);
        $post->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('knowledge-posts.index')
            ->with('success', '投稿を更新しました');
    }

    public function destroy(KnowledgePost $post)
    {
        $post->delete();
        return redirect()->route('knowledge-posts.index')
            ->with('success', '投稿を削除しました');
    }
}
