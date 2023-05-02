<a {{ $attributes->merge(['class' => 'block px-4 py-2 bg-main-teal border border-transparent rounded-md font-normal text-base text-center text-white tracking-widest hover:bg-main-teal active:bg-main-teal focus:outline-none focus:border-main-teal disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
