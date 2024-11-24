<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $primaryKey = 'report_id';
    protected $fillable = [
        'user_id',
        'post_id',
        'message',
        'is_read',
        'status',
        'sent_at',
    ];



    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function posts()
    {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }
}
