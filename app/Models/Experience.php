<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;
    protected $primaryKey = 'experience_id';

    protected $fillable = [
        'cv_id',
        'company_name',
        'domain',
        'job_description',
        'start_date',
        'end_date',
    ];
    public function cvs()
    {
        return $this->belongsTo(CV::class, 'cv_id', 'cv_id');
    }
}
