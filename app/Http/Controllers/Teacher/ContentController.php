<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Content;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function index(Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $contents = $course->contents()->orderBy('order')->get();

        return view('teacher.contents.index', compact('course', 'contents'));
    }

    public function create(Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $lastOrder = $course->contents()->max('order') ?? 0;

        return view('teacher.contents.create', compact('course', 'lastOrder'));
    }

    public function store(Request $request, Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:1000',
            'content_type' => 'required|in:text,file',
            'content_text' => 'required_if:content_type,text|nullable|string|max:50000',
            'content_file' => [
                'required_if:content_type,file',
                'nullable',
                'file',
                'max:51200',
                function ($attribute, $value, $fail) {
                    if (!$value) return;
                    
                    $extension = strtolower($value->getClientOriginalExtension());
                    $allowedExtensions = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'mp4', 'avi', 'mov'];
                    
                    if (!in_array($extension, $allowedExtensions)) {
                        $fail('File type not allowed.');
                        return;
                    }
                    
                    $allowedMimes = [
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-powerpoint',
                        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                        'video/mp4',
                        'video/x-msvideo',
                        'video/quicktime',
                    ];
                    
                    if (!in_array($value->getMimeType(), $allowedMimes)) {
                        $fail('Invalid file type. File MIME type does not match extension.');
                    }
                }
            ],
            'order' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $existingContent = $course->contents()->where('order', $request->order)->first();
            
            if ($existingContent) {
                $course->contents()
                    ->where('order', '>=', $request->order)
                    ->increment('order');
            }

            $data = [
                'course_id' => $course->id,
                'title' => strip_tags($request->title),
                'description' => $request->description ? strip_tags($request->description) : null, 
                'content_type' => $request->content_type,
                'order' => $request->order,
            ];

            if ($request->content_type === 'text') {
                $data['content_text'] = $this->sanitizeHtmlContent($request->content_text);
            } else {
                if ($request->hasFile('content_file')) {
                    $file = $request->file('content_file');
                    
                    $filename = time() . '_' . Str::random(20) . '.' . $file->extension();
                    
                    $path = $file->storeAs('course-contents', $filename, 'public');
                    $data['content_file'] = $path;
                    
                    Log::info('Content file uploaded', [
                        'teacher_id' => auth()->id(),
                        'course_id' => $course->id,
                        'filename' => $filename,
                        'original_name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                    ]);
                }
            }

            $content = Content::create($data);

            $enrollments = $course->enrollments()->get();
            
            if ($enrollments->count() > 0) {
                $progressData = $enrollments->map(function ($enrollment) use ($content) {
                    return [
                        'enrollment_id' => $enrollment->id,
                        'content_id' => $content->id,
                        'is_completed' => false,
                        'completed_at' => null,
                    ];
                })->toArray();
                
                Progress::insert($progressData);
            }

            DB::commit();

            Log::info('Content created successfully', [
                'content_id' => $content->id,
                'course_id' => $course->id,
                'teacher_id' => auth()->id(),
                'type' => $content->content_type,
            ]);

            return redirect()->route('teacher.contents.index', $course)
                ->with('success', 'Content berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Content creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'teacher_id' => auth()->id(),
                'course_id' => $course->id,
                'request_data' => $request->except(['content_file']),
            ]);
            
            return back()
                ->with('error', 'Terjadi kesalahan saat menambahkan content. Silakan coba lagi.')
                ->withInput();
        }
    }

    public function edit(Course $course, Content $content)
    {
        if ($course->teacher_id !== auth()->id() || $content->course_id !== $course->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('teacher.contents.edit', compact('course', 'content'));
    }

    public function update(Request $request, Course $course, Content $content)
    {
        if ($course->teacher_id !== auth()->id() || $content->course_id !== $course->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:1000',
            'content_type' => 'required|in:text,file',
            'content_text' => 'required_if:content_type,text|nullable|string|max:50000',
            'content_file' => [
                'nullable',
                'file',
                'max:51200',
                function ($attribute, $value, $fail) {
                    if (!$value) return;
                    
                    $extension = strtolower($value->getClientOriginalExtension());
                    $allowedExtensions = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'mp4', 'avi', 'mov'];
                    
                    if (!in_array($extension, $allowedExtensions)) {
                        $fail('File type not allowed. Only PDF, DOC, DOCX, PPT, PPTX, MP4, AVI, MOV are allowed.');
                        return;
                    }
                    
                    $allowedMimes = [
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-powerpoint',
                        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                        'video/mp4',
                        'video/x-msvideo',
                        'video/quicktime',
                    ];
                    
                    if (!in_array($value->getMimeType(), $allowedMimes)) {
                        $fail('Invalid file type. File MIME type does not match extension.');
                    }
                }
            ],
            'order' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $oldOrder = $content->order;
            $newOrder = $request->order;

            if ($oldOrder !== $newOrder) {
                if ($newOrder > $oldOrder) {
                    $course->contents()
                        ->where('order', '>', $oldOrder)
                        ->where('order', '<=', $newOrder)
                        ->decrement('order');
                } else {
                    $course->contents()
                        ->where('order', '>=', $newOrder)
                        ->where('order', '<', $oldOrder)
                        ->increment('order');
                }
            }

            $data = [
                'title' => strip_tags($request->title), 
                'description' => $request->description ? strip_tags($request->description) : null, 
                'content_type' => $request->content_type,
                'order' => $newOrder,
            ];

            if ($request->content_type === 'text') {
                $data['content_text'] = $this->sanitizeHtmlContent($request->content_text);
                
                if ($content->content_file) {
                    Storage::disk('public')->delete($content->content_file);
                    $data['content_file'] = null;
                }
            } else {
                if ($request->hasFile('content_file')) {
                    if ($content->content_file) {
                        Storage::disk('public')->delete($content->content_file);
                        
                        Log::info('Old content file deleted', [
                            'content_id' => $content->id,
                            'old_file' => $content->content_file,
                        ]);
                    }
                    
                    $file = $request->file('content_file');
                    $filename = time() . '_' . Str::random(20) . '.' . $file->extension();
                    $path = $file->storeAs('course-contents', $filename, 'public');
                    $data['content_file'] = $path;
                    
                    Log::info('New content file uploaded', [
                        'content_id' => $content->id,
                        'filename' => $filename,
                        'size' => $file->getSize(),
                    ]);
                }
                $data['content_text'] = null;
            }

            $content->update($data);

            DB::commit();

            Log::info('Content updated successfully', [
                'content_id' => $content->id,
                'course_id' => $course->id,
                'teacher_id' => auth()->id(),
            ]);

            return redirect()->route('teacher.contents.index', $course)
                ->with('success', 'Content berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Content update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'content_id' => $content->id,
                'teacher_id' => auth()->id(),
            ]);
            
            return back()
                ->with('error', 'Terjadi kesalahan saat mengupdate content.')
                ->withInput();
        }
    }

    public function destroy(Course $course, Content $content)
    {
        if ($course->teacher_id !== auth()->id() || $content->course_id !== $course->id) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            $deletedOrder = $content->order;
            $oldFile = $content->content_file;

            if ($content->content_file) {
                Storage::disk('public')->delete($content->content_file);
            }

            $content->delete();

            $course->contents()
                ->where('order', '>', $deletedOrder)
                ->decrement('order');

            DB::commit();

            Log::info('Content deleted successfully', [
                'content_id' => $content->id,
                'course_id' => $course->id,
                'teacher_id' => auth()->id(),
                'deleted_file' => $oldFile,
            ]);

            return redirect()->route('teacher.contents.index', $course)
                ->with('success', 'Content berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Content deletion failed', [
                'error' => $e->getMessage(),
                'content_id' => $content->id,
                'teacher_id' => auth()->id(),
            ]);
            
            return back()->with('error', 'Terjadi kesalahan saat menghapus content.');
        }
    }

    private function sanitizeHtmlContent($content)
    {
        $allowedTags = '<p><br><strong><em><u><h1><h2><h3><h4><ul><ol><li><blockquote><code><pre>';
        $cleaned = strip_tags($content, $allowedTags);
        
        $cleaned = preg_replace('/<(\w+)[^>]*on\w+\s*=\s*["\'][^"\']*["\'][^>]*>/i', '<$1>', $cleaned);
        
        $cleaned = preg_replace('/javascript:/i', '', $cleaned);
        
        $cleaned = trim($cleaned);
        
        return $cleaned;
    }
}