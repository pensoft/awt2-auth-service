<x-guest-layout>
    <x-auth-card class="login-card">

        <x-auth-h1 class="pb-8">{{ __('Login') }}</x-auth-h1>

        @if($provider ?? null)
            <div class="mb-2 text-xl text-gray-900">
                {{ __('Link your account to your PENSOFT record') }}
            </div>
            <div class="mb-4 text-sm text-gray-600">
                @if($email ?? null)
                    {{ __('You are signed into :provider as :email', ['provider' => $provider, 'email' => $email ]) }}
                @else
                    {{ __('You are signed into :provider', ['provider' => $provider ]) }}
                @endif
            </div>
            <div class="mb-4 text-sm text-gray-600">
                {{ __('To finish linking this account to PENSOFT, sign into your PENSOFT account below. You will only need to complete this step once. After your account is linked, you will be able to access your PENSOFT record with your :provider account.', ['provider' => $provider ]) }}
            </div>
        @endif
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')"/>

                 @error('email')
                     <x-input-error id="email" class="block mt-1 w-full"
                              type="email" name="email" :value="old('email')" required autofocus/>
                     <div class="text-sm text-error mt-1 font-bold">{{ $message }}</div>
                 @else
                    <x-input id="email" class="block mt-1 w-full @error('email') is-invalid @enderror"
                             type="email" name="email" :value="old('email')" required autofocus/>
                 @endif
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')"/>

                @error('password')
                    <x-input-error id="password" class="block mt-1 w-full"
                         type="password"
                         name="password"
                         required autocomplete="current-password"/>
                    <div class="text-sm text-error mt-1 font-bold">{{ $message }}</div>
                @else
                    <x-input id="password" class="block mt-1 w-full"
                         type="password"
                         name="password"
                         required autocomplete="current-password"/>
                @endif
            </div>

            <!-- Remember Me -->
            <div class="flex flex-wrap justify-between">
                <label for="remember_me" class="inline-flex items-center mt-3">
                    <input id="remember_me" type="checkbox"
                           class="rounded border-main-gray text-main-dark shadow-sm focus:border-main-gray focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           name="remember">
                    <span class="ml-2 text-sm text-main-dark">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-main-teal hover:text-main-teal-hover hover:underline mt-3"
                       href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <x-button.primary class="w-full mt-6">
                @if($provider ?? null)
                    {{ __('Login & link') }}
                @else
                    {{ __('Login') }}
                @endif
            </x-button>

            <p class="my-4 text-main-dark text-sm text-center font-bold">{{ __('or') }}</p>

            @if (Route::has('register'))
                 <x-link-as-button.secondary :href="route('register')" class="w-full mt-4">{{ __('Register') }}</x-button>
            @endif

        </form>

        <x-crossed-title>{{ __('or Login with') }}</x-crossed-title>

        @if(empty($provider))
            <div class="flex items-center justify-center mt-4">
                <x-link-as-button.orcid></x-link-as-button>
            </div>
        @endif
    </x-auth-card>
</x-guest-layout>
