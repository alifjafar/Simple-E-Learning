<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    use Uuid;

    protected $guarded = [];

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
