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
            /* Custom Animations */
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            @keyframes slideDown {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .animate-fade-in {
                animation: fadeIn 0.5s ease-out;
            }

            .animate-slide-down {
                animation: slideDown 0.3s ease-out;
            }

            /* Line clamp utility */
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            /* Smooth scrollbar */
            ::-webkit-scrollbar {
                width: 10px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            ::-webkit-scrollbar-thumb {
                background: linear-gradient(180deg, #3b82f6, #8b5cf6);
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(180deg, #2563eb, #7c3aed);
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100">
            
            <!-- Modern Navigation -->
            @include('layouts.navigation')

            <!-- Page Heading with Modern Design -->
            @isset($header)
                <header class="bg-white/80 backdrop-blur-lg shadow-sm border-b border-gray-200 sticky top-16 z-40 animate-slide-down">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content with Animation -->
            <main class="animate-fade-in">
                {{ $slot }}
            </main>

                <!-- Footer Simple -->
            <footer class="bg-white border-t border-gray-200 pt-12 pb-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <p class="text-2xl font-extrabold text-aalapak-blue mb-4">Aalapak</p>
                    <p class="text-gray-500 text-sm mb-8">Platform e-commerce terpercaya untuk memenuhi segala kebutuhan Anda.</p>
                    <p class="text-gray-400 text-xs">&copy; {{ date('Y') }} Aalapak. All rights reserved.</p>
                </div>
            </footer>
        </div>

        <!-- Scroll to Top Button -->
        <button id="scrollToTop" class="fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-full shadow-2xl hover:shadow-3xl transform hover:scale-110 transition-all duration-300 opacity-0 pointer-events-none z-50 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
            </svg>
        </button>

        <script>
            // Scroll to Top functionality
            const scrollToTopBtn = document.getElementById('scrollToTop');
            
            window.addEventListener('scroll', () => {
                if (window.pageYOffset > 300) {
                    scrollToTopBtn.classList.remove('opacity-0', 'pointer-events-none');
                    scrollToTopBtn.classList.add('opacity-100');
                } else {
                    scrollToTopBtn.classList.add('opacity-0', 'pointer-events-none');
                    scrollToTopBtn.classList.remove('opacity-100');
                }
            });
            
            scrollToTopBtn.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        </script>
    </body>
</html>