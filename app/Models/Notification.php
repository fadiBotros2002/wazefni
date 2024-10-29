<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $primaryKey = 'notification_id';

    protected $fillable = [
        'post_id',
        'user_id',
        'message',
        'read_at',
        'sent_at',
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
