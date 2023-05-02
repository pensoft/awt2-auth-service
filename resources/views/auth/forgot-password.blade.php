<x-guest-layout>
    <x-auth-card>
        <x-auth-h1 class="pb-8">{{ __('Forgot your password?') }}</x-auth-h1>

        <div class="mb-4 text-sm text-main-dark">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                @error('email')
                    <x-input-error id="email" class="block mt-1 w-full" type="email" name="email"
                                   :value="old('email')" required autofocus />
                    <div class="text-sm text-error mt-1 font-bold">{{ $message }}</div>
                @else
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                             required autofocus />
                @endif
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button.primary class="w-full">
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
