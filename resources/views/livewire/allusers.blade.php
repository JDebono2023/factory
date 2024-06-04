<div>

    <div class="p-6 lg:p-8 ">

        {{-- The data table --}}
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class=" overflow-hidden sm:rounded shadow-md shadow-gray-500">
                        <table class=" w-full 0">
                            <thead>
                                <tr
                                    class="px-6 py-3 bg-gray-700 text-center text-[12px] lg:text-sm leading-4 font-black text-white uppercase tracking-wider">
                                    <th class=" px-2 md:px-6 text-left">
                                        Name</th>
                                    <th class="px-2 md:px-6 text-left">
                                        Email</th>
                                    {{-- <th class="px-6 text-left">
                                    Assigned Role(s)</th> --}}
                                    <th class="px-2 md:px-6 text-left">
                                        team</th>
                                    <th class="px-2 md:px-6 text-center">
                                        View Team
                                    </th>
                                    <th class="px-2 md:px-6 py-3 text-center">
                                        Delete User
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-400">
                                @if ($allUsers->count())

                                    @foreach ($allUsers as $item)
                                        <tr
                                            class="px-6 text-[10px] lg:text-sm leading-4 font-medium text-gray-900 tracking-wider text-left">

                                            <td class="px-2 md:px-6 py-2">{{ $item->name }}</td>
                                            <td class="px-2 md:px-6 py-2">{{ $item->email }}</td>


                                            @if ($item->teams->where('id', '=', '2')->first())
                                                <td class="px-2 md:px-6 text-left py-1 ">
                                                    @foreach ($item->allTeams() as $team)
                                                        {{ $team->name }}<br>
                                                    @endforeach
                                                </td>
                                            @else
                                                <td class="px-2 md:px-6 text-left ">
                                                    Pending User Acceptance</td>
                                            @endif


                                            <td class="px-2 md:px-6  text-center">
                                                <div class="">
                                                    @foreach ($item->allTeams() as $team)
                                                        <button>
                                                            <a href="{{ route('teams.show', $team->id) }}">
                                                                <span
                                                                    class="material-symbols-outlined py-1 text-base lg:text-3xl  leading-4 font-medium text-blue-6 tracking-wider text-center  hover:text-gray-500 active:bg-gray-500 transition ease-in-out duration-150">
                                                                    arrow_circle_right
                                                                </span>
                                                            </a>
                                                        </button><br>
                                                    @endforeach
                                                </div>
                                            </td>

                                            <td class="px-2 md:px-6 text-center">
                                                <button
                                                    class="material-symbols-outlined  py-3 text-2xl  leading-4 font-medium text-blue-9 tracking-wider text-center  hover:text-blue-2 active:bg-blue-3 transition ease-in-out duration-150"
                                                    wire:click="deleteUserModal({{ $item->id }})">
                                                    delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
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



        {{-- The Delete Modal --}}
        <x-dialog-modal wire:model="modalDeleteVisible">
            <x-slot name="title">

                {{ __('Delete User: ') }}{{ $name }}

            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to permenantly delete this user? Deleting this user will remove the user from the database and any assigned teams.') }}
                {{ __('To remove a user from a team, please access the specific team settings, and remove the user. ') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('modalDeleteVisible')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                    {{ __('Delete user') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </div>
</div>
