<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'teacher_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'is_active',
        'student_count',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
            'student_count' => 'integer',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function contents()
    {
        return $this->hasMany(Content::class)->orderBy('order');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'student_id')
            ->withTimeStamps()
            ->withPivot('enrolled_at');
    }

    public function isOngoing()
    {
        $now = now();
        return $this->start_date <= $now && $this->end_date >= $now;
    }

    public function isEnrolledBy($userId)
    {
        return $this->enrollments()->where('student_id', $userId)->exists();
    }

    public function incrementStudentCount()
    {
        $this->increment('student_count');
    }

    public function decreamentStudentCount()
    {
        $this->decrement('student_count');
    }

    public function scopePopular($query, $limit = 5)
    {
        return $query->where('is_active', true)
            ->orderBy('student_count', 'desc')
            ->limit($limit);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
