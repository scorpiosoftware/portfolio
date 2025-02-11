<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Portfolio SSO</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    @endif
</head>

<body class="font-sans antialiased d:bg-black d:text-white/50">
    <x-navbar/>
    <div class="bg-gray-50 text-black/50 d:bg-black d:text-white/50 ">
        {{-- <img id="background" class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg" alt="Laravel background" /> --}}
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
</body>

</html>
