<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $primaryKey = 'post_id';

    protected $fillable = [
        'user_id',
        'title',
        'type',
        'description',
        'requirement',
        'location',
        'time',
        'salary',
        'experience_year',
  
        'posted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }



    public function reports()
    {
        return $this->hasMany(Report::class, 'post_id', 'post_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'post_id', 'post_id');
    }




    public function scopeFilter($query, $filters)
    {
        return $query
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('requirement', 'like', "%{$search}%");
                });
            })
            ->when($filters['location'] ?? null, function ($query, $location) {
                $query->whereRaw('LOWER(location) like ?', ['%' . strtolower($location) . '%']);
            })
            ->when($filters['type'] ?? null, function ($query, $type) {
                $query->where('type', $type);
            })
            ->when($filters['experience_year'] ?? null, function ($query, $experienceYear) {
                $query->where('experience_year', '>=', $experienceYear);
            })
            ->when(isset($filters['salary_min'], $filters['salary_max']) && $filters['salary_min'] <= $filters['salary_max'], function ($query) use ($filters) {
                $query->whereBetween('salary', [$filters['salary_min'], $filters['salary_max']]);
            })
            ->when(isset($filters['salary_min']) && !isset($filters['salary_max']), function ($query) use ($filters) {
                $query->where('salary', '>=', $filters['salary_min']);
            })
            ->when(!isset($filters['salary_min']) && isset($filters['salary_max']), function ($query) use ($filters) {
                $query->where('salary', '<=', $filters['salary_max']);
            })
            ->when($filters['posted_at'] ?? null, function ($query, $postedAt) {
                $query->whereDate('posted_at', '>=', $postedAt);
            })
            ->when($filters['test_id'] ?? null, function ($query, $testId) {
                $query->where('test_id', $testId);
            });
    }

}
