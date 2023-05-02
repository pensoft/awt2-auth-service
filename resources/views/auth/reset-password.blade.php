<x-guest-layout>
    <x-auth-card>
        <x-auth-h1 class="pb-8">{{ __('Reset password') }}</x-auth-h1>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                @error('email')
                    <x-input-error id="email" class="block mt-1 w-full" type="email" name="email"
                                   :value="old('email', $request->email)" required autofocus />
                    <div class="text-sm text-error mt-1 font-bold">{{ $message }}</div>
                @else
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                             :value="old('email', $request->email)" required autofocus />
                @endif
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                @error('password')
                    <x-input-error id="password" class="block mt-1 w-full" type="password" name="password" required />
                    <div class="text-sm text-error mt-1 font-bold">{{ $message }}</div>
                @else
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
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

            <div class="flex items-center justify-end mt-4">
                <x-button.primary class="w-full">
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
