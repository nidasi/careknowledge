<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_name',
    ];

    //KnowledgePost と多対多
    public function knowledgePosts()
    {
        return $this->belongsToMany(KnowledgePost::class, 'knowledge_post_tag');
    }
}
