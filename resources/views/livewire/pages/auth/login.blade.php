<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div>
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-theme-bg/50 backdrop-blur-sm border border-theme-border shadow-md overflow-hidden sm:rounded-lg">
            
            <h1 class="font-orbitron text-3xl font-bold text-center text-theme-text mb-2">
                Login to Antigravity
            </h1>
            <p class="text-center text-sm text-theme-text/70 mb-8">
                Welcome back, pioneer.
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form wire:submit="login">
                <!-- Email Address -->
                <div>
                    <label for="email" class="antigravity-label">{{ __('Email') }}</label>
                    <input wire:model="form.email" id="email" class="antigravity-input block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="antigravity-label">{{ __('Password') }}</label>
                    <input wire:model="form.password" id="password" class="antigravity-input block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember" class="inline-flex items-center">
                        <input wire:model="form.remember" id="remember" type="checkbox" class="rounded bg-theme-bg/80 border-theme-border text-theme-accent shadow-sm focus:ring-theme-accent" name="remember">
                        <span class="ms-2 text-sm text-theme-text/80">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-theme-text/70 hover:text-theme-accent rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" wire:navigate>
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <button type="submit" class="btn-primary ms-3">
                        {{ __('Log in') }}
                    </button>
                </div>

                <div class="text-center mt-6">
                     <a class="underline text-sm text-theme-text/70 hover:text-theme-accent" href="{{ route('register') }}" wire:navigate>
                        Don't have an account? Register
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>