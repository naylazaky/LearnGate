<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'is_active',
        'approval_status',
        'rejection_reason',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function coursesAsTeacher()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollments::class, 'student_id');
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'student_id', 'course_id')
            ->withTimeStamps()
            ->withPivot('enrolled_at');
    }

    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    public function isTeacher()
    {
        return $this->role == 'teacher';
    }

    public function isStudent()
    {
        return $this->role == 'student';
    }

    public function isActive()
    {
        return $this->is_active;
    }

    public function isPending()
    {
        return $this->approval_status == 'pending';
    }

    public function isApproved()
    {
        return $this->approval_status == 'approved';
    }

    public function isRejected()
    {
        return $this->approval_status == 'rejected';
    }
}
