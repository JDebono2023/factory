<div>

    <div class="mt-5 shadow shadow-gray-600">
        <div class="px-6 py-4 bg-white border-gray-400 border-b-2  ">

            <h1 class="text-lg lg:text-xl xl:text-2xl font-bold text-blue-6 text-left">
                Schedule Media
            </h1>

            <p class=" text-gray-900 leading-relaxed text-left text-sm xl:text-base">
                Select a media item, and add it to your playlist.
            </p>
        </div>

        <div class="p-2 lg:p-4 shadow shadow-gray-400 border border-gray-200  bg-gray-200 grid grid-cols-10 ">
            <div class="col-span-2">
                <x-button class="mb-4 mr-2 text-xs" wire:click="createSchedule">
                    {{ __('Schedule An Item') }}
                </x-button>
            </div>

            {{-- data table --}}
            <div class="flex flex-col col-span-8 ">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="overflow-hidden sm:rounded shadow-md shadow-gray-500 mb-4">
                            <table class="w-full 0">
                                <thead>
                                    <tr
                                        class="px-6 py-3 bg-gray-700 text-center text-[10px] lg:text-xs leading-4 font-black text-white uppercase tracking-wider">
                                        <th class="px-2 py-2 xl:px-4  text-left">
                                            Media Name</th>
                                        <th class="lg:px-2 text-left">
                                            Start Date</th>
                                        <th class="lg:px-2 text-left">
                                            End Date</th>
                                        <th class="lg:px-2 text-left">
                                            Start Time</th>
                                        <th class="lg:px-2 text-left">
                                            End Time</th>
                                        <th class="px-2 text-center">
                                            Status</th>
                                        <th class="px-2 lg:px-6 ">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-400">
                                    @if ($content->count())
                                        @foreach ($content as $item)
                                            <tr
                                                class="text-[10px] md:text-xs xl:text-sm leading-4 font-medium text-gray-900 tracking-wider text-left">
                                                <td class=" px-2 xl:px-4 text-left">
                                                    {{ $item->media->client_name }}
                                                </td>

                                                <td class="text-left lg:px-2 ">
                                                    {{ \Carbon\Carbon::parse($item->start_time)->format('M d Y') }}
                                                </td>
                                                <td class="text-left lg:px-2">
                                                    {{ \Carbon\Carbon::parse($item->end_time)->format('M d Y') }}
                                                </td>
                                                <td class="lg:px-2">
                                                    {{ \Carbon\Carbon::parse($item->start_time)->format('h:i a') }}
                                                </td>
                                                <td class="lg:px-2">
                                                    {{ \Carbon\Carbon::parse($item->end_time)->format('h:i a') }}
                                                </td>

                                                <td class="px-2 lg:px-6 text-center">
                                                    @if ($item->visible == 1)
                                                        <span
                                                            class="material-symbols-outlined py-3 text-base lg:text-xl  leading-4 font-medium text-green-600 tracking-wider text-center  ">
                                                            <span class="material-symbols-rounded">
                                                                radio_button_checked
                                                            </span>
                                                        </span>
                                                    @else
                                                        <span
                                                            class="material-symbols-outlined py-3 text-base lg:text-xl  leading-4 font-medium text-red-600 tracking-wider text-center  ">
                                                            <span class="material-symbols-rounded">
                                                                radio_button_checked
                                                            </span>
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-2 lg:px-6 text-center ">

                                                    <button
                                                        class="material-symbols-outlined py-3 text-base lg:text-xl  leading-4 font-medium text-gray-900 tracking-wider text-center  hover:text-gray-500 active:bg-gray-500 transition ease-in-out duration-150"
                                                        wire:click="updateSchedule({{ $item->id }})">
                                                        edit
                                                    </button>
                                                    <button
                                                        class="material-symbols-outlined py-3 text-base lg:text-xl  leading-4 font-medium text-gray-900 tracking-wider text-center  hover:text-gray-500 active:bg-gray-500 transition ease-in-out duration-150"
                                                        wire:click="deleteSchedule({{ $item->id }})">
                                                        delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="px-6 py-4 text-sm whitespace-no-wrap" colspan="7">No items
                                                scheduled.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if ($links->links())
                            {{ $links->links() }}
                        @endif



                    </div>
                </div>
            </div>

            {{-- add-edit modal --}}
            <x-dialog-modal wire:model="modalSchedule" class="text-gray-900">
                <x-slot name="title">
                    @if ($modelId)
                        {{ __('Update Schedule: ') }}{{ $media_name }}
                    @else
                        {{ __('Schedule Media') }}
                    @endif
                </x-slot>

                <x-slot name="content">
                    <div class="hidden sm:block mt-4">
                        <div class="py-2">
                            <div class="border-t border-gray-400"></div>
                        </div>

                    </div>
                    <div class="mx-4 mb-4 mt-4 text-gray-900">
                        <div class=" mt-4">
                            <x-label for="media_id" class="text-lg text-gray-900" value="{{ __('Media Name') }}" />
                            <select id="media_id" name="media_id"
                                class="rounded-md font-medium w-full sm:w-2/3 text-sm h-8 border border-gray-600 shadow-sm shadow-gray-400 bg-white -mr-1 py-1 px-1  text-gray-900"
                                wire:model.lazy='media_id'>

                                @if (!$media_id)
                                    <option class="">Select an item...</option>
                                    @foreach ($mediaOptions as $content)
                                        <option value="{{ $content->id }}" class="">
                                            {{ $content->client_name }}
                                        </option>
                                    @endforeach
                                @else
                                    @foreach ($mediaOptions as $content)
                                        <option value="{{ $content->id }}"
                                            {{ $content->id == $media_id ? 'selected="selected"' : '' }}
                                            class="">
                                            {{ $content->client_name }}
                                        </option>
                                    @endforeach
                                @endif

                            </select>

                            @if (!$media_id && $selectedClientName)
                                <div class="mt-3 font-medium text-sm text-gray-900">Selected Media:
                                    {{ $selectedClientName }}</div>
                            @endif



                        </div>
                        <x-input-error for="media_id" class="mt-2" />


                        <div class="hidden sm:block mt-4">
                            <div class="py-2">
                                <div class="border-t border-gray-400"></div>
                            </div>
                        </div>
                        <div>
                            <div class=" mt-6">
                                <div class="mb-3 mt-6 text-sm text-gray-900 ">I would like this item to be visible
                                    on these dates:
                                </div>

                                <div class="grid grid-cols-2 gap-2 mb-4">
                                    <!-- start date -->
                                    <div class="">
                                        <x-label for="start_time" class="text-lg text-gray-900"
                                            value="{{ __('Starts:') }}" />
                                        {{-- <x-datetime-picker wire:model="start_time" /> --}}
                                        <x-input wire:model="start_time" type="datetime-local"
                                            min="{{ $mindate }}" />
                                        <x-input-error for="start_time" class="mt-2" />
                                    </div>
                                    <!-- end date -->
                                    <div class="">
                                        <x-label for="end_time" class="text-lg text-gray-900"
                                            value="{{ __('Ends:') }}" />
                                        {{-- <x-datetime-picker wire:model="end_time" /> --}}
                                        <x-input wire:model="end_time" type="datetime-local"
                                            min="{{ $mindate }}" />
                                        <x-input-error for="end_time" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <label class="flex items-center">
                                <x-checkbox wire:model="visible" value="1"></x-checkbox>
                                <span class="ml-2 text-sm text-gray-900">Display Media Immediately
                                </span>
                            </label>

                            <div class="mt-4 text-xs font-light italic text-gray-900">Selecting "Display Media
                                Immediately" will make
                                this
                                media item
                                visible immediately today. Please leave unchecked when a media item is scheduled for
                                future
                                dates.
                            </div>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button class="mr-2" wire:click="close" wire:loading.attr="disabled">
                        {{ __('Close') }}
                    </x-secondary-button>

                    @if ($modelId)
                        <x-button wire:click="update" wire:loading.attr="disabled">
                            {{ __('Update') }}
                        </x-button>
                    @else
                        <x-button wire:click="create" wire:loading.attr="disabled">
                            {{ __('Create') }}
                        </x-button>
                    @endif

                </x-slot>
            </x-dialog-modal>

            {{-- The Delete Modal --}}
            <x-dialog-modal wire:model="modalDeleteSchedule">
                <x-slot name="title">
                    {{ __('Delete Schedule: ') }}{{ $media_name }}
                </x-slot>

                <x-slot name="content">
                    {{ __('Are you sure you want to delete the schedule for this item? Once deleted, all of its resources and data will be permanently deleted.') }}
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button wire:click="$toggle('modalDeleteSchedule')" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                        {{ __('Delete') }}
                    </x-danger-button>
                </x-slot>
            </x-dialog-modal>
        </div>
    </div>

</div>
