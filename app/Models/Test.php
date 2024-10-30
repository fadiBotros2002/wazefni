<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $primaryKey = 'test_id';
    protected $fillable = [

        'title',
    ];

    public function posts() {
        return $this->hasMany(Post::class, 'test_id', 'test_id');
    }

    public function questions() {
        return $this->hasMany(Question::class, 'test_id', 'test_id');
    }
}
