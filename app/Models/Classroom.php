<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'name', 'description', 'user_id', 'enroll_code', 'is_private'
    ];

    public $incrementing = false;

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'class_students',
            'classroom_id', 'user_id');
    }

    public function course()
    {
        return $this->hasMany(Course::class, 'classroom_id');
    }
}
