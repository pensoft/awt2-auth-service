@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-md text-main-dark']) }}>
    {{ $value ?? $slot }}
</label>
