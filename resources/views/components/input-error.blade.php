@props(['disabled' => false, 'error'])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-error focus:outline-none focus:ring focus:ring-rose-200 focus:border-rose-500 focus:ring-opacity-50']) !!}>
