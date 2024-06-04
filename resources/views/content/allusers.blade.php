<x-app-layout>
    <div class="pb-12 pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="max-w-7xl shadow shadow-gray-600">
                <div class=" py-5 px-6 bg-white border-b border-gray-400">
                    <div class=" grid grid-cols-1  md:flex md:items-center">
                        <x-client-logo />
                        <h1 class="text-lg lg:text-xl xl:text-2xl font-bold text-blue-6 text-center ml-10 ">
                            User Administration
                        </h1>
                    </div>
                    <p class=" text-gray-900 leading-relaxed text-left text-sm xl:text-base">
                        View all users in the database, each user's team, and delete users. To remove a user from
                        a team,
                        navigate
                        to </br>
                        that users team to proceed with removal. To fully delete a user from the database, click Delete
                        User.
                    </p>
                </div>
                <div>
                    @livewire('allusers')
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
