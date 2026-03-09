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

    public function create()
    {

    }

    public function store()
    {
        //バリデーション
        $validated = $request->validate([
            'knowledge_title'
        ])

    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function update()
    {
        //
    }

    public function destroy()
    {
        //
    }
}
