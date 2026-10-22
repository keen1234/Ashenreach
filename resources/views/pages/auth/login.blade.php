<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log in - Ashenreach</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#0E0E0E] text-[#E5E5E5] antialiased flex flex-col justify-center items-center p-6 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-neutral-900 via-[#0E0E0E] to-black">
    <div class="w-full max-w-md bg-[#171717] border border-[#262626] rounded-2xl p-8 shadow-2xl relative overflow-hidden">
        <!-- Subtle Gold Glow Accent -->
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-[#C9A24D] opacity-10 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Game Branding Header -->
        <div class="flex flex-col items-center text-center gap-3 mb-8 relative z-10">
            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#0E0E0E] border-2 border-[#C9A24D] text-[#C9A24D] shadow-xl">
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <h1 class="text-3xl font-extrabold tracking-widest text-[#E5E5E5] font-serif">ASHENREACH</h1>
            <p class="text-sm text-[#A3A3A3]">Enter the realm, spend your bars, and claim your destiny.</p>
        </div>

        @if (session('status'))
            <div class="mb-4 p-3 rounded-lg bg-emerald-950/50 border border-emerald-800 text-sm font-medium text-emerald-400 text-center relative z-10">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-5 relative z-10">
            @csrf

            <!-- Email Address -->
            <div class="flex flex-col gap-1.5">
                <label class="text-xs uppercase tracking-wider font-semibold text-[#A3A3A3]">Email Address</label>
                <input
                    name="email"
                    value="{{ old('email') }}"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="peasant@ashenreach.test"
                    class="w-full px-4 py-3 rounded-xl bg-[#0E0E0E] border border-[#262626] text-[#E5E5E5] placeholder-neutral-600 focus:outline-none focus:border-[#C9A24D] focus:ring-1 focus:ring-[#C9A24D] transition duration-200"
                />
                @error('email')
                    <span class="text-xs text-red-400 mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="flex flex-col gap-1.5">
                <div class="flex justify-between items-center">
                    <label class="text-xs uppercase tracking-wider font-semibold text-[#A3A3A3]">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-[#C9A24D] hover:underline font-medium">
                            Forgot password?
                        </a>
                    @endif
                </div>
                <input
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="w-full px-4 py-3 rounded-xl bg-[#0E0E0E] border border-[#262626] text-[#E5E5E5] placeholder-neutral-600 focus:outline-none focus:border-[#C9A24D] focus:ring-1 focus:ring-[#C9A24D] transition duration-200"
                />
                @error('password')
                    <span class="text-xs text-red-400 mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center gap-2.5 py-1">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded bg-[#0E0E0E] border-[#262626] text-[#C9A24D] focus:ring-0 cursor-pointer" />
                <label for="remember" class="text-sm text-[#A3A3A3] cursor-pointer">Remember me</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-[#C9A24D] to-[#DFBE72] text-[#0E0E0E] font-bold tracking-wider hover:opacity-90 transition duration-200 shadow-xl shadow-amber-950/35 uppercase text-sm">
                Enter Kingdom
            </button>
        </form>

        @if (Route::has('register'))
            <div class="mt-8 pt-6 border-t border-[#262626] text-center text-sm text-[#A3A3A3] relative z-10">
                New to the realm?
                <a href="{{ route('register') }}" class="text-[#C9A24D] hover:underline font-semibold ml-1">Create character</a>
            </div>
        @endif
    </div>
</body>
</html>
