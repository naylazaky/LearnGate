<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'content',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function progresses()
    {
        return $this->hasMany(Progress::class);
    }

    public function isCompletedBy($enrollmentId)
    {
        return $this->progresses()
                    ->where('enrollment_id', $enrollmentId)
                    ->where('is_completed', true)
                    ->exists();
    }

    public function nextContent()
    {
        return Content::where('course_id', $this->course_id)
                    ->where('order', '>', $this->order)
                    ->orderBy('order')
                    ->first();
    }

    public function previousContent()
    {
        return Content::where('course_id', $this->course_id)
                    ->where('order', '<', $this->order)
                    ->orderBy('order', 'desc')
                    ->first();
    }
}
