<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $primaryKey = 'language_id';

    protected $fillable = [
        'cv_id',
        'language_name',
        'proficiency_level',
    ];
    public function cv()
    {
        return $this->belongsTo(CV::class, 'cv_id', 'cv_id');
    }
}
