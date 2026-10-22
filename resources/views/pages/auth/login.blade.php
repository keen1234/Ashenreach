<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Return to the Ashes — Ashenreach</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="auth-body">

    <div class="auth-shell">
        <div class="auth-split">
            <!-- Brand column -->
            <section class="auth-brand">
                <div class="flex flex-col gap-3">
                    <div class="w-20 h-20 bg-iron rounded-2xl border border-gold flex items-center justify-center">
                        <img
                            src="{{ Vite::asset('resources/assets/assets_ashen-roundel.png') }}"
                            alt="Ashenreach roundel"
                            class="w-16 h-16 rounded-full object-contain"
                        />
                    </div>
                    <span class="font-display text-sm tracking-[0.24em] uppercase text-silver">Ashenreach</span>
                </div>

                <div class="flex flex-col gap-4">
                    <span class="text-gold font-medium">Return to the Ashes</span>
                    <h1 class="auth-brand__headline">Rise from<br><em>a nobody.</em></h1>
                    <p class="text-silver max-w-sm">The gate is shut, the watchfires are low, and the Marches keep no records of the dead. Sign in and the realm remembers what you were.</p>
                </div>
            </section>

            <!-- Form column -->
            <main class="auth-form" id="auth-form">
                <header class="mb-8">
                    <h2 class="text-2xl font-display font-semibold mb-2">Enter the realm</h2>
                    <p class="text-silver text-sm">Two minutes is enough to spend an action, read the board, and roll the die. The rest keeps while you are away.</p>
                </header>

                @if (session('status'))
                    <div class="mb-4 p-3 rounded-lg text-sm bg-stone/50 border border-moss/50 text-moss">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
                    @csrf

                    <div class="flex flex-col gap-2">
                        <label class="text-xs uppercase tracking-wider font-semibold text-silver">Warden name</label>
                        <input name="email" value="{{ old('email') }}" type="email" required class="auth-input" placeholder="Warden of Ash" />
                        @error('email') <span class="text-xs text-blood">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xs uppercase tracking-wider font-semibold text-silver">Password</label>
                        <input name="password" type="password" required class="auth-input" placeholder="Your word" />
                        @error('password') <span class="text-xs text-blood">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-silver cursor-pointer">
                            <input type="checkbox" name="remember" class="accent-gold" />
                            Keep me signed in
                        </label>
                        <a href="{{ route('password.request') }}" class="text-xs text-gold hover:underline">Forgot password?</a>
                    </div>

                    <button type="submit" class="auth-btn--primary">Return to the Ashes</button>
                </form>

                <p class="mt-6 text-center text-silver text-sm">
                    No one remembers you yet. <a href="{{ route('register') }}" class="text-gold font-semibold ml-1">Take a new name</a>
                </p>
            </main>
        </div>
    </div>

</body>
</html>
