<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $primaryKey = 'post_id';
    protected $fillable = [
        'user_id',
        'title',
        'type',
        'description',
        'requirement',
        'location',
        'time',
        'salary',
        'experience_year',
        'test_id',
        'posted_at',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function tests() {
        return $this->belongsTo(Test::class, 'test_id', 'test_id');
    }

    public function reports() {
        return $this->hasMany(Report::class, 'report_id', 'report_id');
    }


    public function applications() {
        return $this->hasMany(Application::class, 'application_id', 'application_id');
    }

    public function notifications() {
        return $this->hasMany(Notification::class, 'post_id', 'post_id');
    }

}
