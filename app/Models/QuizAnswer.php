<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    use Uuid;

    protected $guarded = [];

    public function result()
    {
        return $this->belongsTo(QuizResult::class);
    }

}
