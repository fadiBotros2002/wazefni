<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $primaryKey = 'question_id';

    protected $fillable = [
        'question_text'
    ];


    public function answers()
    {
        return $this->hasOne(Answer::class, 'question_id', 'question_id');
    }
}
