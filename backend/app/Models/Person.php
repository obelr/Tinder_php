<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'pictures',
        'location',
        'likes_count',
    ];

    protected $casts = [
        'pictures' => 'array',
    ];

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
