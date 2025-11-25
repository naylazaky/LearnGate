<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnGate - Online Learning Platform</title>
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

    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome to LearnGate</h1>
                <p class="text-xl mb-8">Your gateway to online learning excellence</p>
                
                <form action="{{ route('courses.catalog') }}" method="GET" class="max-w-2xl mx-auto">
                    <div class="flex gap-2">
                        <input type="text" name="search" placeholder="Search for courses..." 
                               class="flex-1 px-4 py-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ request('search') }}">
                        <button type="submit" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-2xl font-bold mb-6">Browse by Category</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('courses.catalog', ['category' => $category->id]) }}" 
                   class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="font-bold text-lg mb-2">{{ $category->name }}</h3>
                    <p class="text-gray-600 text-sm">{{ $category->description }}</p>
                </a>
            @endforeach
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Popular Courses</h2>
            <a href="{{ route('courses.catalog') }}" class="text-blue-600 hover:text-blue-800">View All →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($popularCourses as $course)
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
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500">No courses available yet.</p>
                </div>
            @endforelse
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