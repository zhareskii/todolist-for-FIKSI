<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id'];

    // Jika relasi dengan user diperlukan
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
