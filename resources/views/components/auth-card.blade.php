<div class="min-h-screen">
    <div class="auth-header">
        <img src="{{ asset('images/logo-white.svg') }}" alt="{{ __('Pensoft') }}">
    </div>

    <div class="main-content pt-6 lg:pt-0">
        <div class="flex flex-row justify-end">
          <div class="auth-card">
            <div class="w-full bg-white shadow-md overflow-hidden rounded-lg auth-card-content">
                {{ $slot }}
            </div>
          </div>
        </div>
    </div>
</div>
