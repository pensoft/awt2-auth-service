<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-main-teal border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:main-teal active:main-teal focus:outline-none disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
