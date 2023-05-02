@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-semibold text-lg text-error">
            {{ __('Whoops! Something went wrong.') }}
        </div>

        {{--
        <ul class="mt-3 list-disc list-inside text-sm text-error">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        --}}
    </div>
@endif
