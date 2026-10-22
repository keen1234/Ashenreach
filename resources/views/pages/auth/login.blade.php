@php
    $title = __('Log in to Ashenreach');
@endphp

<x-layouts.auth :title="$title">
    <div class="flex flex-col gap-6">
        <!-- Game Branding Header -->
        <div class="flex flex-col items-center text-center gap-2">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-coal border border-iron text-gold shadow-lg">
                <flux:icon.fire class="size-7" />
            </div>
            <flux:heading size="xl" level="1" class="text-bone font-bold tracking-wider">ASHENREACH</flux:heading>
            <flux:subheading class="text-silver">Enter the realm, spend your bars, and claim your destiny.</flux:subheading>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <x-passkey-verify />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="peasant@ashenreach.test"
            />

            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Password')"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0 text-gold hover:underline" :href="route('password.request')" wire:navigate>
                        {{ __('Forgot password?') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('Remember me')" :checked="old('remember')" />

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full bg-gold text-obsidian font-semibold hover:bg-gold-light" data-test="login-button">
                    {{ __('Enter Kingdom') }}
                </flux:button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="space-x-1 text-center text-sm text-silver">
                <span>{{ __('New to the realm?') }}</span>
                <flux:link :href="route('register')" class="text-gold hover:underline font-medium" wire:navigate>
                    {{ __('Create character') }}
                </flux:link>
            </div>
        @endif
    </div>
</x-layouts.auth>
