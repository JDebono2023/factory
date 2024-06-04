<nav x-data="{ open: false }" class="shadow shadow-gray-500 border-b bg-white  border-gray-200">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-900 hover:text-gray-400 focus:outline-none transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="pt-2 space-y-1">
                                <x-dropdown-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                                    {{ __('Dashboard') }}
                                </x-dropdown-link>
                            </div>
                            @if (Auth::user()->teams->where('id', '=', '2')->first() || Auth::user()->ownedTeams()->count() > 0)
                                <x-dropdown-link href="{{ route('teams') }}" :active="request()->routeIs('teams')">
                                    {{ __('Teams') }}
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('users') }}" :active="request()->routeIs('users')">
                                    {{ __('Users') }}
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('media') }}" :active="request()->routeIs('media')">
                                    {{ __('Media Manager') }}
                                </x-dropdown-link>
                            @endif
                            <div class=" border-t border-gray-300 block px-4 text-sm pt-2 text-gray-900">
                                {{ __('Manage Account') }}</div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <div class="pt-2 space-y-1">
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            </div>
            @if (Auth::user()->teams->where('id', '=', '1')->first() || Auth::user()->ownedTeams)

                <x-responsive-nav-link href="{{ route('teams') }}" :active="request()->routeIs('teams')">
                    {{ __('Teams') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('users') }}" :active="request()->routeIs('users')">
                    {{ __('Users') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('media') }}" :active="request()->routeIs('media')">
                    {{ __('Media Manager') }}
                </x-responsive-nav-link>

                {{-- <x-responsive-nav-link href="{{ route('schedule') }}" :active="request()->routeIs('schedule')">
                    {{ __('Media Scheduler') }}
                </x-responsive-nav-link> --}}
            @else
                @if (Auth::user()->teams->where('id', '=', '2')->first())
                    <x-responsive-nav-link href="{{ route('media') }}" :active="request()->routeIs('media')">
                        {{ __('Media Manager') }}
                    </x-responsive-nav-link>

                    {{-- <x-responsive-nav-link href="{{ route('schedule') }}" :active="request()->routeIs('schedule')">
                        {{ __('Media Scheduler') }}
                    </x-responsive-nav-link> --}}
                    <x-responsive-nav-link href="{{ route('teams.show', 2) }}" :active="request()->routeIs('teams')">
                        {{ __('Teams') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('users') }}" :active="request()->routeIs('users')">
                        {{ __('Users') }}
                    </x-responsive-nav-link>
                @endif
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 border-t border-gray-200">
            <div class="block px-4 text-sm text-gray-400">
                {{ __('Manage Account') }}
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                {{-- @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                        :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-switchable-team :team="$team" component="responsive-nav-link" />
                    @endforeach
                @endif --}}
            </div>
        </div>
    </div>
</nav>
