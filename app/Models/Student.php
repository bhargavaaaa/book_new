<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeActive($q) {
        return $q->where('is_active',1);
    }

    public function standard()
    {
        return $this->belongsTo(standard::class);
    }

    public function medium()
    {
        return $this->belongsTo(Medium::class);
    }
}
