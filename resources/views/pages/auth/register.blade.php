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
                    <span class="text-gold font-medium">Begin your journey</span>
                    <h1 class="auth-brand__headline">Forge a<br><em>name in ash.</em></h1>
                    <p class="text-silver max-w-sm">The Marches require a champion. Provide your details to claim your title and step into the fray.</p>
                </div>
            </section>

            <!-- Form column -->
            <main class="auth-form">
                <header class="mb-8">
                    <h2 class="text-2xl font-display font-semibold mb-2">Create Character</h2>
                    <p class="text-silver text-sm">Every story begins with a choice. Set your identity and forge your path.</p>
                </header>

                <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
                    @csrf

                    <div class="flex flex-col gap-2">
                        <label class="text-xs uppercase tracking-wider font-semibold text-silver">Character Name</label>
                        <input name="name" value="{{ old('name') }}" type="text" required class="auth-input" placeholder="Sir Reginald" />
                        @error('name') <span class="text-xs text-blood">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xs uppercase tracking-wider font-semibold text-silver">Email Address</label>
                        <input name="email" value="{{ old('email') }}" type="email" required class="auth-input" placeholder="hero@ashenreach.test" />
                        @error('email') <span class="text-xs text-blood">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xs uppercase tracking-wider font-semibold text-silver">Password</label>
                        <input name="password" type="password" required class="auth-input" placeholder="••••••••" />
                        @error('password') <span class="text-xs text-blood">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xs uppercase tracking-wider font-semibold text-silver">Confirm Password</label>
                        <input name="password_confirmation" type="password" required class="auth-input" placeholder="••••••••" />
                        @error('password_confirmation') <span class="text-xs text-blood">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="auth-btn--primary">Forge Character</button>
                </form>

                <p class="mt-6 text-center text-silver text-sm">
                    Already a Warden? <a href="{{ route('login') }}" class="text-gold font-semibold ml-1">Log in</a>
                </p>
            </main>
        </div>
    </div>

</body>
</html>
