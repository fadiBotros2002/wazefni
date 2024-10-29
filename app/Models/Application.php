<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $primaryKey = 'application_id';
    protected $fillable = [
        'post_id',
        'user_id',
        'cv',
        'test_result',
        'application_date',
    ];
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
