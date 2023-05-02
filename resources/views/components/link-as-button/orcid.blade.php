<a href="{{ route('orcid.redirect') }}" {{ $attributes->merge(['class' => 'inline-flex items-center px-3 py-1 bg-white border border-main-teal hover:border-main-teal-hover rounded-md font-normal text-sm text-center uppercase text-main-dark tracking-widest hover:bg-white active:bg-white focus:outline-none focus:border-main-teal disabled:opacity-25 transition ease-in-out duration-150']) }}>
    <img src="{{ asset('images/orcid-icon.svg') }}" width="24" class="mr-2"> {{ __('ORCID') }}
</a>
