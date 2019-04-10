<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileCourse extends Model
{
    protected $fillable = [
        'course_id', 'file_id'
    ];

    public $timestamps = false;
}
