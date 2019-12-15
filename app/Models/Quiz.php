<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use Uuid, SoftDeletes;

    protected $fillable = [
        'name', 'description', 'classroom_id', 'quiz_provider_id', 'start_date', 'end_date', 'password'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function result()
    {
        return $this->hasOne(QuizResult::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

}
