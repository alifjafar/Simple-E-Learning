<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = [
        'id', 'filename', 'path', 'size', 'mime'
    ];

    public $incrementing = false;

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'file_courses',
            'file_id', 'course_id');
    }

}
