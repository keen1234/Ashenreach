<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Your Address — Ashenreach</title>
    <meta name="description" content="Verify the email address connected to your Ashenreach name.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
      .verify-lockup { display: grid; justify-items: start; gap: var(--sp-3); }
      .verify-lockup__roundel { width: 104px; height: auto; display: block; }
      .verify-lockup__word { font-family: var(--font-display); font-weight: 500; font-size: .9375rem; letter-spacing: .24em; text-transform: uppercase; color: var(--color-bone); }
      .verify-code { display: grid; gap: 10px; }
      .verify-code__label { color: var(--color-silver); font-size: .8125rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; }
      .verify-code__inputs { display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: 8px; }
      .verify-code__input { width: 100%; min-width: 0; min-height: 56px; border: 1px solid var(--color-iron); border-radius: 3px; background: var(--color-obsidian); color: var(--color-bone); font: 500 1.35rem var(--font-mono); text-align: center; }
      .verify-code__input:focus-visible { outline: 2px solid var(--color-gold); outline-offset: 2px; border-color: var(--color-gold); }
      .verify-code__input[aria-invalid="true"] { border-color: var(--color-blood); }
      .verify-code__hint { color: var(--color-silver); font-size: .8125rem; }
      .verify-resend { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; color: var(--color-silver); font-size: .8125rem; margin-top: 1.5rem; }
      .verify-resend button { min-height: 44px; padding: 8px 0; border: 0; background: transparent; color: var(--color-gold); font: inherit; cursor: pointer; text-decoration: underline; text-underline-offset: 3px; }
      .verify-resend button:disabled { color: var(--color-silver); cursor: not-allowed; text-decoration: none; }
      .verify-address { color: var(--color-gold); font-family: var(--font-mono); overflow-wrap: anywhere; }
      .verify-success { display: grid; gap: 14px; }
      .verify-success[hidden] { display: none; }
      .verify-success__mark { display: grid; place-items: center; width: 56px; height: 56px; border: 1px solid rgba(95, 160, 90, 0.5); border-radius: 50%; color: var(--color-moss); background: rgba(95, 160, 90, 0.1); }
      .verify-success__mark svg { width: 26px; height: 26px; }
      @media (max-width: 520px) { .verify-code__inputs { gap: 5px; } .verify-code__input { min-height: 50px; font-size: 1.1rem; } }
    </style>
</head>
<body class="auth-body">

<header class="auth-top" data-od-id="verification-topbar">
  <span class="text-sm font-semibold text-silver"><b>04</b> Verification</span>
  <span class="text-sm text-silver">Ashenreach — Keep the name</span>
</header>

<div class="auth-shell" data-od-id="verification-shell">
  <div class="auth-split">
    <section class="auth-brand" aria-labelledby="brand-headline" data-od-id="verification-brand">
      <div class="verify-lockup">
        <div class="w-20 h-20 bg-iron rounded-2xl border border-gold flex items-center justify-center">
            <img
                src="{{ Vite::asset('resources/assets/assets_ashen-roundel.png') }}"
                alt="Ashenreach roundel"
                class="w-16 h-16 rounded-full object-contain"
            />
        </div>
        <span class="verify-lockup__word">Ashenreach</span>
      </div>
      <div class="auth-brand__title">
        <span class="text-gold font-medium">Keep the name</span>
        <h1 class="auth-brand__headline" id="brand-headline">The realm<br><em>needs proof.</em></h1>
        <p class="text-silver max-w-sm">Your address is the thread that leads back to your deeds. Confirm it once, then the Marches will know you belong.</p>
      </div>
      <figure class="auth-quote" style="margin-top: 2rem;">
        <blockquote class="text-silver italic" style="border-left: 2px solid var(--color-gold); padding-left: 1rem;">“A name becomes yours when the realm can send word to it.”</blockquote>
        <figcaption class="text-xs text-silver mt-2" style="font-family: var(--font-mono);">The Registrar · Lowcourt</figcaption>
      </figure>
    </section>

    <main class="auth-form" id="auth-form" data-od-id="verification-form">
      <header class="mb-8">
        <span class="text-xs uppercase tracking-wider font-semibold text-gold">04 · Verify your address</span>
        <h2 class="text-2xl font-display font-semibold mt-1 mb-2">Enter the six marks</h2>
        <p class="text-silver text-sm">We sent a verification link to <span class="verify-address">{{ auth()->user()?->email ?? 'warden@lowcourt.example' }}</span>.</p>
      </header>

      @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-3 rounded-lg text-sm bg-stone/50 border border-moss/50 text-moss">
            A new verification link has been sent to the email address you provided during registration.
        </div>
      @endif

      <div class="auth-alert auth-alert--danger p-3 rounded-lg bg-blood/20 border border-blood text-bone mb-4 flex items-center gap-3" id="verify-alert" role="alert" hidden>
        <svg class="w-5 h-5 text-blood shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <div><strong>The marks do not match.</strong> <span class="text-sm">Check the message and try again.</span></div>
      </div>

      <form method="POST" action="{{ route('verification.send') }}" class="auth-fields" id="verify-form" novalidate data-od-id="verification-code-form">
        @csrf
        <div class="verify-code mb-6">
          <span class="verify-code__label" id="code-label">Verification code or action</span>
          <div class="verify-code__inputs mb-3" role="group" aria-labelledby="code-label">
            <input class="verify-code__input" data-code="0" inputmode="numeric" autocomplete="one-time-code" maxlength="1" aria-label="Digit 1">
            <input class="verify-code__input" data-code="1" inputmode="numeric" maxlength="1" aria-label="Digit 2">
            <input class="verify-code__input" data-code="2" inputmode="numeric" maxlength="1" aria-label="Digit 3">
            <input class="verify-code__input" data-code="3" inputmode="numeric" maxlength="1" aria-label="Digit 4">
            <input class="verify-code__input" data-code="4" inputmode="numeric" maxlength="1" aria-label="Digit 5">
            <input class="verify-code__input" data-code="5" inputmode="numeric" maxlength="1" aria-label="Digit 6">
          </div>
          <span class="verify-code__hint">You can also request a standard verification email below.</span>
        </div>
        <div class="auth-actions">
          <button class="auth-btn--primary" type="submit" data-od-id="verify-submit" style="display: flex; justify-content: center; align-items: center; gap: 8px;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Resend Verification Email
          </button>
        </div>
      </form>

      <div class="verify-success" id="verify-success" hidden>
        <span class="verify-success__mark"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></span>
        <h3 class="text-xl font-display font-semibold">The name is yours.</h3>
        <p class="text-silver text-sm">Your address is confirmed. The gates are open, and the Marches remember you.</p>
        <div class="auth-actions mt-4"><a class="auth-btn--primary block text-center py-3" href="{{ route('dashboard') }}">Enter Ashenreach</a></div>
      </div>

      <div class="mt-6 pt-6 border-t border-iron flex justify-between items-center text-sm text-silver">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-silver hover:text-gold transition">Log Out</button>
        </form>
        <a href="{{ route('register') }}" class="text-gold hover:underline">Take the name again</a>
      </div>
    </main>
  </div>
</div>

<footer class="auth-foot p-6 text-center text-xs text-silver">
    <span>Night 42 · The registrar is awake</span>
</footer>

</body>
</html>
