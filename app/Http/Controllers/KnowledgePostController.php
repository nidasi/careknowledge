<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KnowledgePost;

class KnowledgePostController extends Controller
{
    public function index()
    {
        //公開済みだけ取得
        $posts = KnowledgePost::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->get();

        return view('knowledge_posts.index', compact('posts'));
    }
}
