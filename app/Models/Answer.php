<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $primaryKey = 'answer_id';

    protected $fillable = ['test_id', 'question_id', 'audio_path', 'ai_response'];

    public function tests()
    {
        return $this->belongsTo(Test::class, 'test_id', 'test_id');
    }

    public function questions()
    {
        return $this->belongsTo(Question::class, 'question_id', 'question_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
