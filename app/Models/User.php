<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'username', 'picture',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['avatar'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function lecturerClass()
    {
        return $this->hasMany(Classroom::class, 'user_id');
    }

    public function studentClass()
    {
        return $this->belongsToMany(Classroom::class, 'class_students',
            'user_id', 'classroom_id');
    }

    public function getAvatarAttribute()
    {
        $avatar = $this['picture'];
        if ($avatar) {
            return Storage::disk('public')->url($avatar);
        }
        $hash = md5(strtolower(trim($this['email']))) . '.jpeg' . '?s=106&d=mm&r=g';
        return "https://secure.gravatar.com/avatar/$hash";
    }



}
