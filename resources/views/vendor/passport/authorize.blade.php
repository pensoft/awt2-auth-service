<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500"/>
            </a>
        </x-slot>
        <div class="card card-default">
            <h3 class="text-xl font-semibold text-gray-900 text-center">
                Authorization Request
            </h3>
            <div class="card-body mt-4">
                <!-- Introduction -->
                <div class="text-sm text-gray-900 text-center"><strong>{{ $client->name }}</strong> is requesting permission to access your account.</div>

                <!-- Scope List -->
                @if (count($scopes) > 0)
                    <div class="scopes">
                        <p><strong>This application will be able to:</strong></p>

                        <ul>
                            @foreach ($scopes as $scope)
                                <li>{{ $scope->description }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex items-center justify-end mt-4">
                    <!-- Cancel Button -->
                    <form method="post" action="{{ route('passport.authorizations.deny') }}">
                        @csrf
                        @method('DELETE')

                        <input type="hidden" name="state" value="{{ $request->state }}">
                        <input type="hidden" name="client_id" value="{{ $client->id }}">
                        <input type="hidden" name="auth_token" value="{{ $authToken }}">
                        <button class="underline text-sm text-gray-600 hover:text-gray-900">Cancel</button>
                    </form>
                    <!-- Authorize Button -->
                    <form method="post" action="{{ route('passport.authorizations.approve') }}" class="ml-4">
                        @csrf

                        <input type="hidden" name="state" value="{{ $request->state }}">
                        <input type="hidden" name="client_id" value="{{ $client->id }}">
                        <input type="hidden" name="auth_token" value="{{ $authToken }}">
                        <x-button class="ml-3">Authorize</x-button>
                    </form>


                </div>
            </div>
        </div>
    </x-auth-card>
</x-guest-layout>
