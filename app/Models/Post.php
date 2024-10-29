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
        'posted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
