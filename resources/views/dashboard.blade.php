<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="max-w-7xl mt-6 shadow shadow-gray-600">
            {{-- {{ Auth::user()->ownedTeams }} --}}

            @if (Auth::user()->teams->where('id', '=', '2')->first() || Auth::user()->ownedTeams()->count() > 0)
                <div class="">
                    <x-admindash />
                </div>
            @else
                <x-non-authdash />
            @endif

        </div>
    </div>
</x-app-layout>
