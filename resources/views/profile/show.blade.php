<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl shadow shadow-gray-600">
            <div class=" py-5 px-6 bg-white ">
                <h2 class="font-semibold text-2xl text-blue-6 leading-tight">
                    {{ __('Profile') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto pt-2 pb-20 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
