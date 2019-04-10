<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title', 'description', 'classroom_id'
    ];

    public function classes()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
}
