<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function standard()
    {
        return $this->belongsToMany(Standard::class, 'book_standards')->withTimestamps();
    }
}
