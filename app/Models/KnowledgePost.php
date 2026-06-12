<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KnowledgePost extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'user_id',
        'knowledge_title',
        'knowledge_content',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    //投稿したユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //対象の利用者
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    //Tag(タグ)との関係:多対多
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'knowledge_post_tag');
    }
}
