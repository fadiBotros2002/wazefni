<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'name',
        'email',
        'password',
        'verification_code',
        'role',
        'phone',
        'location',
        'userstatus',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cv()
    {
        return $this->hasOne(Cv::class, 'user_id', 'user_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'user_id', 'user_id');
    }

    public function employers()
    {
        return $this->hasOne(Employer::class, 'user_id', 'user_id');
    }



    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'user_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'user_id', 'user_id');
    }

    public function tests()
    {
        return $this->hasMany(Test::class, 'user_id', 'user_id');
    }
    public function answers()
{
    return $this->hasMany(Answer::class, 'user_id', 'user_id');
}
}
