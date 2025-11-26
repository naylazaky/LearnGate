<div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
    <div class="p-6">
        <div class="flex items-center justify-between mb-2">
            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $course->category->name }}</span>
            <span class="text-gray-500 text-sm">{{ $course->student_count }} students</span>
        </div>
        <h3 class="font-bold text-lg mb-2">{{ $course->title }}</h3>
        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($course->description, 100) }}</p>
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-500">
                <span class="font-semibold">{{ $course->teacher->username }}</span>
            </div>
            <a href="{{ route('courses.show', $course->id) }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                View Course
            </a>
        </div>
    </div>
</div>