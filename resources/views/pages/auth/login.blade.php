<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log in - Ashenreach</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-obsidian text-bone antialiased flex flex-col justify-center items-center p-6" style="background-color: #0E0E0E; color: #E5E5E5;">
    <div class="w-full max-w-md bg-coal border border-iron rounded-2xl p-8 shadow-2xl relative overflow-hidden" style="background-color: #171717; border: 1px solid #262626;">
        <!-- Subtle Gold Glow Accent -->
        <div class="absolute -top-24 -right-24 w-48 h-48 opacity-10 rounded-full pointer-events-none" style="background-color: #C9A24D; position: absolute; top: -6rem; right: -6rem; width: 12rem; height: 12rem; filter: blur(4rem);"></div>

        <!-- Game Branding Header -->
        <div class="flex flex-col items-center text-center gap-3 mb-8 relative z-10">
            <div class="flex h-16 w-16 items-center justify-center rounded-2xl border-2 text-gold shadow-xl" style="background-color: #0E0E0E; border: 2px solid #C9A24D; color: #C9A24D; width: 4rem; height: 4rem;">
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 2.25rem; height: 2.25rem;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold tracking-widest text-bone font-serif" style="font-size: 1.875rem; font-weight: 800; color: #E5E5E5;">ASHENREACH</h1>
            <p class="text-sm text-silver" style="color: #A3A3A3;">Enter the realm, spend your bars, and claim your destiny.</p>
        </div>

        @if (session('status'))
            <div class="mb-4 p-3 rounded-lg text-sm font-medium text-center" style="background-color: rgba(16, 40, 30, 0.6); border: 1px solid rgba(34, 90, 60, 0.5); color: #4ade80;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-5 relative z-10">
            @csrf

            <!-- Email Address -->
            <div class="flex flex-col gap-1.5">
                <label class="text-xs uppercase tracking-wider font-semibold text-silver" style="font-size: 0.75rem; color: #A3A3A3;">Email Address</label>
                <input
                    name="email"
                    value="{{ old('email') }}"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="peasant@ashenreach.test"
                    class="w-full px-4 py-3 rounded-xl text-bone focus:outline-none focus:border-gold"
                    style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; background-color: #0E0E0E; border: 1px solid #262626; color: #E5E5E5;"
                />
                @error('email')
                    <span class="text-xs text-red-400 mt-1" style="color: #f87171;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="flex flex-col gap-1.5">
                <div class="flex justify-between items-center">
                    <label class="text-xs uppercase tracking-wider font-semibold text-silver" style="font-size: 0.75rem; color: #A3A3A3;">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-gold hover:underline font-medium" style="color: #C9A24D;">
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
                    class="w-full px-4 py-3 rounded-xl text-bone focus:outline-none focus:border-gold"
                    style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; background-color: #0E0E0E; border: 1px solid #262626; color: #E5E5E5;"
                />
                @error('password')
                    <span class="text-xs text-red-400 mt-1" style="color: #f87171;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center gap-2.5 py-1">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded bg-obsidian border-iron" style="width: 1rem; height: 1rem; accent-color: #C9A24D;" />
                <label for="remember" class="text-sm text-silver cursor-pointer" style="color: #A3A3A3;">Remember me</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3.5 rounded-xl text-obsidian font-bold tracking-wider hover:opacity-90 transition duration-200 shadow-xl uppercase text-sm" style="width: 100%; padding: 0.875rem; border-radius: 0.75rem; background: linear-gradient(to right, #C9A24D, #DFBE72); color: #0E0E0E; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; box-shadow: 0 10px 15px -3px rgba(23, 23, 23, 0.4);">
                Enter Kingdom
            </button>
        </form>

        @if (Route::has('register'))
            <div class="mt-8 pt-6 border-t border-iron text-center text-sm text-silver relative z-10" style="border-top: 1px solid #262626; color: #A3A3A3;">
                New to the realm?
                <a href="{{ route('register') }}" class="text-gold hover:underline font-semibold ml-1" style="color: #C9A24D; font-weight: 600;">Create character</a>
            </div>
        @endif
    </div>
</body>
</html>
