<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
    ];

    /**
     * Relasi:
     * 1 Subject punya banyak Note
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Relasi:
     * Subject dimiliki oleh User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
