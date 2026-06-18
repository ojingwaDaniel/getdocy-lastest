<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GetDocy — @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <div class="flex">
        <aside class="w-64 bg-indigo-900 min-h-screen p-6 fixed">
            <h1 class="text-white text-2xl font-bold mb-2">📄 GetDocy</h1>
            <p class="text-indigo-300 text-xs mb-10 uppercase tracking-widest">Lecturer Portal</p>

            <nav class="space-y-2">
                <a href="{{ route('lecturer.dashboard') }}"
                   class="block text-indigo-200 hover:text-white hover:bg-indigo-700 px-4 py-2 rounded">
                    Dashboard
                </a>
                <a href="{{ route('lecturer.documents.index') }}"
                class="block text-indigo-200 hover:text-white hover:bg-indigo-700 px-4 py-2 rounded">
                    My Documents
                </a>
                <a href="{{ route('lecturer.documents.create') }}"
                class="block text-indigo-200 hover:text-white hover:bg-indigo-700 px-4 py-2 rounded">
                    Upload Document
                </a>

                <hr class="border-indigo-700 my-4">

                <div class="px-4 py-2">
                    <p class="text-indigo-400 text-xs uppercase tracking-wide mb-1">Logged in as</p>
                    <p class="text-white text-sm font-medium">{{ auth()->user()->name }}</p>
                    <p class="text-indigo-300 text-xs">{{ auth()->user()->email }}</p>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="px-4">
                    @csrf
                    <button class="text-indigo-300 hover:text-red-400 text-sm mt-2">
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        <main class="ml-64 flex-1 p-8">

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