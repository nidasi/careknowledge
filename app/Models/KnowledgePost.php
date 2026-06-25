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

    //AND検索(複数キーワード)
    public function scopeSearch($query, ?string $keyword)
    {
        if (blank($keyword)) {
            return $query;
        }

        $keywords = preg_split(
            '/[\s　]+/u',
            trim($keyword),
            -1,
            PREG_SPLIT_NO_EMPTY
        );

        return $query->where(function ($q) use ($keywords) {

            foreach ($keywords as $word) {

                $word = addcslashes($word, '%_\\');

                $q->where(function ($q2) use ($word) {

                    $q2->where('knowledge_title', 'like', "%{$word}%")
                        ->orWhere('knowledge_content', 'like', "%{$word}%")
                        ->orWhereHas('resident', function ($r) use ($word) {
                            $r->where('resident_name', 'like', "%{$word}%");
                        })
                        ->orWhereHas('tags', function ($t) use ($word) {
                            $t->where('tag_name', 'like', "%{$word}%");
                        });
                });
            }
        });
    }
}
