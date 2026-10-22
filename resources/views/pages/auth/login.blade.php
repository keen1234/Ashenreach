<x-layouts::auth :title="__('Log in to your account')">
    <div class="flex flex-col gap-6">
        <div class="flex w-full flex-col text-center">
            <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-full border-2 border-gold bg-coal mx-auto">
                <flux:icon name="flame" class="size-10 text-blood" />
            </div>
            <flux:heading size="xl" level="1">{{ __('Ashenreach') }}</flux:heading>
            <flux:subheading>{{ __('Log in to your account') }}</flux:subheading>
        </div>

        <p class="text-sm text-silver text-center -mt-4">
            {{ __('Enter your email and password below to log in to the kingdom.') }}
        </p>

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
                placeholder="email@example.com"
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
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('Remember me')" :checked="old('remember')" />

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                    {{ __('Log in') }}
                </flux:button>
            </div>
        </form>

        <div class="text-center">
            <flux:link :href="route('register')" wire:navigate>
                {{ __('Don\'t have an account?') }}
            </flux:link>
        </div>
    </div>
</x-layouts::auth>
