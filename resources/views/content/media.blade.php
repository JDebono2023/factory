<x-app-layout>
    <div class="pb-12 pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="max-w-7xl md:pb-14">
                <div class=" py-5 px-6 bg-white shadow shadow-gray-600">
                    <div class=" flex items-center ">
                        <x-client-logo />
                        <h1 class="text-lg lg:text-xl xl:text-2xl font-bold text-blue-6 text-center ml-10 ">
                            Media Manager
                        </h1>
                    </div>

                </div>
                <div>
                    @livewire('schedules')
                </div>
                <div>
                    @livewire('medias')
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
