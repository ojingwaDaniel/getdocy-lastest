@php 
use App\Models\Department; 
use App\Models\Level;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'GetDocy') }} - Student Registration</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white dark:bg-gray-950 font-sans antialiased">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Left Column: Branding (same as login) -->
        <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-primary-600 to-primary-800 relative overflow-hidden">
            <div class="absolute inset-0 bg-black/20 z-10"></div>
            <div class="relative z-20 flex flex-col justify-between p-12 text-white">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <span class="font-bold text-2xl tracking-tight">GetDocy</span>
                </div>
                <div class="space-y-6">
                    <h1 class="text-4xl font-bold leading-tight">Join the future of academic document management</h1>
                    <p class="text-primary-100 text-lg">Get access to course materials, submit assignments, and collaborate with peers.</p>
                    <div class="flex items-center gap-4 text-sm">
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle"></i><span>Free for students</span></div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle"></i><span>Lifetime access to your documents</span></div>
                    </div>
                </div>
                <div class="text-primary-200 text-sm">© {{ date('Y') }} GetDocy. All rights reserved.</div>
            </div>
            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-primary-400/20 rounded-full blur-3xl"></div>
        </div>

        <!-- Right Column: Student Registration Form -->
        <div class="flex-1 flex items-center justify-center p-6 md:p-12 bg-gray-50 dark:bg-gray-900/30">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="flex justify-center mb-8 md:hidden">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white text-sm"></i>
                        </div>
                        <span class="font-bold text-xl text-gray-900 dark:text-white">GetDocy</span>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 md:p-8 border border-gray-200 dark:border-gray-700">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Student Registration</h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Create your student account to get started</p>
                    </div>

                    <form method="POST" action="{{ route('students.register') }}">
                        @csrf

                        <!-- Full Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400 text-sm"></i>
                                </div>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                    class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-primary-500 shadow-sm @error('name') border-red-500 @enderror"
                                    placeholder="John Doe">
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">University email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400 text-sm"></i>
                                </div>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                    class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-primary-500 shadow-sm @error('email') border-red-500 @enderror"
                                    placeholder="john.doe@university.edu">
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Student ID (unique) -->
                        <div class="mb-4">
                            <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Matric Number</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-id-card text-gray-400 text-sm"></i>
                                </div>
                                <input id="student_id" type="text" name="matric_number" value="{{ old('matric_number') }}" required
                                    class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-primary-500 shadow-sm @error('student_id') border-red-500 @enderror"
                                    placeholder="S12345678">
                            </div>
                            @error('matric_number')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Department -->
                        <div class="mb-4">
                            <label for="department" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-building text-gray-400 text-sm"></i>
                                </div>
                                <select id="department" name="department_id" required
                                    class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-primary-500 shadow-sm @error('department') border-red-500 @enderror">
                                    <option value="">Select department</option>
                                    @foreach (Department::orderBy("name")->get() as $dept)
                                         <option value="{{$dept->id}}" {{old("department_id") === $dept->id ? "selected" : ""}}>{{$dept->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('department_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Year of Study -->
                        <div class="mb-4">
                            <label for="level_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Year of study</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                                </div>
                                <select id="level_id" name="level_id" required
                                    class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-primary-500 shadow-sm @error('year_of_study') border-red-500 @enderror">
                                    <option value="">Select year</option>
                                    @foreach(Level::orderBy("name")->get() as $level)
                                    <option value="{{$level->id}}" {{ old('level_id') == $level->id ? 'selected' : '' }}>{{$level->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('level_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400 text-sm"></i>
                                </div>
                                <input id="password" type="password" name="password" required autocomplete="new-password"
                                    class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-primary-500 shadow-sm @error('password') border-red-500 @enderror"
                                    placeholder="••••••••">
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400 text-sm"></i>
                                </div>
                                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                    class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-primary-500 shadow-sm"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <!-- Register Button -->
                        <button type="submit"
                            class="w-full flex justify-center items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-all shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                            <i class="fas fa-user-graduate"></i> Register as Student
                        </button>

                        <!-- Login Link -->
                        <div class="text-center mt-6">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Already have an account?
                                <a href="{{ route('login') }}" class="text-primary-600 dark:text-primary-400 font-semibold hover:underline">Sign in</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>