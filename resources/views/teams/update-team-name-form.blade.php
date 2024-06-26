<x-form-section submit="updateTeamName">
    <x-slot name="title" class="text-blue-6">
        {{ __('Team Name') }}
    </x-slot>

    <x-slot name="description">
        {{-- {{ __('The team\'s name and owner information.') }} --}}
    </x-slot>

    <x-slot name="form">
        <!-- Team Owner Information -->
        @if (Auth::user()->allTeams()->where('id', '!=', '2')->first())
            <div class="col-span-6">
                <x-label value="{{ __('Team Owner') }}" />

                <div class="flex items-center mt-2">
                    <img class="w-12 h-12 rounded-full object-cover" src="{{ $team->owner->profile_photo_url }}"
                        alt="{{ $team->owner->name }}">

                    <div class="ml-4 leading-tight">
                        <div class="text-gray-900">{{ $team->owner->name }}</div>
                        <div class="text-gray-700 text-sm">{{ $team->owner->email }}</div>
                    </div>
                </div>
            </div>
            <!-- Team Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Team Name') }}" />

                <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name"
                    :disabled="!Gate::check('update', $team)" />

                <x-input-error for="name" class="mt-2" />
            </div>
        @else
            <!-- Team Name -->
            <div class="col-span-6 sm:col-span-4">
                <div class="block w-full text-xl">
                    {{ $team->name }}
                </div>

            </div>
        @endif

    </x-slot>

    @if (Gate::check('update', $team))
        <x-slot name="actions">
            <x-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <x-button>
                {{ __('Save') }}
            </x-button>
        </x-slot>
    @endif
</x-form-section>
