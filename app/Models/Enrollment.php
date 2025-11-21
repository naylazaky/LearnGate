<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillabke = [
        'student_id',
        'course_id',
        'enrolled_at',
    ];

    protected function casts(): array
    {
        return [
            'enrolled_at' => 'datetime',
        ];
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function progress()
    {
        return $this->hasMany(Progress::class);
    }

    public function getProgressPercentageAttribute()
    {
        $totalContents = $this->course->contents()->count();

        if ($totalContents == 0) {
            return 0;
        }

        $completedContents = $this->progress()->where('is_completed', true)->count();

        return round(($completedContents / $totalContents) * 100, 2);
    }
}
