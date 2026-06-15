<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="GetDocy - Academic Document Management Platform for universities. Streamline document workflows for admins, lecturers, and students.">

        <title>{{ config('app.name', 'GetDocy') }} - Academic Document Management Platform</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
        
        <!-- Font Awesome 6 (free icons) -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* Custom styles beyond Tailwind */
                body {
                    font-family: 'Inter', sans-serif;
                }
                .gradient-bg {
                    background: radial-gradient(circle at 10% 20%, rgba(25, 91, 255, 0.08) 0%, rgba(25, 91, 255, 0.02) 90%);
                }
                .hero-pattern {
                    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23195bff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
                }
                .card-hover {
                    transition: all 0.3s ease;
                }
                .card-hover:hover {
                    transform: translateY(-4px);
                    box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
                }
                .role-card {
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                }
                .role-card:hover {
                    transform: translateY(-8px);
                }
                .glow-text {
                    text-shadow: 0 0 20px rgba(25, 91, 255, 0.3);
                }
                @keyframes float {
                    0% { transform: translateY(0px); }
                    50% { transform: translateY(-10px); }
                    100% { transform: translateY(0px); }
                }
                .float-animation {
                    animation: float 6s ease-in-out infinite;
                }
            </style>
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    darkMode: 'class',
                    theme: {
                        extend: {
                            fontFamily: {
                                'sans': ['Inter', 'system-ui', 'sans-serif'],
                            },
                            colors: {
                                primary: {
                                    50: '#eef4ff',
                                    100: '#d9e6ff',
                                    200: '#bcd1ff',
                                    300: '#8eb2ff',
                                    400: '#5989ff',
                                    500: '#195bff',
                                    600: '#0042e5',
                                    700: '#0034b3',
                                    800: '#002b8f',
                                    900: '#002776',
                                },
                                accent: {
                                    50: '#fff1f0',
                                    100: '#ffe0de',
                                    200: '#ffc6c2',
                                    300: '#ff9f98',
                                    400: '#ff6b5f',
                                    500: '#ff3b2a',
                                    600: '#e61a08',
                                    700: '#c21303',
                                    800: '#a01206',
                                    900: '#84150b',
                                }
                            }
                        }
                    }
                }
            </script>
        @endif
    </head>
    <body class="antialiased bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100 font-sans">
        
        <!-- Navigation Header -->
        <header class="sticky top-0 z-50 w-full bg-white/80 dark:bg-gray-950/80 backdrop-blur-xl border-b border-gray-200 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 md:h-20">
                    <!-- Logo -->
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center shadow-lg">
                            <i class="fas fa-graduation-cap text-white text-sm"></i>
                        </div>
                        <span class="font-bold text-xl tracking-tight bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 bg-clip-text text-transparent">GetDocy</span>
                    </div>

                    <!-- Desktop Navigation Links (Auth) -->
                    <div class="hidden md:flex items-center gap-6">
                        
                        @if (Route::has('login'))
                            <div class="flex items-center gap-3 ml-4">
                                @auth
                                    <a href="{{ route("dashboard") }}" class="px-5 py-2 rounded-full bg-primary-600 text-white text-sm font-medium hover:bg-primary-700 transition-all shadow-md hover:shadow-lg">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="px-5 py-2 text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 transition-colors text-sm font-medium">
                                        Log in
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="px-5 py-2 rounded-full bg-primary-600 text-white text-sm font-medium hover:bg-primary-700 transition-all shadow-md hover:shadow-lg">
                                            <i class="fas fa-user-plus mr-2"></i>Get Started
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>

                    <!-- Mobile menu button (simple) -->
                    <div class="md:hidden">
                        <button type="button" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" id="mobile-menu-button">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <!-- Hero Section -->
            <section class="relative overflow-hidden bg-gradient-to-b from-primary-50/20 via-white to-white dark:from-primary-950/20 dark:via-gray-950 dark:to-gray-950">
                <div class="hero-pattern absolute inset-0 opacity-40"></div>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 lg:py-32 relative">
                    <div class="text-center max-w-4xl mx-auto">
                        <div class="inline-flex items-center gap-2 bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 px-4 py-1.5 rounded-full text-sm font-medium mb-6">
                            <i class="fas fa-university text-xs"></i>
                            <span>Trusted by leading universities</span>
                        </div>
                        <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold tracking-tight mb-6 bg-gradient-to-r from-gray-900 via-primary-800 to-gray-900 dark:from-white dark:via-primary-400 dark:to-white bg-clip-text text-transparent">
                            Academic Document Management <br class="hidden sm:block">Reimagined for the Digital Era
                        </h1>
                        <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto mb-10">
                            Empower your university ecosystem with seamless document workflows, role-based dashboards, and intelligent collaboration tools designed for administrators, lecturers, and students.
                        </p>
                        <div class="flex flex-wrap items-center justify-center gap-4">
                            @guest
                                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    Get Started Free <i class="fas fa-arrow-right text-sm"></i>
                                </a>
                                <a href="#features" class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-200 rounded-xl font-semibold hover:bg-gray-50 dark:hover:bg-gray-800/80 transition-all">
                                    Explore Platform <i class="fas fa-play-circle"></i>
                                </a>
                            @else
                                <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl">
                                    Go to Dashboard <i class="fas fa-tachometer-alt"></i>
                                </a>
                            @endguest
                        </div>
                        
                        <!-- Hero Stats -->
                        <div class="grid grid-cols-3 gap-4 md:gap-8 mt-16 pt-8 border-t border-gray-200 dark:border-gray-800">
                            <div>
                                <div class="text-2xl md:text-3xl font-bold text-primary-600 dark:text-primary-400">500+</div>
                                <div class="text-xs md:text-sm text-gray-500 dark:text-gray-400">Universities Worldwide</div>
                            </div>
                            <div>
                                <div class="text-2xl md:text-3xl font-bold text-primary-600 dark:text-primary-400">1.2M+</div>
                                <div class="text-xs md:text-sm text-gray-500 dark:text-gray-400">Documents Managed</div>
                            </div>
                            <div>
                                <div class="text-2xl md:text-3xl font-bold text-primary-600 dark:text-primary-400">98%</div>
                                <div class="text-xs md:text-sm text-gray-500 dark:text-gray-400">Satisfaction Rate</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features Grid -->
            <section id="features" class="py-20 md:py-28 bg-gray-50 dark:bg-gray-900/50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12 md:mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold mb-4">Everything you need for modern academic document management</h2>
                        <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Powerful features that streamline document workflows across your entire university ecosystem.</p>
                    </div>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Feature 1 -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 card-hover">
                            <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-xl flex items-center justify-center mb-5 text-primary-600 dark:text-primary-400">
                                <i class="fas fa-cloud-upload-alt text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Centralized Repository</h3>
                            <p class="text-gray-600 dark:text-gray-400">All academic documents, course materials, research papers, and administrative files in one secure, searchable hub.</p>
                        </div>
                        <!-- Feature 2 -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 card-hover">
                            <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-xl flex items-center justify-center mb-5 text-primary-600 dark:text-primary-400">
                                <i class="fas fa-users-cog text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Role-Based Dashboards</h3>
                            <p class="text-gray-600 dark:text-gray-400">Tailored experiences for admins, lecturers, and students with granular permissions and custom workflows.</p>
                        </div>
                        <!-- Feature 3 -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 card-hover">
                            <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-xl flex items-center justify-center mb-5 text-primary-600 dark:text-primary-400">
                                <i class="fas fa-code-branch text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Smart Version Control</h3>
                            <p class="text-gray-600 dark:text-gray-400">Automatic version tracking, change history, and rollback capabilities for all uploaded documents.</p>
                        </div>
                        <!-- Feature 4 -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 card-hover">
                            <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-xl flex items-center justify-center mb-5 text-primary-600 dark:text-primary-400">
                                <i class="fas fa-chalkboard-teacher text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Assignment Submission</h3>
                            <p class="text-gray-600 dark:text-gray-400">Streamlined submission workflow with plagiarism checking, grading rubrics, and automated feedback.</p>
                        </div>
                        <!-- Feature 5 -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 card-hover">
                            <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-xl flex items-center justify-center mb-5 text-primary-600 dark:text-primary-400">
                                <i class="fas fa-lock text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Enterprise Security</h3>
                            <p class="text-gray-600 dark:text-gray-400">Bank-grade encryption, SSO integration, and compliance with academic data protection standards.</p>
                        </div>
                        <!-- Feature 6 -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 card-hover">
                            <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-xl flex items-center justify-center mb-5 text-primary-600 dark:text-primary-400">
                                <i class="fas fa-chart-line text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Analytics & Insights</h3>
                            <p class="text-gray-600 dark:text-gray-400">Real-time dashboards, document engagement metrics, and institutional reporting for data-driven decisions.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Role-Based Dashboards Section (Cards for Admin, Lecturer, Student) -->
            <section id="roles" class="py-20 md:py-28 bg-white dark:bg-gray-950">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12 md:mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold mb-4">Designed for every role in your university</h2>
                        <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Personalized dashboards and tools that empower each user to excel.</p>
                    </div>
                    <div class="grid md:grid-cols-3 gap-8">
                        <!-- Admin Card -->
                        <div class="rounded-2xl bg-gradient-to-br from-gray-50 to-white dark:from-gray-900 dark:to-gray-800/50 border border-gray-200 dark:border-gray-800 p-6 role-card shadow-md">
                            <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900/40 rounded-2xl flex items-center justify-center mb-5">
                                <i class="fas fa-user-shield text-2xl text-primary-600 dark:text-primary-400"></i>
                            </div>
                            <h3 class="text-2xl font-bold mb-3">Administrator</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Complete institutional oversight and control.</p>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-start gap-2"><i class="fas fa-check-circle text-primary-500 mt-1 text-xs"></i> <span>User & role management</span></li>
                                <li class="flex items-start gap-2"><i class="fas fa-check-circle text-primary-500 mt-1 text-xs"></i> <span>System-wide analytics</span></li>
                                <li class="flex items-start gap-2"><i class="fas fa-check-circle text-primary-500 mt-1 text-xs"></i> <span>Compliance & audit logs</span></li>
                                <li class="flex items-start gap-2"><i class="fas fa-check-circle text-primary-500 mt-1 text-xs"></i> <span>Custom permission sets</span></li>
                            </ul>
                        </div>

                        <!-- Lecturer Card -->
                        <div class="rounded-2xl bg-gradient-to-br from-gray-50 to-white dark:from-gray-900 dark:to-gray-800/50 border border-gray-200 dark:border-gray-800 p-6 role-card shadow-md transform md:scale-105 border-t-4 border-t-primary-500">
                            <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900/40 rounded-2xl flex items-center justify-center mb-5">
                                <i class="fas fa-chalkboard-user text-2xl text-primary-600 dark:text-primary-400"></i>
                            </div>
                            <h3 class="text-2xl font-bold mb-3">Lecturer</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Streamline course delivery and assessment.</p>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-start gap-2"><i class="fas fa-check-circle text-primary-500 mt-1 text-xs"></i> <span>Course material management</span></li>
                                <li class="flex items-start gap-2"><i class="fas fa-check-circle text-primary-500 mt-1 text-xs"></i> <span>Assignment creation & grading</span></li>
                                <li class="flex items-start gap-2"><i class="fas fa-check-circle text-primary-500 mt-1 text-xs"></i> <span>Student progress tracking</span></li>
                                <li class="flex items-start gap-2"><i class="fas fa-check-circle text-primary-500 mt-1 text-xs"></i> <span>Announcements & feedback</span></li>
                            </ul>
                        </div>

                        <!-- Student Card -->
                        <div class="rounded-2xl bg-gradient-to-br from-gray-50 to-white dark:from-gray-900 dark:to-gray-800/50 border border-gray-200 dark:border-gray-800 p-6 role-card shadow-md">
                            <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900/40 rounded-2xl flex items-center justify-center mb-5">
                                <i class="fas fa-user-graduate text-2xl text-primary-600 dark:text-primary-400"></i>
                            </div>
                            <h3 class="text-2xl font-bold mb-3">Student</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Centralized learning and submission hub.</p>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-start gap-2"><i class="fas fa-check-circle text-primary-500 mt-1 text-xs"></i> <span>Access course materials</span></li>
                                <li class="flex items-start gap-2"><i class="fas fa-check-circle text-primary-500 mt-1 text-xs"></i> <span>Submit assignments online</span></li>
                                <li class="flex items-start gap-2"><i class="fas fa-check-circle text-primary-500 mt-1 text-xs"></i> <span>Collaborate on group projects</span></li>
                                <li class="flex items-start gap-2"><i class="fas fa-check-circle text-primary-500 mt-1 text-xs"></i> <span>Track grades & feedback</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Testimonials Section -->
            <section id="testimonials" class="py-20 bg-gray-50 dark:bg-gray-900/50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl md:text-4xl font-bold mb-4">Trusted by academic leaders worldwide</h2>
                        <p class="text-gray-600 dark:text-gray-400">Join 500+ universities revolutionizing their document workflows.</p>
                    </div>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
                            <i class="fas fa-quote-left text-primary-300 dark:text-primary-700 text-2xl mb-3"></i>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">"GetDocy transformed how we manage academic records. The role-based dashboards saved our faculty countless hours."</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary-200 dark:bg-primary-800 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-primary-600 dark:text-primary-300"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">Dr. Sarah Chen</p>
                                    <p class="text-sm text-gray-500">Dean of Academics, Stanford University</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
                            <i class="fas fa-quote-left text-primary-300 dark:text-primary-700 text-2xl mb-3"></i>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">"The assignment submission and grading workflow is incredibly intuitive. My students love the real-time feedback."</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary-200 dark:bg-primary-800 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-primary-600 dark:text-primary-300"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">Prof. James O'Connor</p>
                                    <p class="text-sm text-gray-500">MIT, Department of Engineering</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
                            <i class="fas fa-quote-left text-primary-300 dark:text-primary-700 text-2xl mb-3"></i>
                            <p class="text-gray-700 dark:text-gray-300 mb-4">"Finally a platform that understands university document management. The analytics dashboard is a game-changer for administrators."</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary-200 dark:bg-primary-800 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-primary-600 dark:text-primary-300"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">Elena Vasquez</p>
                                    <p class="text-sm text-gray-500">IT Director, University of Melbourne</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Call to Action -->
            <section class="py-20 bg-gradient-to-r from-primary-600 to-primary-800 text-white">
                <div class="max-w-4xl mx-auto text-center px-4 sm:px-6">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to modernize your university's document management?</h2>
                    <p class="text-lg text-primary-100 mb-8">Join the growing community of institutions using GetDocy to streamline academic workflows.</p>
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white text-black hover:bg-gray-100 px-8 py-3 rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl text-lg">
                            Start Your Free Trial <i class="fas fa-arrow-right"></i>
                        </a>
                    @else
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 bg-white text-primary-700 hover:bg-gray-100 px-8 py-3 rounded-xl font-semibold transition-all shadow-lg">
                            Go to Dashboard <i class="fas fa-tachometer-alt"></i>
                        </a>
                    @endguest
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 dark:bg-black text-gray-400 py-12 border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-graduation-cap text-white text-sm"></i>
                            </div>
                            <span class="font-bold text-xl text-white">GetDocy</span>
                        </div>
                        <p class="text-sm">Academic Document Management Platform for modern universities.</p>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-4">Product</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#features" class="hover:text-white transition">Features</a></li>
                            <li><a href="#roles" class="hover:text-white transition">For Roles</a></li>
                            <li><a href="#" class="hover:text-white transition">Pricing</a></li>
                            <li><a href="#" class="hover:text-white transition">Security</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-4">Company</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-white transition">About Us</a></li>
                            <li><a href="#" class="hover:text-white transition">Blog</a></li>
                            <li><a href="#" class="hover:text-white transition">Careers</a></li>
                            <li><a href="#" class="hover:text-white transition">Contact</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-4">Legal</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                            <li><a href="#" class="hover:text-white transition">GDPR Compliance</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-800 pt-8 text-sm text-center">
                    &copy; {{ date('Y') }} GetDocy. All rights reserved. Empowering academic excellence through smart document management.
                </div>
            </div>
        </footer>

        <!-- Simple mobile menu JavaScript (optional) -->
        <script>
            document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
                // In a real implementation, you'd add a mobile menu drawer.
                // For simplicity, we just show an alert - but you can extend.
                alert('Mobile navigation would open here. Full responsive menu available in production.');
            });
        </script>
    </body>
</html>