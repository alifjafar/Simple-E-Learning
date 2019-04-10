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

    public function files()
    {
        return $this->belongsToMany(File::class, 'file_courses',
            'course_id','file_id');
    }
}
