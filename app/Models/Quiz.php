<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use Uuid, SoftDeletes;

    protected $fillable = [
        'description','classroom_id','quiz_provider_id','start_date','end_date'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function result()
    {
        return $this->hasOne(QuizResult::class);
    }

}