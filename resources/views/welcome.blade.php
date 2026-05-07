<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">

    <title>Portfolio SSO</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes gradient {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
            opacity: 0;
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 3s ease infinite;
        }

        .animate-spin-slow {
            animation: spin-slow 3s linear infinite;
        }

        .delay-75 {
            animation-delay: 75ms;
        }

        .delay-100 {
            animation-delay: 100ms;
        }

        .delay-150 {
            animation-delay: 150ms;
        }

        .delay-200 {
            animation-delay: 200ms;
        }

        .delay-300 {
            animation-delay: 300ms;
        }

        .delay-700 {
            animation-delay: 700ms;
        }

        /* Smooth scrolling for the entire page */
        html {
            scroll-behavior: smooth;
        }
    </style>
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    @endif
</head>

{{-- <body class="font-sans antialiased d:bg-black d:text-white/50">
    <x-navbar/>
    <div class="bg-gray-50 text-black/50 d:bg-black d:text-white/50 ">
        <img id="background" class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg" alt="Laravel background" />
        <x-hero/>
        <img src="imgs/pc.png" class="mx-auto md:w-1/3" alt="">
        <div class="text-center pb-10">
            <h1 class="text-4xl text-black font-bold leading-snug">WEBSITES AND APPS</h1>
            <h2 class="text-3xl text-blue-500">Seamless design & top-notch development</h2>
            <p class="md:w-[35rem] mx-auto text-center">
                Elevate your brand's online experience with our professional website services. Our team specializes in
                creating user-friendly designs and interfaces that captivate your audience. Experience the difference
                with custom-built designs from the ground up, ensuring a unique and tailored identity for your brand.
                Let us bring your vision to life on time and within your budget.
            </p>
        </div>

        <div class="md:flex md:space-x-3 md:space-y-0 grid space-y-10 justify-between items-start md:max-w-7xl mx-auto">
            <x-protfolio-plan />
            <x-business-plan />
            <x-ecommerce-plan />
        </div>
    </div>
</body> --}}

