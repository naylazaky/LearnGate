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
        'description',
        'content_type',
        'content_text',
        'content_file',
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

    public function getContentFileUrlAttribute()
    {
        if ($this->content_file) {
            return asset('storage/' . $this->content_file);
        }
        return null;
    }

    public function isTextContent()
    {
        return $this->content_type === 'text';
    }

    public function isFileContent()
    {
        return $this->content_type === 'file';
    }
}