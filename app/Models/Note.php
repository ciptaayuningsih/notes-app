<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'subject_id',
        'user_id',
        'is_favorite',
    ];

    /**
     * Relasi:
     * Note milik satu Subject
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Relasi:
     * Note milik satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
