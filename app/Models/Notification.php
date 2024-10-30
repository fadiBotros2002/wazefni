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
        'application_id',
        'message',
        'sent_at',
    ];
    public function posst()
    {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function applications()
    {
        return $this->belongsTo(Application::class, 'application_id', 'application_id');
    }


}
