<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="max-w-7xl mt-6 shadow shadow-gray-600">
            <div class=" py-5 px-6 bg-white border-b border-gray-400">
                <div class=" flex items-center ">
                    <x-client-logo />
                    <h1 class="text-lg lg:text-xl xl:text-2xl font-bold text-blue-6 text-center ml-10 ">
                        Team Manager
                    </h1>
                </div>
                <p class=" text-gray-900 leading-relaxed text-left text-sm xl:text-base">
                    @if (Auth::user()->teams->where('id', '!=', '2')->first())
                        All teams in the database are displayed. Administrators may add new teams, view teams to access
                        the
                        <br>
                        individual team settings and invite or remove users for each store.
                    @else
                        View your team, and manage your team members.
                    @endif
                </p>
            </div>
            <div>
                @livewire('team-dash')
            </div>
        </div>
    </div>
</x-app-layout>
