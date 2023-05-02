<x-guest-layout>
    <x-auth-card class="register-card">

        <x-auth-h1 class="pb-1">{{ __('Register') }}</x-auth-h1>

        <div class="flex items-center justify-start text-lg pb-6">
            {{ __('Already have an account?') }}
            <a class="ml-2 text-lg text-main-teal hover:text-main-teal-hover hover:underline" href="{{ route('login') }}">
                {{ __('Login') }}
            </a>
        </div>

        @if($provider ?? null)
            <div class="mb-2 text-xl text-main-dark">
                {{ __('Create PENSOFT record and link your account') }}
            </div>
            <div class="mb-4 text-sm text-main-dark">
                @if($email ?? null)
                    {{ __('You are signed into :provider as :email', ['provider' => $provider, 'email' => $email ]) }}
                @else
                    {{ __('You are signed into :provider', ['provider' => $provider ]) }}
                @endif
            </div>
            <div class="mb-4 text-sm text-main-dark">
                {{ __('To finish linking this account to PENSOFT, register your PENSOFT account below. You will only need to complete this step once. After that, you will be able to access your PENSOFT record with your :provider account.', ['provider' => $provider ]) }}
            </div>
        @endif

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                @error('passwonamerd')
                    <x-input-error id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $name)" required autofocus />
                    <div class="text-sm text-error mt-1 font-bold">{{ $message }}</div>
                @else
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $name)" required autofocus />
                @endif
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                @error('email')
                    <x-input-error id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email', $email)" required />
                    <div class="text-sm text-error mt-1 font-bold">{{ $message }}</div>
                @else
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $email)" required />
                @endif
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                @error('password')
                    <x-input-error id="password" class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required autocomplete="new-password" />
                    <div class="text-sm text-error mt-1 font-bold">{{ $message }}</div>
                @else
                    <x-input id="password" class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required autocomplete="new-password" />
                @endif
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                @error('password_confirmation')
                    <x-input-error id="password_confirmation" class="block mt-1 w-full"
                                            type="password" name="password_confirmation" required />
                    <div class="text-sm text-error mt-1 font-bold">{{ $message }}</div>
                @else
                    <x-input id="password_confirmation" class="block mt-1 w-full"
                                            type="password" name="password_confirmation" required />
                @endif
            </div>

            <x-button.primary class="w-full mt-8">
                {{ __('Next') }}
            </x-button>

             <x-crossed-title>{{ __('or Register with') }}</x-crossed-title>

            @if(empty($provider))
            <div class="flex items-center justify-center mt-4">
                <x-link-as-button.orcid></x-link-as-button>
            </div>
            @endif
        </form>
    </x-auth-card>
</x-guest-layout>
