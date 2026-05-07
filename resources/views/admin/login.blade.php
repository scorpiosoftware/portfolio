<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Scorpio Software</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-slate-950 flex items-center justify-center p-4">

    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 mb-4 shadow-2xl shadow-indigo-500/30">
                <img src="{{ asset('imgs/scorpiosoft-logo-new.svg') }}" alt="" class="w-full rounded-2xl">
            </div>
            <h1 class="text-2xl font-bold text-white">Scorpio Software</h1>
            <p class="text-slate-400 text-sm mt-1">Admin Panel</p>
        </div>

        <div class="bg-slate-900 rounded-2xl shadow-2xl border border-slate-800 p-8">
            <h2 class="text-lg font-semibold text-white mb-6">Sign in to continue</h2>

            @if ($errors->any())
                <div class="mb-5 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full bg-slate-800 border border-slate-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/50 transition-all placeholder-slate-500"
                        placeholder="admin@scorpiosoft.tech">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1.5">Password</label>
                    <input type="password" name="password" required
                        class="w-full bg-slate-800 border border-slate-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/50 transition-all placeholder-slate-500"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" name="remember" id="remember" class="rounded border-slate-600 bg-slate-800 text-indigo-500">
                    <label for="remember" class="text-sm text-slate-400">Remember me</label>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white py-3 rounded-xl font-semibold shadow-lg shadow-indigo-500/20 transform transition-all duration-200 hover:scale-[1.02] mt-2">
                    Sign In
                </button>
            </form>
        </div>

        <p class="text-center text-slate-600 text-xs mt-6">Authorized access only</p>
    </div>

</body>
</html>
