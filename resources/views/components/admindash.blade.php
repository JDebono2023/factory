<div class="py-5 px-6 bg-white  border-b border-gray-400 ">
    <div class="grid grid-cols-1  md:flex md:items-center ">
        <x-client-logo />
        <h1 class="text-lg lg:text-xl xl:text-2xl font-bold text-blue-6 text-left md:text-center md:ml-10 mb-2 md:mb-0 ">
            Welcome to the Media Manager!
        </h1>

    </div>
    <p class=" text-gray-900 leading-relaxed text-left text-sm xl:text-base ">
        View your teams, manage your users and access your media manager .
    </p>
</div>

<div class=" bg-gray-200 grid grid-cols-3 gap-6 p-6 lg:p-8 ">


    <div class="bg-white p-6  text-xl border border-gray-400 shadow shadow-gray-400 flex items-center ">
        <a href="{{ route('teams') }}">
            <h2 class="font-semibold text-base pb-2 text-blue-6 md:text-xl border-b border-gray-500 ">
                Teams
            </h2>
            <div class="flex items-center mt-5 ">
                <p class=" text-gray-900 text-sm md:text-base leading-relaxed ">
                    View and manage your team. Invite, remove and assign team member.
                </p>
                <span class="material-symbols-outlined  text-3xl text-blue-6 ml-4">
                    <span class="material-symbols-outlined">
                        arrow_circle_right
                    </span>
                </span>
            </div>
        </a>
    </div>
    <div class="bg-white p-6 text-xl border border-gray-400 shadow shadow-gray-400 flex items-center pb-5 ">
        <a href="{{ route('users') }}">
            <h2 class="font-semibold text-base pb-2 text-blue-6 md:text-xl border-b border-gray-500 ">
                Users
            </h2>
            <div class="flex items-center mt-5">
                <p class=" text-gray-900 text-sm md:text-base leading-relaxed ">
                    View and manage your users and view user team associations.
                </p>
                <span class="material-symbols-outlined  text-3xl text-blue-6 ml-4">
                    <span class="material-symbols-outlined">
                        arrow_circle_right
                    </span>
                </span>
            </div>
        </a>
    </div>
    <div class="bg-white p-6 text-xl border border-gray-400 shadow shadow-gray-400 flex items-center pb-5 ">
        <a href="{{ route('media') }}">
            <h2 class="font-semibold text-base pb-2 text-blue-6 md:text-xl border-b border-gray-500 ">
                Media Manager
            </h2>
            <div class="flex items-center mt-5">
                <p class=" text-gray-900 text-sm md:text-base leading-relaxed ">
                    View, add, edit and delete your media and schedule items for display.
                </p>
                <span class="material-symbols-outlined  text-3xl text-blue-6 ml-4">
                    <span class="material-symbols-outlined">
                        arrow_circle_right
                    </span>
                </span>
            </div>
        </a>
    </div>

</div>
