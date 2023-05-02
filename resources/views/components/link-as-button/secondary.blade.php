<a {{ $attributes->merge(['class' => 'block px-4 py-2 bg-white border border-main-teal rounded-md font-normal text-base text-center text-main-teal tracking-widest hover:bg-white active:bg-white focus:outline-none focus:border-main-teal disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
