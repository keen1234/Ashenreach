<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Character — Ashenreach</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="auth-body">

    <header class="auth-top">
        <span class="text-sm font-semibold text-silver"><b>01</b> Register</span>
        <span class="text-sm text-silver">Ashenreach — Create Your Character</span>
    </header>

    <div class="auth-shell">
        <div class="max-w-md w-full mx-auto">
            <div class="mb-8 text-center">
                <div class="w-16 h-16 bg-iron rounded-2xl border border-gold flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h1 class="text-2xl font-display font-semibold">Forge Your Destiny</h1>
                <p class="text-silver text-sm mt-1">Enter the realm, spend your bars, and claim your place.</p>
            </div>

            <div class="auth-form">
                @if (session('status'))
                    <div class="mb-4 p-3 rounded-lg text-sm bg-stone/50 border border-moss/50 text-moss">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-4">
                    @csrf

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs uppercase tracking-wider font-semibold text-silver">Character Name</label>
                        <input name="name" value="{{ old('name') }}" type="text" required autofocus class="auth-input" placeholder="Sir Reginald" />
                        @error('name') <span class="text-xs text-blood">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs uppercase tracking-wider font-semibold text-silver">Email Address</label>
                        <input name="email" value="{{ old('email') }}" type="email" required class="auth-input" placeholder="hero@ashenreach.test" />
                        @error('email') <span class="text-xs text-blood">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs uppercase tracking-wider font-semibold text-silver">Password</label>
                        <input name="password" type="password" required class="auth-input" placeholder="••••••••" />
                        @error('password') <span class="text-xs text-blood">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs uppercase tracking-wider font-semibold text-silver">Confirm Password</label>
                        <input name="password_confirmation" type="password" required class="auth-input" placeholder="••••••••" />
                        @error('password_confirmation') <span class="text-xs text-blood">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="auth-btn--primary mt-2">Forge Character</button>
                </form>

                <div class="mt-6 pt-4 border-t border-iron text-center text-sm text-silver">
                    Already have a character?
                    <a href="{{ route('login') }}" class="text-gold hover:underline font-semibold ml-1">Log in</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
