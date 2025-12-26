<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div>
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-theme-bg/50 backdrop-blur-sm border border-theme-border shadow-md overflow-hidden sm:rounded-lg">
            
            <h1 class="font-orbitron text-3xl font-bold text-center text-theme-text mb-2">
                Create Your Account
            </h1>
            <p class="text-center text-sm text-theme-text/70 mb-8">
                Join the future.
            </p>

            <form wire:submit="register">
                <!-- Name -->
                <div>
                    <label for="name" class="antigravity-label">{{ __('Name') }}</label>
                    <input wire:model="name" id="name" class="antigravity-input block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" class="antigravity-label">{{ __('Email') }}</label>
                    <input wire:model="email" id="email" class="antigravity-input block mt-1 w-full" type="email" name="email" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="antigravity-label">{{ __('Password') }}</label>
                    <input wire:model="password" id="password" class="antigravity-input block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="antigravity-label">{{ __('Confirm Password') }}</label>
                    <input wire:model="password_confirmation" id="password_confirmation" class="antigravity-input block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a class="underline text-sm text-theme-text/70 hover:text-theme-accent rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                        {{ __('Already registered?') }}
                    </a>

                    <button type="submit" class="btn-primary ms-4">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>