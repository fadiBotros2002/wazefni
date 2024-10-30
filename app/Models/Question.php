<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $primaryKey = 'question_id';

    protected $fillable = [
        'test_id',
        'question',
        'options',
        'answer',
    ];
    protected $casts = [
        'options' => 'array',
    ];

    public function tests()
    {
        return $this->belongsTo(Test::class, 'test_id', 'test_id');
    }
}
