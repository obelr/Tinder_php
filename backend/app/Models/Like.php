<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'person_id',
        'liked',
    ];

    protected $casts = [
        'liked' => 'boolean',
    ];

    protected $hidden = [
        'user_id',
        'person_id',
        'created_at',
        'updated_at',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
