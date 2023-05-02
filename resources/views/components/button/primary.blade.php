<button {{ $attributes->merge(['type' => 'submit', 'class' => 'block px-4 py-2 bg-main-teal border border-main-teal rounded-md font-normal text-base text-center text-white tracking-widest hover:main-teal active:main-teal focus:outline-none disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
