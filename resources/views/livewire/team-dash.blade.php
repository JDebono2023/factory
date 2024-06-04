<div class="p-6 lg:p-8 ">

    @if (Auth::user()->allTeams()->where('id', '!=', '2')->first())
        <x-button class="mb-4" wire:click="createShowModal">
            {{ __('Add New Team') }}
        </x-button>
    @else
    @endif


    {{-- The data table --}}
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full  lg:px-8">
                <div class="overflow-hidden sm:rounded shadow-md shadow-gray-500">
                    <table class="w-full 0">
                        <thead>
                            <tr
                                class="px-6  bg-gray-700 text-center text-[10px] lg:text-sm leading-4 font-black text-white uppercase tracking-wider">
                                <th class="px-6 text-left ">
                                    Team Name</th>

                                <th class="px-3 py-1 lg:py-3 text-center">
                                    View Team
                                </th>

                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-400">
                            @if ($teams->count())
                                @foreach (Auth::user()->ownedTeams as $team)
                                    {{-- @foreach ($teams as $item) --}}
                                    <tr
                                        class="lg:px-6 text-[12px] md:text-sm leading-4 font-medium text-gray-900 tracking-wider text-left">
                                        <td class="px-6 ">{{ $team->name }}</td>

                                        <td class="px-3 text-center">
                                            <button>
                                                <a href="{{ route('teams.show', $team->id) }}">
                                                    <span
                                                        class="material-symbols-outlined py-3 text-base lg:text-3xl  leading-4 font-medium text-blue-6 tracking-wider text-center  hover:text-gray-500 active:bg-gray-500 transition ease-in-out duration-150">
                                                        arrow_circle_right
                                                    </span>
                                                </a>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                            @endif
                            @if (Auth::user()->teams->where('id', '=', '2')->first() && $teams->count())
                                @foreach (Auth::user()->teams as $userTeam)
                                    <tr
                                        class="lg:px-6 text-[12px] md:text-sm leading-4 font-medium text-gray-900 tracking-wider text-left">
                                        <td class="px-6 ">{{ $userTeam->name }}</td>

                                        <td class="px-3 text-center">
                                            <button>
                                                <a href="{{ route('teams.show', 2) }}">
                                                    <span
                                                        class="material-symbols-outlined py-3 text-base lg:text-3xl  leading-4 font-medium text-blue-6 tracking-wider text-center  hover:text-gray-500 active:bg-gray-500 transition ease-in-out duration-150">
                                                        arrow_circle_right
                                                    </span>
                                                </a>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                            @endif
                            @if (!$teams->count())
                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap" colspan="4">No Results Found
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <br />
                @if ($links->links())
                    {{ $links->links() }}
                @endif
            </div>
        </div>
    </div>

    <x-dialogTeam-modal wire:model="modalFormVisible" class="py-0">
        <x-slot name="title">

            {{ __('Add New Store') }}

        </x-slot>

        <x-slot name="content">
            @livewire('teams.create-team-form')

        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="close" wire:loading.attr="disabled" class="mr-4">
                {{ __('Close') }}
            </x-secondary-button>

        </x-slot>
    </x-dialogTeam-modal>
</div>
