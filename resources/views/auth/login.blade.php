<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'GetDocy') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white dark:bg-gray-950 font-sans antialiased">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Left Column: Branding & Illustration (hidden on mobile) -->
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
                    <h1 class="text-4xl font-bold leading-tight">Welcome back to academic excellence</h1>
                    <p class="text-primary-100 text-lg">Access your documents, courses, and collaborative tools from one secure dashboard.</p>
                    <div class="flex items-center gap-4 text-sm">
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle"></i><span>Role-based access</span></div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle"></i><span>End-to-end encryption</span></div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle"></i><span>24/7 support</span></div>
                    </div>
                </div>
                <div class="text-primary-200 text-sm">© {{ date('Y') }} GetDocy. All rights reserved.</div>
            </div>
            <!-- Decorative circles -->
            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-primary-400/20 rounded-full blur-3xl"></div>
        </div>

        <!-- Right Column: Login Form -->
        <div class="flex-1 flex items-center justify-center p-6 md:p-12 bg-gray-50 dark:bg-gray-900/30">
            <div class="w-full max-w-md">
                <!-- Mobile Logo (visible only on small screens) -->
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
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Sign in to your account</h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Access your dashboard and manage documents</p>
                    </div>

                    <!-- Session Status (e.g., password reset confirmation) -->
                    @if (session('status'))
                        <div class="mb-4 text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/30 p-3 rounded-lg">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400 text-sm"></i>
                                </div>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                    class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-primary-500 shadow-sm transition-all @error('email') border-red-500 @enderror"
                                    placeholder="you@university.edu">
                            </div>
                            @error('email')
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
                                <input id="password" type="password" name="password" required autocomplete="current-password"
                                    class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-primary-500 shadow-sm transition-all @error('password') border-red-500 @enderror"
                                    placeholder="••••••••">
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between mb-6">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" name="remember"
                                    class="rounded border-gray-300 dark:border-gray-600 text-primary-600 shadow-sm focus:ring-primary-500">
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:underline">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full flex justify-center items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-all shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                            <i class="fas fa-sign-in-alt"></i> Sign in
                        </button>

                        <!-- Register Link -->
                        <div class="text-center mt-6">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Don't have an account?
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="text-primary-600 dark:text-primary-400 font-semibold hover:underline">Create one now</a>
                                @endif
                            </p>
                        </div>
                    </form>
                </div>

                <!-- Demo credentials hint (optional, remove for production) -->
                <div class="mt-6 text-center text-xs text-gray-500 dark:text-gray-500">
                    <p>Demo: admin@getdocy.com / password</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>