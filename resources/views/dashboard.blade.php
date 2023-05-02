<x-app-layout>
    {{--
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-main-dark leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>

        </div>
    </div>

    {{--
    @if (count($providers) > 0)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <ul class="mt-3 list-disc list-inside text-sm">
                    @foreach ($providers as $provider)
                        <li>{{ $provider['name'] }} => {{ $provider['id'] }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    --}}
</x-app-layout>
