<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl shadow shadow-gray-600">
            <div class=" py-5 px-6 bg-white ">
                <h2 class="font-semibold text-2xl text-blue-6 leading-tight">
                    {{ __('Team Settings') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto pt-2 pb-20 sm:px-6 lg:px-8 ">
            @livewire('teams.update-team-name-form', ['team' => $team])

            @livewire('teams.team-member-manager', ['team' => $team])

            @if (Auth::user()->allTeams()->where('id', '!=', '2')->first())
                @if (Gate::check('delete', $team) && !$team->personal_team)
                    <x-section-border />

                    <div class="mt-10 sm:mt-0 ">
                        @livewire('teams.delete-team-form', ['team' => $team])
                    </div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>
