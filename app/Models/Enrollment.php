<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'enrolled_at',
    ];

    protected function casts():array
    {
        return [
            'enrolled_at' => 'datetime',
        ];
    }

    public $timestamps = false;

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function progrresses()
    {
        return $this->hasMany(Progress::class);
    }

    public function calculateProgress()
    {
        $totalContents = $this->course->contents()->count();

        if ($totalContents == 0) {
            return 0;
        }

        $completedContents = $this->progrresses()
            ->where('is_completed', true)
            ->count();

        return round(($completedContents / $totalContents) * 100, 2);
    }

    public function isCompleted()
    {
        return $this->calculateProgress() == 100;
    }

    public function nextIncompleteContent()
    {
        $completedContentIds = $this->progrresses()
            ->where('is_completed', true)
            ->pluck('content_id')
            ->toArray();

        return $this->course->contents()
            ->whereNotIn('id', $completedContentIds)
            ->orderBy('order')
            ->first();
    }
}
