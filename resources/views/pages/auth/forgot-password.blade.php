<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recover Your Name — Ashenreach</title>
    <meta name="description" content="Lost your word in the Marches? Recover access to your Ashenreach account with a herald's message." />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="auth-body">

    <header class="auth-top justify-between">
        <span class="text-sm font-semibold text-silver"><b>03</b> Recovery</span>
        <span class="text-sm text-silver">Ashenreach <span class="text-gold mx-2">—</span> Send a herald</span>
    </header>

    <div class="auth-shell">
        <div class="auth-split">
            <section class="auth-brand" aria-labelledby="brand-headline">
                <div class="flex flex-col gap-3">
                    <img
                        src="{{ Vite::asset('resources/assets/assets_ashen-roundel.png') }}"
                        alt=""
                        width="756"
                        height="756"
                        class="w-[104px] h-auto block"
                    />
                    <span class="font-display text-sm tracking-[0.24em] uppercase text-silver">Ashenreach</span>
                </div>

                <div class="flex flex-col gap-4">
                    <span class="text-gold font-medium">Recover a name</span>
                    <h1 class="auth-brand__headline" id="brand-headline">The Marches<br><em>keep records.</em></h1>
                    <p class="text-silver max-w-sm">Your deeds, your debts, your rolls — all of it survives you. A herald can fetch a new word for any name the Marches remember.</p>
                </div>

                <figure class="border-l border-gold pl-4 max-w-sm">
                    <blockquote class="text-silver italic">“Bring the address you gave us, and we will find the rest. The realm keeps nothing else.”</blockquote>
                    <figcaption class="text-xs uppercase tracking-wider text-gold mt-3">The Registrar · Lowcourt</figcaption>
                </figure>
            </section>

            <main class="auth-form" id="auth-form">
                <header class="mb-8">
                    <span class="text-xs uppercase tracking-wider text-gold">03 · Recovery</span>
                    <h2 class="text-2xl font-display font-semibold mt-2 mb-2">Send a herald</h2>
                    <p class="text-silver text-sm">Give the address the guild wrote to. A new word arrives within the hour, and every device you used keeps its deeds.</p>
                </header>

                @if (session('status'))
                    <div class="mb-4 p-3 rounded-lg text-sm bg-stone/50 border border-moss/50 text-moss">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
                    @csrf

                    <div class="flex flex-col gap-2">
                        <label for="email" class="text-xs uppercase tracking-wider font-semibold text-silver">Herald's address</label>
                        <input
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            type="email"
                            required
                            autofocus
                            autocomplete="email"
                            class="auth-input"
                            placeholder="warden@lowcourt.example"
                        />
                        <span class="text-xs text-silver">The address you used when you took the name.</span>
                        @error('email') <span class="text-xs text-blood">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="auth-btn--primary">Send the herald</button>
                </form>

                <p class="mt-6 text-center text-silver text-sm">
                    Remembered after all? <a href="{{ route('login') }}" class="text-gold font-semibold ml-1">Return to the Ashes</a>
                </p>
            </main>
        </div>
    </div>

</body>
</html>
