<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Catalog - LearnGate</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">LearnGate</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('courses.catalog') }}" class="text-gray-700 hover:text-blue-600">Courses</a>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">Dashboard</a>
                        @elseif(auth()->user()->role === 'teacher')
                            <a href="{{ route('teacher.dashboard') }}" class="text-gray-700 hover:text-blue-600">Dashboard</a>
                        @elseif(auth()->user()->role === 'student')
                            <a href="{{ route('student.dashboard') }}" class="text-gray-700 hover:text-blue-600">Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-blue-600">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold mb-8">Course Catalog</h1>

        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <form action="{{ route('courses.catalog') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <input type="text" name="search" placeholder="Search courses..." 
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ request('search') }}">
                    </div>

                    <div>
                        <select name="category" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-4 flex gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        Apply Filters
                    </button>
                    <a href="{{ route('courses.catalog') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($courses as $course)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $course->category->name }}</span>
                            <span class="text-gray-500 text-sm">{{ $course->student_count }} students</span>
                        </div>
                        <h3 class="font-bold text-lg mb-2">{{ $course->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($course->description, 100) }}</p>
                        
                        <div class="border-t pt-4">
                            <div class="flex items-center justify-between">
                                <div class="text-sm">
                                    <p class="text-gray-500">Teacher</p>
                                    <p class="font-semibold">{{ $course->teacher->username }}</p>
                                </div>
                                <a href="{{ route('courses.show', $course->id) }}" 
                                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500">No courses found.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $courses->links() }}
        </div>
    </div>

    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p class="text-gray-400">&copy; 2024 LearnGate. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>