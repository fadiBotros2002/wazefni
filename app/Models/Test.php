<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $primaryKey = 'test_id';
    protected $fillable = [
        'user_id',
        'result',
        'status'
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'test_id', 'test_id');
    }

}
