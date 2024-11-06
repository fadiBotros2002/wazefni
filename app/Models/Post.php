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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id', 'test_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'post_id', 'post_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'post_id', 'post_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'post_id', 'post_id');
    }
}
