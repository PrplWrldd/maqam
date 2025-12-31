<nav x-data="{ open: false }" class="bg-lime-300 border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <img width="50" height="50" src="https://img.icons8.com/ios/50/mosque.png" alt="mosque"/>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    <x-nav-link :href="route('visitor.index')" :active="request()->routeIs('visitor.*')">
                        {{ __('messages.maps') }}
                    </x-nav-link>

                    @if (Auth::user()?->role === 'admin')
                        <x-nav-link :href="route('graves.index')" :active="request()->routeIs('graves.*')">
                        {{ __('messages.graves') }}
                        </x-nav-link>
                    @endif
                    <x-nav-link :href="route('dono')" :active="request()->routeIs('dono')">
                    {{ __('messages.donation') }}
                    </x-nav-link>
                </div>
            </div>
            
            
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Language Switcher -->
                <div class="relative me-4">
                    <!-- Language Switcher Button -->
                    <button id="language-switcher" class="flex items-center px-4 py-2 bg-gray-100 text-sm text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500">
                        
                        {{ strtoupper(app()->getLocale()) }}
                        <svg class="w-4 h-4 ml-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="https://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="language-menu" class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg hidden">
                        <a href="{{ url()->current() }}?lang=en" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-100 hover:text-green-600">
                            English
                        </a>
                        <a href="{{ url()->current() }}?lang=bm" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-100 hover:text-green-600">
                            Bahasa Melayu
                        </a>
                    </div>
                </div>

                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        {{ Auth::user()?->name ?? 'Guest' }}

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        @if (Auth::user()?->role === 'admin' || Auth::user()?->role === 'visitor')
                        <!-- Log Out Button for Authenticated Users -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-responsive-nav-link :href="route('logout')"
                                                    onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                        @else
                            <!-- Log In Button for Guests -->
                            <x-responsive-nav-link :href="route('login')">
                                {{ __('Log In') }}
                            </x-responsive-nav-link>
                        @endif
                    </x-slot>
                </x-dropdown>
            </div>
            
            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-100">
    <div class="pt-2 pb-3 space-y-1">
        <!-- Map Link -->
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <span class="flex items-center">
                <!-- External SVG File for Map Icon -->
                <img src="{{ asset('svg/map.svg') }}" alt="Map Icon" class="h-5 w-5 mr-2">
                {{ __('Map') }}
            </span>
        </x-responsive-nav-link>

        <!-- Admin-Only Links -->
        @if (Auth::user()?->role === 'admin')
            <x-responsive-nav-link :href="route('graves.index')" :active="request()->routeIs('graves.*')">
                <span class="flex items-center">
                    <!-- External SVG File for Graves Icon -->
                    <img src="{{ asset('svg/grave.png') }}" alt="Graves Icon" class="h-5 w-5 mr-2">
                    {{ __('Graves') }}
                </span>
            </x-responsive-nav-link>
        @endif

        <!-- Donation Link -->
        <x-responsive-nav-link :href="route('dono')" :active="request()->routeIs('dono')">
            <span class="flex items-center">
                <!-- External SVG File for Donation Icon -->
                <img src="{{ asset('svg/donation.png') }}" alt="Donation Icon" class="h-5 w-5 mr-2">
                {{ __('Donation') }}
            </span>
        </x-responsive-nav-link>
        
    </div>
        
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()?->name ?? 'Guest' }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                @if (Auth::user()?->role === 'admin' || Auth::user()?->role === 'visitor')
                <!-- Log Out Button for Authenticated Users -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
                @else
                    <!-- Log In Button for Guests -->
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log In') }}
                    </x-responsive-nav-link>
                @endif
            </div>
        </div>
    </div>
</nav>
<script>
    document.getElementById('language-switcher').addEventListener('click', function () {
        const menu = document.getElementById('language-menu');
        menu.classList.toggle('hidden');
    });
</script>