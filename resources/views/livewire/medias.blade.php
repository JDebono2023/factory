<div class="mt-10 shadow shadow-gray-600">
    <div class="px-6 py-4 bg-white border-gray-400 border-b-2 ">

        <h1 class="text-lg lg:text-xl xl:text-2xl font-bold text-blue-6 text-left">
            Current Media
        </h1>

        <p class=" text-gray-900 leading-relaxed text-left text-sm xl:text-base">
            Add, edit, delete and preview your images.
        </p>

    </div>
    <div class="p-2 lg:p-4 shadow shadow-gray-400 border border-gray-200  bg-gray-200 grid  grid-cols-10">
        {{-- filtering and add content --}}
        <div class="col-span-2 ">
            {{-- create content --}}
            <x-button class="mb-4 ml-0 " wire:click="createMediaModal">
                {{ __('Add New Media') }}
            </x-button>
            {{-- filtering - clear all filters --}}
            <button
                class="inline-flex items-center px-1 lg:px-4 py-1 bg-gray-500 border border-transparent rounded-md font-body text-[10px] lg:text-xs text-white uppercase tracking-widest hover:bg-gray-400  active:bg-gray-400 focus:outline-none transition ease-in-out duration-150 shadow-sm shadow-gray-400 "
                wire:click="resetFilters">
                {{ __('Clear Filters') }}
            </button>
            <div class="flex flex-col mt-4">
                {{-- filtering - search by text --}}
                <div class="flex w-full">
                    <x-tni-search-circle-o
                        class="text-sm h-6 lg:h-8 text-gray-600 border border-gray-600 shadow shadow-gray-400 bg-white -mr-1 py-1 px-1 rounded-l-md z-10 " />
                    <x-input wire:model='searchTerm' type="search" placeholder="Search..."
                        class="w-3/4 mr-3 h-6 lg:h-8  text-gray-900 text-xs lg:text-sm " />

                    <x-input-error for="searchTerm" class="mt-2" />
                </div>
                {{-- filtering - view items: with schedule - active or non-active, non-scheduled --}}
                <div class="mt-5">
                    <div class="text-gray-900">
                        <span class="font-bold text-[14px] lg:text-base text-blue-6">Scheduled</span>

                        @foreach ($visibleList as $index => $schedule)
                            <label class="flex items-center md:mb-1 lg:mb-0">
                                <x-checkbox wire:model="mediaScheduled"
                                    value="{{ $schedule['schedule'] }}"></x-checkbox>
                                <span
                                    class="material-symbols-outlined text-base lg:text-xl  leading-4 font-medium {{ $schedule['color'] }} tracking-wider text-center  hover:text-gray-500 active:bg-gray-500 transition ease-in-out duration-150 ml-1">
                                    <span class="material-symbols-rounded">
                                        radio_button_checked
                                    </span>
                                </span>
                                <span class="ml-1  text-[11px] md:text-xs xl:text-sm ">{{ $schedule['type'] }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- data table --}}
        <div class="flex flex-col col-span-8">
            <div class="-my-2 overflow-x-auto lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full  lg:px-8">
                    <div class="overflow-hidden sm:rounded shadow-md shadow-gray-500">
                        <table class="w-full 0">
                            <thead>
                                <tr
                                    class="px-6 py-3 bg-gray-700 text-center text-[10px] md:text-[12px] xl:text-sm leading-4 font-black text-white uppercase tracking-wider">
                                    <th class="px-2 xl:px-4 text-left">
                                        Media Name</th>
                                    <th class="px-2 xl:px-4 text-left">
                                        File Name</th>
                                    <th class="px-2 md:px-6 ">
                                        Image</th>
                                    <th class="px-2 xl:px-4 ">
                                        Status</th>
                                    <th class="px-2 lg:px-6 py-3">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class=" bg-white divide-y divide-gray-400">
                                @if ($media->count())
                                    @foreach ($media as $item)
                                        <tr
                                            class="text-[10px] md:text-[12px] xl:text-sm leading-4 font-medium text-gray-900 tracking-wider text-left">
                                            <td class="px-2 lg:px-4 text-left ">
                                                {{ $item->client_name }}
                                            </td>
                                            <td class="pl-2 lg:px-4 text-left ">
                                                {{ $item->file_name }}
                                            </td>

                                            <td class="text-left">
                                                <div class="flex  place-content-center 2xl:mx-2 lg:py-2">
                                                    <img class="h-10 lg:h-12 hover:cursor-pointer"
                                                        wire:click="mediaPreviewModal({{ $item->id }})"
                                                        src="{{ Storage::disk('s3')->url('factory/images/' . $item->aws_name) }}">
                                                </div>
                                            </td>
                                            <td class="xl:px-6 text-center">
                                                @forelse ($item->schedules as $schedule)
                                                    @if ($schedule->visible == 1 && $schedule)
                                                        <span
                                                            class="material-symbols-outlined py-3 text-base lg:text-xl  leading-4 font-medium text-green-600 tracking-wider text-center ">
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
                                                @empty
                                                    <span
                                                        class="material-symbols-outlined py-3 text-base lg:text-xl  leading-4 font-medium text-gray-600 tracking-wider text-center  ">
                                                        <span class="material-symbols-rounded">
                                                            radio_button_checked
                                                        </span>
                                                    </span>
                                                @endforelse
                                            </td>
                                            <td class="px-2 lg:px-6 text-center">
                                                <button
                                                    class="material-symbols-outlined py-3 text-base lg:text-xl leading-4 font-medium text-gray-900 tracking-wider text-center  hover:text-gray-500 active:bg-gray-500 transition ease-in-out duration-150"
                                                    wire:click="updateMediaModal({{ $item->id }})">
                                                    edit
                                                </button>
                                                <button
                                                    class="material-symbols-outlined  py-3 text-base lg:text-xl leading-4 font-medium text-gray-900 tracking-wider text-center  hover:text-gray-500 active:bg-gray-500 transition ease-in-out duration-150"
                                                    wire:click="deleteMediaModal({{ $item->id }})">
                                                    delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="px-2 lg:px-6 text-sm whitespace-no-wrap" colspan="4">No Results
                                            Found
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

        {{-- add-edit modal --}}
        <x-dialog-modal wire:model="addMediaModal">
            <x-slot name="title">
                @if ($modelId)
                    {{ __('Update Media') }}
                @else
                    {{ __('Add New Media') }}
                @endif
            </x-slot>

            <x-slot name="content">
                <div class=" mt-4" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <!-- File Input -->
                    <input type="file" wire:model="aws_name"
                        class="text-sm text-grey-900
                    file:mr-4 file:py-2 file:px-6
                    file:rounded-l-md file:border-0
                    file:text-sm file:font-medium
                    file:bg-gray-200 file:text-gray-900
                    hover:file:cursor-pointer hover:file:bg-gray-400
                    hover:file:text-white focus:border-gray-300 mb-1 form-input flex-1 block w-full rounded-md text-gray-500 transition duration-150 ease-in-out border border-gray-400 p-0 sm:text-sm sm:leading-5 shadow-sm shadow-gray-400
                    
                    "
                        id="upload{{ $iteration }}" />
                    <div class="text-xs font-light italic text-gray-900">Maxiumum image size permitted: 543px x
                        962px .
                    </div>
                    <x-input-error for="aws_name" class="mt-2" />
                    <!-- Progress Bar -->
                    <div wire:loading wire:target="aws_name">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div>

                </div>

                <div class=" my-4">
                    @if (!$aws_name)
                        <div class="my-4">
                        </div>
                    @elseif($aws_name && !is_string($aws_name))
                        <div class="my-4">
                            <x-label for="aws_name" value="{{ __('Media Preview') }}" />

                            <img width="200" src="{{ $aws_name->temporaryUrl() }}">

                        </div>
                    @elseif ($modelId)
                        <div class="z-depth-1-half mb-2">
                            <x-label for="aws_name" value="{{ __('Media Preview') }}" />

                            <img class="h-12 md:h-14 lg:h-16 2xl:h-24"
                                src="{{ Storage::disk('s3')->url('factory/images/' . $aws_name) }}">
                        </div>
                    @endif
                </div>

                <div class="mb-4">
                    <x-label for="file_name" value="{{ __('File Name: ') }}{{ $file_name }}" />

                    <x-input id="file_name" type="hidden" class="mt-1 block w-full"
                        wire:model.debonce.800ms="file_name" />
                    <x-input-error for="file_name" class="mt-2" />
                </div>
                <div class=" mt-4">
                    <x-label for="client_name" value="{{ __('Media Name') }}" />
                    <x-input wire:model="client_name" id="client_name" type="text" class="mt-1 block w-full"
                        wire:model.debonce.800ms="client_name" />
                    <x-input-error for="client_name" class="mt-2" />
                </div>


            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="close" wire:loading.attr="disabled" class="mr-2">
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

        {{-- preview media modal --}}
        <x-dialog-modal wire:model="mediaPreviewModal">
            <x-slot name="title">
                {{ __('View Media: ') }}{{ $this->client_name }}
            </x-slot>

            <x-slot name="content">
                <div class=" flex place-content-center sm:w-3/4 lg:auto mx-auto">

                    <img src="{{ Storage::disk('s3')->url('factory/images/' . $aws_name) }}">

                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('mediaPreviewModal')" wire:loading.attr="disabled">
                    {{ __('Close') }}
                </x-secondary-button>
            </x-slot>
        </x-dialog-modal>

        {{-- delete media modal --}}
        <x-dialog-modal wire:model="deleteMediaModal">
            <x-slot name="title">
                {{ __('Delete Media: ') }}{{ $this->client_name }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete this content? Once deleted, all of its resources and data will be permanently deleted.') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('deleteMediaModal')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                    {{ __('Delete') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>

        {{-- delete media error modal --}}
        <x-dialog-modal wire:model="showErrorModal">
            <x-slot name="title">
                {{ __('Error') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Cannot delete media item because it has an associated schedule.') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('showErrorModal')" wire:loading.attr="disabled">
                    {{ __('OK') }}
                </x-secondary-button>
            </x-slot>
        </x-dialog-modal>

    </div>

    {{-- <script>
        Livewire.on('cannotDeleteMediaWithEvents', () => {
            alert('Cannot delete items that are scheduled.');
        });
    </script> --}}
</div>
