<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GetDocy Admin — @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Sidebar --}}
    <div class="flex">
        <aside class="w-64 bg-gray-900 min-h-screen p-6 fixed">
            <h1 class="text-white text-2xl font-bold mb-10">📄 GetDocy</h1>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="block text-gray-300 hover:text-white hover:bg-gray-700 px-4 py-2 rounded">
                   Dashboard
                </a>
                <a href="{{ route('admin.departments.index') }}"
                   class="block text-gray-300 hover:text-white hover:bg-gray-700 px-4 py-2 rounded">
                   Departments
                </a>
                <a href="{{ route('admin.levels.index') }}"
                   class="block text-gray-300 hover:text-white hover:bg-gray-700 px-4 py-2 rounded">
                   Levels
                </a>
                <a href="{{ route('admin.courses.index') }}"
                   class="block text-gray-300 hover:text-white hover:bg-gray-700 px-4 py-2 rounded">
                   Courses
                </a>
                <a href="{{ route('admin.lecturers.index') }}"
                   class="block text-gray-300 hover:text-white hover:bg-gray-700 px-4 py-2 rounded">
                   Lecturers
                </a>
                <a href="{{ route('admin.students.index') }}"
                   class="block text-gray-300 hover:text-white hover:bg-gray-700 px-4 py-2 rounded">
                   Students
                </a>
                <a href="{{ route('admin.documents.index') }}"
                class="block text-gray-300 hover:text-white hover:bg-gray-700 px-4 py-2 rounded">
                    Documents
                </a>
                <hr class="border-gray-700 my-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-gray-300 hover:text-red-400 px-4 py-2">
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="ml-64 flex-1 p-8">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>