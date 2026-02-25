<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'floor_id',
        'resident_name',
        'room_number',
    ];

    //Userとのリレーション(多対1)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //KnowledgePostとのリレーション(1対多)
    public function knowledgePosts()
    {
        return $this->hasMany(KnowledgePost::class);
    }
}
