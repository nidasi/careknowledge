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


    //Resident(入居者)との関係:多対1
    public function resident()
    {

        return $this->belongsTo(Resident::class);
    }

    //Tag(タグ)との関係:多対多
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
