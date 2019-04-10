<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassStudent extends Model
{

    protected $fillable = [
        'classroom_id', 'user_id'
    ];

    public $timestamps = false;
}
