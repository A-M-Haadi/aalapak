<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
            .animate-float {
                animation: float 6s ease-in-out infinite;
            }
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .animate-fade-in-up {
                animation: fadeInUp 0.6s ease-out;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
            
            <!-- Animated Background -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50">
                <!-- Decorative Circles -->
                <div class="absolute top-0 left-0 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float"></div>
                <div class="absolute top-0 right-0 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float" style="animation-delay: 2s;"></div>
                <div class="absolute -bottom-32 left-1/2 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float" style="animation-delay: 4s;"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10 w-full max-w-md px-6">
                
                <!-- Logo Section -->
                <div class="flex justify-center w-full mb-6">
                    <a href="/" class="flex items-center gap-2 animate-scale-in">
                        <div class="w-24 h-24 bg-aalapak-orange rounded-lg flex items-center justify-center text-white shadow-lg shadow-orange-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </a>
                </div>
                <div class="text-center mb-8 animate-fade-in-up">
                    <h1 class="text-2xl font-extrabold text-aalapak-blue tracking-tight">
                        Aalapak
                    </h1>
                    <p class="mt-2 text-gray-600">Platform jual beli terpercaya</p>
                </div>

                <!-- Card -->
                <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-white/20 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="p-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>

            <!-- Decorative Elements -->
            <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-blue-500 to-transparent opacity-20"></div>
        </div>
    </body>
</html>