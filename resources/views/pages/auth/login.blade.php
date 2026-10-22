<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log in - Ashenreach</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#0E0E0E] text-[#E5E5E5] antialiased flex flex-col justify-center items-center p-6">
    <div class="w-full max-w-md bg-[#171717] border border-[#262626] rounded-2xl p-8 shadow-2xl">
        <!-- Game Branding Header -->
        <div class="flex flex-col items-center text-center gap-3 mb-8">
            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-[#0E0E0E] border border-[#262626] text-[#C9A24D] shadow-lg">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <h1 class="text-2xl font-bold tracking-widest text-[#E5E5E5]">ASHENREACH</h1>
            <p class="text-sm text-[#A3A3A3]">Enter the realm, spend your bars, and claim your destiny.</p>
        </div>

        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-400 text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-5">
            @csrf

            <!-- Email Address -->
            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-[#A3A3A3]">Email address</label>
                <input
                    name="email"
                    value="{{ old('email') }}"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="peasant@ashenreach.test"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#0E0E0E] border border-[#262626] text-[#E5E5E5] focus:outline-none focus:border-[#C9A24D]"
                />
                @error('email')
                    <span class="text-xs text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="flex flex-col gap-1.5">
                <div class="flex justify-between items-center">
                    <label class="text-sm font-medium text-[#A3A3A3]">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-[#C9A24D] hover:underline">
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
                    class="w-full px-4 py-2.5 rounded-lg bg-[#0E0E0E] border border-[#262626] text-[#E5E5E5] focus:outline-none focus:border-[#C9A24D]"
                />
                @error('password')
                    <span class="text-xs text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember" class="rounded bg-[#0E0E0E] border-[#262626] text-[#C9A24D] focus:ring-0" />
                <label for="remember" class="text-sm text-[#A3A3A3]">Remember me</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3 rounded-lg bg-[#C9A24D] text-[#0E0E0E] font-bold tracking-wide hover:bg-[#DFBE72] transition duration-200 shadow-lg">
                ENTER KINGDOM
            </button>
        </form>

        @if (Route::has('register'))
            <div class="mt-6 text-center text-sm text-[#A3A3A3]">
                New to the realm?
                <a href="{{ route('register') }}" class="text-[#C9A24D] hover:underline font-medium">Create character</a>
            </div>
        @endif
    </div>
</body>
</html>