<body>
    <div id="app"
        class="w-full min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 text-gray-900 dark:text-gray-100 transition-all duration-500 overflow-x-hidden relative">

        <!-- Network Background Animation -->
        <canvas id="networkCanvas" class="fixed inset-0 w-full h-full pointer-events-none" style="z-index: 1"></canvas>

        <!-- Animated background elements -->
        <div class="fixed inset-0 w-full overflow-hidden pointer-events-none" style="z-index: 2">
            <div
                class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse">
            </div>
            <div
                class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse delay-700">
            </div>
        </div>

        <header id="header"
            class="fixed top-0 left-0 right-0 w-full z-50 transition-all duration-500 bg-transparent py-6">
            <div class="w-full max-w-6xl mx-auto px-6 flex items-center justify-between">
                <div class="flex items-center gap-3 group cursor-pointer">
                    <div
                        class="w-16 h-16 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-lg transform transition-all duration-300 group-hover:scale-110 group-hover:rotate-3">
                        <img src="./imgs/scorpiosoft-logo.png" alt="" class="w-full">
                    </div>
                    <div class="transform transition-all duration-300 group-hover:translate-x-1">
                        <h1
                            class="text-lg font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            {{ $content['brand_name'] ?? 'Scorpio Software' }}
                        </h1>
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                            {{ $content['brand_tagline'] ?? 'Software Development • Software Engineer' }}
                        </p>
                    </div>
                </div>

                <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                    <a href="#services"
                        class="nav-link relative py-2 transition-all duration-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                        Services
                        <span
                            class="nav-underline absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 transform transition-transform duration-300 scale-x-0"></span>
                    </a>
                    {{-- <a href="#projects"
                        class="nav-link relative py-2 transition-all duration-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                        Projects
                        <span
                            class="nav-underline absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 transform transition-transform duration-300 scale-x-0"></span>
                    </a> --}}
                    <a href="#pricing"
                        class="nav-link relative py-2 transition-all duration-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                        Pricing
                        <span
                            class="nav-underline absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 transform transition-transform duration-300 scale-x-0"></span>
                    </a>
                    <a href="#contact"
                        class="nav-link relative py-2 transition-all duration-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                        Contact
                        <span
                            class="nav-underline absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 transform transition-transform duration-300 scale-x-0"></span>
                    </a>
                    <button onclick="toggleDarkMode()"
                        class="ml-4 relative overflow-hidden group bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-full px-4 py-2 text-xs font-medium shadow-lg transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                        <span class="relative z-10 flex items-center gap-2">
                            <svg id="lightIcon" xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 animate-spin-slow hidden" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m8.66-12.34l-.7.7M4.04 19.96l-.7-.7M21 12h-1M4 12H3m15.66 4.66l-.7-.7M6.34 6.34l-.7.7" />
                            </svg>
                            <svg id="darkIcon" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 animate-pulse"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                            </svg>
                            <span id="themeText">Dark</span>
                        </span>
                        <span
                            class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    </button>
                </nav>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button onclick="toggleMobileMenu()"
                        class="p-2 border-2 border-gray-300 dark:border-gray-600 rounded-xl transition-all duration-300 hover:border-indigo-500 hover:shadow-lg">
                        <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg id="closeIcon" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 hidden" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Mobile Menu Dropdown -->
                    <div id="mobileMenu"
                        class="hidden absolute right-0 mt-3 w-64 bg-white/95 dark:bg-gray-800/95 backdrop-blur border-2 border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-2xl animate-fade-in-up">
                        <nav class="space-y-4">
                            <a href="#services" onclick="closeMobileMenu()"
                                class="block font-medium hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-300">Services</a>
                            {{-- <a href="#projects" onclick="closeMobileMenu()"
                                class="block font-medium hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-300">Projects</a> --}}
                            <a href="#pricing" onclick="closeMobileMenu()"
                                class="block font-medium hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-300">Plans</a>
                            <a href="#contact" onclick="closeMobileMenu()"
                                class="block font-medium hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-300">Contact</a>
                            <button onclick="toggleDarkMode(); closeMobileMenu();"
                                class="w-full text-left font-medium bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg px-4 py-2 shadow-lg transform transition-all duration-300 hover:scale-105">
                                Switch to <span id="mobileThemeText">Light</span> Mode
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-6 mt-16 pb-10 relative z-10">
            <!-- Hero Section -->
            <section class="w-full grid md:grid-cols-2 gap-12 items-center min-h-screen">
                <div class="animate-fade-in-up">
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 rounded-full text-xs font-medium mb-6 animate-pulse">
                        <span class="w-2 h-2 bg-indigo-500 rounded-full animate-ping"></span>
                        {{ $content['hero_badge'] ?? 'Available for new projects' }}
                    </span>

                    <h2
                        class="text-5xl md:text-6xl font-black leading-tight bg-gradient-to-br from-gray-900 via-indigo-800 to-purple-700 dark:from-white dark:via-indigo-200 dark:to-purple-300 bg-clip-text text-transparent animate-gradient">
                        {{ $content['hero_headline'] ?? 'I build fast, maintainable web apps & e‑commerce systems' }}
                    </h2>

                    <p class="mt-6 text-lg text-gray-600 dark:text-gray-300 max-w-xl leading-relaxed">
                        {{ $content['hero_description'] ?? 'I design and develop portfolio sites, business websites, e‑commerce stores and full POS systems. I also provide hosting, domain setup and continuous support.' }}
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="#contact"
                            class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold shadow-xl transform transition-all duration-300 hover:scale-105 hover:shadow-2xl overflow-hidden">
                            <span class="relative z-10">Work with me</span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 transform transition-transform duration-300 group-hover:translate-x-1"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                            <span
                                class="absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        </a>
                        <a href="#pricing"
                            class="group inline-flex items-center gap-2 border-2 border-gray-300 dark:border-gray-600 rounded-xl px-6 py-3 font-medium transition-all duration-300 hover:border-indigo-500 hover:text-indigo-600 dark:hover:text-indigo-400 hover:shadow-lg hover:scale-105">
                            See plans
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 transform transition-transform duration-300 group-hover:rotate-45"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>

                    <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-4">
                        @php
                            $stats = [
                                ['label' => 'Years',    'value' => $content['hero_stat_years']    ?? '6+',   'delay' => '0'],
                                ['label' => 'Projects', 'value' => $content['hero_stat_projects'] ?? '30+',  'delay' => '100'],
                                ['label' => 'Clients',  'value' => $content['hero_stat_clients']  ?? '20+',  'delay' => '200'],
                                ['label' => 'Support',  'value' => $content['hero_stat_support']  ?? '24/7', 'delay' => '300'],
                            ];
                        @endphp
                        @foreach ($stats as $stat)
                            <div class="animate-fade-in-up group relative rounded-xl p-4 bg-white/90 dark:bg-gray-800/90 backdrop-blur border-2 border-gray-200 dark:border-gray-700 shadow-lg transform transition-all duration-500 hover:scale-110 hover:shadow-xl hover:border-indigo-500"
                                style="animation-delay: {{ $stat['delay'] }}ms">
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <div class="relative z-10">
                                    <div
                                        class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">
                                        {{ $stat['label'] }}</div>
                                    <div
                                        class="text-2xl font-black bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mt-1">
                                        {{ $stat['value'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="animate-fade-in-up delay-300">
                    <div class="relative group">
                        <div
                            class="absolute -inset-4 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-3xl blur-2xl opacity-30 group-hover:opacity-50 animate-pulse transition-opacity duration-500">
                        </div>
                        <div
                            class="relative bg-gradient-to-br from-white to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-3xl p-8 shadow-2xl transform transition-all duration-500 hover:scale-105">
                            <div class="absolute top-4 right-4 flex gap-2">
                                <span class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></span>
                                <span class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse delay-75"></span>
                                <span class="w-3 h-3 bg-green-500 rounded-full animate-pulse delay-150"></span>
                            </div>

                            <h3
                                class="font-bold text-xl mb-4 bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                {{ $content['hero_featured_title'] ?? 'Featured Project' }}</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-6">{{ $content['hero_featured_desc'] ?? 'E-commerce websites built from scratch & complete POS systems tailored for small to medium businesses.' }}</p>

                            <div
                                class="bg-white/50 dark:bg-gray-800/50 backdrop-blur rounded-xl p-4 border border-gray-200 dark:border-gray-700 mb-6">
                                <div class="text-sm font-semibold mb-3">Tech Stack</div>
                                <div class="flex flex-wrap gap-2">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-700 transform transition-all duration-300 hover:scale-110 hover:shadow-md">
                                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L1.605 6v12L12 24l10.395-6V6L12 0zm0 2.192l8.203 4.73v9.156L12 20.808l-8.203-4.73V6.922L12 2.192z"/></svg>
                                        Laravel
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-cyan-100 dark:bg-cyan-900/40 text-cyan-700 dark:text-cyan-300 border border-cyan-200 dark:border-cyan-700 transform transition-all duration-300 hover:scale-110 hover:shadow-md">
                                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M14.23 12.004a2.236 2.236 0 0 1-2.235 2.236 2.236 2.236 0 0 1-2.236-2.236 2.236 2.236 0 0 1 2.235-2.236 2.236 2.236 0 0 1 2.236 2.236zm2.648-10.69c-1.346 0-3.107.96-4.888 2.622-1.78-1.653-3.542-2.602-4.887-2.602-.41 0-.783.093-1.106.278-1.375.793-1.683 3.264-.973 6.365C1.98 8.917 0 10.42 0 12.004c0 1.59 1.99 3.097 5.043 4.03-.704 3.113-.39 5.588.988 6.38.32.187.69.275 1.102.275 1.345 0 3.107-.96 4.888-2.624 1.78 1.654 3.542 2.603 4.887 2.603.41 0 .783-.09 1.106-.275 1.374-.792 1.683-3.263.973-6.365C22.02 15.096 24 13.59 24 12.004c0-1.59-1.99-3.097-5.043-4.032.704-3.11.39-5.587-.988-6.38-.318-.184-.688-.277-1.092-.278zm-.005 1.09c.225 0 .406.044.558.127.666.382.955 1.835.73 3.704-.054.46-.143.946-.25 1.44-.96-.236-2.006-.417-3.107-.534-.66-.905-1.345-1.727-2.035-2.447 1.592-1.48 3.087-2.292 4.105-2.292zM5.317 5.09c1.023 0 2.515.808 4.11 2.28-.686.72-1.37 1.537-2.02 2.442-1.107.117-2.154.298-3.113.538-.112-.49-.195-.964-.254-1.42-.23-1.868.054-3.32.714-3.707.19-.09.4-.127.563-.132zm4.866 3.584a20.93 20.93 0 0 1 1.814-.103c.632 0 1.246.036 1.826.104-.598.96-1.208 1.99-1.826 3.054-.618-1.06-1.228-2.09-1.814-3.055zm-1.355 7.715c.344.58.695 1.157 1.07 1.728-1.18-.152-2.29-.388-3.29-.7.3-.97.72-1.97 1.22-2.98l1 1.952zm6.36-1.95c.5 1.006.92 2.002 1.22 2.968-1.003.313-2.117.55-3.302.702.38-.575.73-1.154 1.075-1.74l1.007-1.93zm.916 4.08c.506-.157 1.003-.332 1.49-.52.424.992.713 1.96.802 2.826.083.797-.056 1.393-.366 1.575-.19.11-.43.157-.712.157-.738 0-1.713-.394-2.8-1.1.395-.477.787-.988 1.165-1.528l.42-.41zm-8.27 1.953c-.384.543-.778 1.056-1.176 1.535-1.084.703-2.057 1.095-2.793 1.095-.278 0-.513-.047-.703-.152-.308-.18-.449-.773-.37-1.565.088-.866.377-1.834.8-2.825.488.188.99.362 1.5.52l.4.39c.376.54.77 1.05 1.342 1.002zm4.135 3.16c-.692.73-1.39 1.363-2.064 1.88-.673.517-1.3.847-1.835.847-.245 0-.46-.054-.64-.16-.532-.308-.735-1.063-.574-2.15.053-.36.147-.742.272-1.136.79.26 1.626.465 2.494.608.432.694.877 1.358 1.347 1.11zm-.002-6.32a20.82 20.82 0 0 1 0 3.07c-.57.04-1.147.07-1.736.07-.588 0-1.163-.027-1.73-.067a20.82 20.82 0 0 1 0-3.073c.567-.04 1.142-.066 1.73-.066.59 0 1.166.026 1.736.066z"/></svg>
                                        React
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-sky-100 dark:bg-sky-900/40 text-sky-700 dark:text-sky-300 border border-sky-200 dark:border-sky-700 transform transition-all duration-300 hover:scale-110 hover:shadow-md">
                                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12.001 4.8c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624C13.666 10.618 15.027 12 18.001 12c3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C16.337 6.182 14.976 4.8 12.001 4.8zm-6 7.2c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624 1.177 1.194 2.538 2.576 5.512 2.576 3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C10.337 13.382 8.976 12 6.001 12z"/></svg>
                                        Tailwind CSS
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 dark:bg-orange-900/40 text-orange-700 dark:text-orange-300 border border-orange-200 dark:border-orange-700 transform transition-all duration-300 hover:scale-110 hover:shadow-md">
                                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M16.405 5.501c-.115 0-.193.014-.274.033v.013h.014c.054.104.146.18.214.273.054.107.1.214.154.32l.014-.015c.094-.066.14-.172.14-.333-.04-.047-.046-.094-.08-.14-.04-.067-.126-.1-.18-.153zM5.77 18.695h-.927a50.854 50.854 0 0 0-.27-4.41h-.008l-1.41 4.41H2.45l-1.4-4.41h-.01a72.892 72.892 0 0 0-.195 4.41H0c.055-1.966.192-3.81.41-5.53h1.15l1.335 4.064h.008l1.347-4.064h1.095c.242 2.015.384 3.86.428 5.53zm4.017-4.08c-.378 2.045-.876 3.533-1.492 4.46-.482.716-1.01 1.073-1.583 1.073-.153 0-.34-.046-.566-.138v-.494c.11.017.24.026.386.026.268 0 .483-.075.647-.222.197-.18.295-.382.295-.605 0-.155-.077-.47-.23-.944L6.23 14.615h.91l.727 2.36c.164.536.233.91.205 1.123.4-1.064.678-2.227.835-3.483zm12.325 4.08h-2.63v-5.53h.885v4.85h1.745zm-3.32.135c-.591 0-1.043-.269-1.353-.808-.309-.54-.463-1.287-.463-2.243 0-.868.17-1.575.508-2.12.338-.546.814-.82 1.427-.82.578 0 1.02.252 1.33.757h.01l-.01-.244v-1.806h.88v5.964h-.713l-.094-.467h-.016c-.289.35-.69.787-1.506.787zm.303-.782c.375 0 .62-.134.785-.402l.012-2.183c-.16-.268-.392-.402-.747-.402-.355 0-.612.16-.768.482-.157.32-.235.77-.235 1.352 0 .583.076 1.014.23 1.295.152.28.395.42.723.42z"/></svg>
                                        MySQL
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-700 transform transition-all duration-300 hover:scale-110 hover:shadow-md">
                                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></svg>
                                        Real-time
                                    </span>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                {{-- <a class="group inline-flex items-center gap-1 text-sm font-medium text-indigo-600 dark:text-indigo-400 transition-all duration-300 hover:gap-2"
                                    href="#projects">
                                    View projects
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a> --}}
                                <a class="group inline-flex items-center gap-1 text-sm font-medium text-purple-600 dark:text-purple-400 transition-all duration-300 hover:gap-2"
                                    href="#contact">
                                    Get similar
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Services Section -->
            <section id="services" class="mt-20 scroll-mt-20">
                <div class="text-center mb-12 animate-fade-in-up">
                    <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">{{ $content['services_subtitle'] ?? 'What I Offer' }}</span>
                    <h3
                        class="text-4xl font-black mt-2 bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                        {{ $content['services_title'] ?? 'Services' }}</h3>
                    <p class="mt-4 text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">{{ $content['services_description'] ?? 'I offer end-to-end services: planning, development, deployment, hosting, domain management and ongoing maintenance.' }}</p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @php $services = \App\Models\Service::orderBy('sort_order')->orderBy('id')->get(); @endphp

                    @foreach ($services as $index => $service)
                        <article class="group relative animate-fade-in-up"
                            style="animation-delay: {{ $index * 100 }}ms">
                            @if ($service->popular)
                                <span
                                    class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-1 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-xs font-bold rounded-full shadow-lg z-10">POPULAR</span>
                            @endif
                            <div
                                class="relative h-full border-2 border-gray-200 dark:border-gray-700 rounded-2xl p-8 bg-white/90 dark:bg-gray-800/90 backdrop-blur shadow-xl transform transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:border-indigo-500 dark:hover:border-indigo-400 overflow-hidden">
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                </div>

                                <div class="relative z-10">
                                    <span class="text-4xl mb-4 block animate-bounce"
                                        style="animation-delay: {{ $index * 200 }}ms">{{ $service->icon }}</span>
                                    <h4 class="font-bold text-xl mb-2">{{ $service->title }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">{{ $service->subtitle }}</p>

                                    <ul class="space-y-3 mb-8">
                                        @foreach ($service->features ?? [] as $feature)
                                            <li class="flex items-start gap-3 text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 10-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span>{{ $feature }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="flex items-center justify-between max-h-24">
                                        <div
                                            class="text-3xl font-black bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                            {{ $service->price }}</div>
                                        <a href="#contact"
                                            class="group/btn inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white px-4 py-2 rounded-lg font-medium shadow-lg transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                                            Start
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-4 h-4 transform transition-transform duration-300 group-hover/btn:translate-x-1"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            {{-- Projects Section (commented out) --}}
            @if(false)
            <section id="projects" class="mt-32 scroll-mt-20">
                <div class="text-center mb-12 animate-fade-in-up">
                    <span
                        class="text-xs font-bold uppercase tracking-wider text-purple-600 dark:text-purple-400">Portfolio</span>
                    <h3
                        class="text-4xl font-black mt-2 bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                        Selected Projects</h3>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @php
                        $projects = [
                            [
                                'id' => 1,
                                'name' => 'Maison Nahle (E‑commerce)',
                                'tags' => ['Laravel', 'Tailwind', 'MySQL'],
                                'color' => 'from-blue-500 to-cyan-500',
                            ],
                            [
                                'id' => 2,
                                'name' => 'Midlr',
                                'tags' => ['Livewire', 'PHP', 'Fullstack'],
                                'color' => 'from-purple-500 to-pink-500',
                            ],
                            [
                                'id' => 3,
                                'name' => 'POS for Retail Chain',
                                'tags' => ['C#', 'POS', 'Inventory'],
                                'color' => 'from-orange-500 to-red-500',
                            ],
                        ];
                    @endphp

                    @foreach ($projects as $index => $project)
                        <div class="group relative animate-fade-in-up"
                            style="animation-delay: {{ $index * 100 }}ms">
                            <div
                                class="absolute -inset-1 bg-gradient-to-r {{ $project['color'] }} opacity-30 group-hover:opacity-70 rounded-2xl blur-xl transition-all duration-500 animate-pulse">
                            </div>
                            <div
                                class="relative bg-white/90 dark:bg-gray-800/90 backdrop-blur rounded-xl p-6 border-2 border-gray-200 dark:border-gray-700 shadow-xl transform transition-all duration-500 hover:scale-105 hover:shadow-2xl">
                                {{-- <div
                                    class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br {{ $project['color'] }} opacity-10 rounded-xl">
                                </div> --}}

                                <h4 class="font-bold text-lg mb-4 relative z-10">{{ $project['name'] }}</h4>
                                <div class="flex flex-wrap gap-2 mb-6">
                                    @foreach ($project['tags'] as $tag)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 transform transition-all duration-300 hover:scale-110 hover:shadow-lg">
                                            {{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                                <a href="#contact"
                                    class="group/link inline-flex items-center gap-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 transition-all duration-300 hover:gap-3">
                                    Discuss this project
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4 transform transition-transform duration-300 group-hover/link:translate-x-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Contact Section -->
            <section id="contact" class="mt-32 mb-20 scroll-mt-20">
                <div class="text-center mb-12 animate-fade-in-up">
                    <span class="text-xs font-bold uppercase tracking-wider text-green-600 dark:text-green-400">Let's
                        Connect</span>
                    <h3
                        class="text-4xl font-black mt-2 bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                        Start Your Project</h3>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <div class="animate-fade-in-up">
                        <div class="relative group">
                            <div
                                class="absolute -inset-4 bg-gradient-to-r from-green-500 to-emerald-500 rounded-3xl blur-2xl opacity-20 group-hover:opacity-30 animate-pulse transition-opacity duration-500">
                            </div>
                            <div
                                class="relative rounded-2xl border-2 border-gray-200 dark:border-gray-700 p-8 bg-white/90 dark:bg-gray-800/90 backdrop-blur shadow-xl transform transition-all duration-500 hover:scale-105">
                                <h3 class="text-2xl font-bold mb-4">Get a quote</h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-6">Tell me about your project — I'll
                                    respond within one business day.</p>

                                <form class="space-y-4">
                                    <input
                                        class="w-full border-2 bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 bg-transparent focus:border-indigo-500 focus:outline-none transition-colors duration-300"
                                        placeholder="Your name">
                                    <input
                                        class="w-full border-2 border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 bg-transparent focus:border-indigo-500 focus:outline-none transition-colors duration-300"
                                        placeholder="Email">
                                    <select
                                        class="w-full border-2 bg-white dark:bg-gray-800  border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 bg-transparent focus:border-indigo-500 focus:outline-none transition-colors duration-300">
                                        <option>Service needed</option>
                                        <option>Portfolio Website</option>
                                        <option>Business Website</option>
                                        <option>E‑commerce + POS</option>
                                    </select>
                                    <textarea
                                        class="w-full border-2 border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 bg-transparent focus:border-indigo-500 focus:outline-none transition-colors duration-300"
                                        rows="4" placeholder="Project details / timeline"></textarea>
                                    <div class="flex gap-4">
                                        <button type="submit"
                                            class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg transform transition-all duration-300 hover:scale-105 hover:shadow-xl">Send
                                            Message</button>
                                        <button type="button"
                                            class="flex-1 border-2 border-gray-300 dark:border-gray-600 px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:border-indigo-500 hover:shadow-lg">Schedule
                                            Call</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="animate-fade-in-up delay-200">
                        <div class="relative group">
                            <div
                                class="absolute -inset-4 bg-gradient-to-r from-purple-500 to-pink-500 rounded-3xl blur-2xl opacity-20 group-hover:opacity-30 animate-pulse transition-opacity duration-500">
                            </div>
                            <div
                                class="relative rounded-2xl border-2 border-gray-200 dark:border-gray-700 p-8 bg-white/90 dark:bg-gray-800/90 backdrop-blur shadow-xl">
                                <h3 class="text-2xl font-bold mb-4">Contact & Availability</h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-6">{{ $content['contact_location'] ?? 'Based in Beirut, Lebanon — available for remote or local projects.' }}</p>

                                <div class="space-y-4 mb-8">
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </span>
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Email</div>
                                            <div class="font-semibold">{{ $content['contact_email'] ?? 'info@scorpiosoft.tech' }}</div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <span
                                            class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </span>
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Phone</div>
                                            <div class="font-semibold">{{ $content['contact_phone'] ?? '+961-71-036488' }}</div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <span
                                            class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </span>
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Working hours</div>
                                            <div class="font-semibold">{{ $content['contact_hours'] ?? '9:00 — 18:00 (GMT+3)' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                    <h5 class="font-bold mb-4">Extras</h5>
                                    <div class="grid grid-cols-2 gap-3">
                                        @foreach (['Maintenance', 'Priority support', 'Training', 'Consulting'] as $extra)
                                            <div class="flex items-center gap-2 text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 10-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ $extra }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="py-12 text-center border-t border-gray-200 dark:border-gray-800">
                <div class="flex items-center justify-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    © {{ date('Y') }} {{ $content['brand_name'] ?? 'Scorpio Software' }} — Crafted with
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500 animate-pulse"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </footer>
        </main>
    </div>

    <script>
        // Smooth scrolling for anchor links
        document.addEventListener('DOMContentLoaded', () => {
            // Handle all anchor links with smooth scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');

                    if (targetId === '#') return;

                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        // Calculate offset for fixed header
                        const headerHeight = document.getElementById('header').offsetHeight;
                        const targetPosition = targetElement.getBoundingClientRect().top + window
                            .scrollY - headerHeight - 20;

                        // Smooth scroll to target
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });

                        // Close mobile menu if it's open
                        const mobileMenu = document.getElementById('mobileMenu');
                        if (!mobileMenu.classList.contains('hidden')) {
                            closeMobileMenu();
                        }
                    }
                });
            });
        });

        // Dark mode functionality
        let isDark = localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);

        function applyTheme() {
            if (isDark) {
                document.documentElement.classList.add('dark');
                document.querySelector('meta[name="theme-color"]').setAttribute('content', '#111827');
                document.getElementById('lightIcon').classList.remove('hidden');
                document.getElementById('darkIcon').classList.add('hidden');
                document.getElementById('themeText').textContent = 'Light';
                document.getElementById('mobileThemeText').textContent = 'Light';
            } else {
                document.documentElement.classList.remove('dark');
                document.querySelector('meta[name="theme-color"]').setAttribute('content', '#ffffff');
                document.getElementById('lightIcon').classList.add('hidden');
                document.getElementById('darkIcon').classList.remove('hidden');
                document.getElementById('themeText').textContent = 'Dark';
                document.getElementById('mobileThemeText').textContent = 'Dark';
            }
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }

        function toggleDarkMode() {
            isDark = !isDark;
            applyTheme();
        }

        // Mobile menu functionality
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const menuIcon = document.getElementById('menuIcon');
            const closeIcon = document.getElementById('closeIcon');

            menu.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        }

        function closeMobileMenu() {
            document.getElementById('mobileMenu').classList.add('hidden');
            document.getElementById('menuIcon').classList.remove('hidden');
            document.getElementById('closeIcon').classList.add('hidden');
        }

        // Scroll effects
        let scrolled = false;
        let activeSection = '';

        window.addEventListener('scroll', () => {
            const header = document.getElementById('header');
            scrolled = window.scrollY > 20;

            if (scrolled) {
                header.classList.add('bg-white/80', 'dark:bg-gray-900/80', 'backdrop-blur-xl', 'shadow-lg', 'py-3');
                header.classList.remove('bg-transparent', 'py-6');
            } else {
                header.classList.remove('bg-white/80', 'dark:bg-gray-900/80', 'backdrop-blur-xl', 'shadow-lg',
                    'py-3');
                header.classList.add('bg-transparent', 'py-6');
            }

            // Track active section
            const sections = ['services', 'contact'];
            const current = sections.find(section => {
                const element = document.getElementById(section);
                if (element) {
                    const rect = element.getBoundingClientRect();
                    return rect.top <= 100 && rect.bottom >= 100;
                }
                return false;
            });

            activeSection = current || '';

            // Update nav links
            document.querySelectorAll('.nav-link').forEach(link => {
                const href = link.getAttribute('href').slice(1);
                const underline = link.querySelector('.nav-underline');
                if (activeSection === href) {
                    link.classList.add('text-indigo-600', 'dark:text-indigo-400');
                    underline.classList.add('scale-x-100');
                    underline.classList.remove('scale-x-0');
                } else {
                    link.classList.remove('text-indigo-600', 'dark:text-indigo-400');
                    underline.classList.remove('scale-x-100');
                    underline.classList.add('scale-x-0');
                }
            });
        });

        // Network background animation
        const canvas = document.getElementById('networkCanvas');
        const ctx = canvas.getContext('2d');
        let particles = [];
        let animationFrameId;

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.vx = (Math.random() - 0.5) * 0.5;
                this.vy = (Math.random() - 0.5) * 0.5;
                this.radius = Math.random() * 2 + 1;
            }

            update() {
                this.x += this.vx;
                this.y += this.vy;

                if (this.x < 0 || this.x > canvas.width) this.vx = -this.vx;
                if (this.y < 0 || this.y > canvas.height) this.vy = -this.vy;

                this.x = Math.max(0, Math.min(canvas.width, this.x));
                this.y = Math.max(0, Math.min(canvas.height, this.y));
            }

            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(99, 102, 241, 0.5)';
                ctx.fill();
            }
        }

        function initParticles() {
            particles = [];
            const particleCount = window.innerWidth < 768 ? 30 : 50;
            for (let i = 0; i < particleCount; i++) {
                particles.push(new Particle());
            }
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            particles.forEach(particle => {
                particle.update();
                particle.draw();
            });

            particles.forEach((particle, i) => {
                particles.slice(i + 1).forEach(otherParticle => {
                    const dx = particle.x - otherParticle.x;
                    const dy = particle.y - otherParticle.y;
                    const distance = Math.sqrt(dx * dx + dy * dy);

                    if (distance < 150) {
                        ctx.beginPath();
                        ctx.moveTo(particle.x, particle.y);
                        ctx.lineTo(otherParticle.x, otherParticle.y);
                        const opacity = (1 - distance / 150) * 0.2;
                        ctx.strokeStyle = `rgba(99, 102, 241, ${opacity})`;
                        ctx.lineWidth = 0.5;
                        ctx.stroke();
                    }
                });
            });

            animationFrameId = requestAnimationFrame(animate);
        }

        // Initialize
        window.addEventListener('DOMContentLoaded', () => {
            applyTheme();
            resizeCanvas();
            initParticles();
            animate();
        });

        window.addEventListener('resize', () => {
            resizeCanvas();
            initParticles();
        });
    </script>
</body>

</html>
