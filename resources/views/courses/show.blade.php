<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }} - LearnGate</title>
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
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="mb-4">
                        <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded">{{ $course->category->name }}</span>
                    </div>
                    <h1 class="text-3xl font-bold mb-4">{{ $course->title }}</h1>
                    <p class="text-gray-600 mb-4">{{ $course->description }}</p>
                    
                    <div class="flex items-center space-x-6 text-sm text-gray-500">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>{{ $course->student_count }} students enrolled</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span>{{ $course->contents->count() }} lessons</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Course Contents</h2>
                    <div class="space-y-3">
                        @forelse($course->contents as $content)
                            <div class="flex items-center p-3 border rounded hover:bg-gray-50">
                                <div class="flex-1">
                                    <p class="font-semibold">{{ $content->title }}</p>
                                    <p class="text-sm text-gray-500">Lesson {{ $content->order }}</p>
                                </div>
                                @if($isEnrolled)
                                    <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No contents available yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="font-bold mb-3">Instructor</h3>
                    <div class="flex items-center mb-3">
                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                            {{ substr($course->teacher->username, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold">{{ $course->teacher->username }}</p>
                            <p class="text-sm text-gray-500">{{ $course->teacher->email }}</p>
                        </div>
                    </div>
                    <button class="w-full bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        Contact Teacher
                    </button>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    @guest
                        <div class="text-center">
                            <p class="text-gray-600 mb-4">Login to enroll in this course</p>
                            <a href="{{ route('login') }}" class="block w-full bg-blue-600 text-white px-4 py-3 rounded hover:bg-blue-700 font-semibold">
                                Login to Enroll
                            </a>
                        </div>
                    @endguest

                    @auth
                        @if(auth()->user()->role === 'student')
                            @if($isEnrolled)
                                <div>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-2">Your Progress</p>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">{{ $progress }}% Complete</p>
                                    </div>
                                    <a href="#" class="block w-full bg-green-600 text-white px-4 py-3 rounded hover:bg-green-700 font-semibold text-center">
                                        Continue Learning
                                    </a>
                                </div>
                            @else
                                <div class="text-center">
                                    <p class="text-gray-600 mb-4">Ready to start learning?</p>
                                    <form action="#" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-3 rounded hover:bg-blue-700 font-semibold">
                                            Enroll Now
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @else
                            <p class="text-gray-600 text-center">This course is available for students only.</p>
                        @endif
                    @endauth
                </div>
            </div>
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