<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;

    protected $primaryKey = 'cv_id';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'domain',
        'education',
        'skills',
        'city',
        'address',
        'portfolio',
    ];

    // Define the relationship with User model correctly
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function languages()
    {
        return $this->hasMany(Language::class, 'cv_id', 'cv_id');
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class, 'cv_id', 'cv_id');
    }
}
