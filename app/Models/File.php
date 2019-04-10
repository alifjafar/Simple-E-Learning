<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'filename', 'path', 'size', 'mime'
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'file_courses',
            'course_id', 'file_id');
    }
}
