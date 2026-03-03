<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Floor extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'floor_name',
    ];
    // floor 複数のresident持つ(1対多)
    public function residents()
    {
        return $this->hasMany(Resident::class);
    }
}
