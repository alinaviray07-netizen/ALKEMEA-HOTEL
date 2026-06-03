<nav class="luxury-navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="luxury-brand text-xl">
                    ALKEMEA Hotel
                </a>

                <div class="hidden sm:flex items-center gap-6">
                    <a href="{{ route('home') }}" class="luxury-link {{ request()->routeIs('home') ? 'border-b-2 border-indigo-400 pb-1' : '' }}">
                        Rooms
                    </a>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="luxury-link {{ request()->routeIs('admin.dashboard') ? 'border-b-2 border-indigo-400 pb-1' : '' }}">
                                Admin Dashboard
                            </a>

                            <a href="{{ route('admin.rooms.index') }}" class="luxury-link {{ request()->routeIs('admin.rooms.*') ? 'border-b-2 border-indigo-400 pb-1' : '' }}">
                                Manage Rooms
                            </a>

                            <a href="{{ route('admin.reservations.index') }}" class="luxury-link {{ request()->routeIs('admin.reservations.*') ? 'border-b-2 border-indigo-400 pb-1' : '' }}">
                                Reservations
                            </a>

                            <a href="{{ route('admin.payments.index') }}" class="luxury-link {{ request()->routeIs('admin.payments.*') ? 'border-b-2 border-indigo-400 pb-1' : '' }}">
                                Payments
                            </a>

                            <a href="{{ route('admin.reports') }}" class="luxury-link {{ request()->routeIs('admin.reports') ? 'border-b-2 border-indigo-400 pb-1' : '' }}">
                                Reports
                            </a>
                        @else
                            <a href="{{ route('reservations.index') }}" class="luxury-link {{ request()->routeIs('reservations.*') ? 'border-b-2 border-indigo-400 pb-1' : '' }}">
                                My Reservations
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center">
                @auth
                    <div class="relative">
                        <button onclick="document.getElementById('userDropdown').classList.toggle('hidden')" class="btn-luxury">
                            {{ auth()->user()->name }}
                            <span class="ml-1">⌄</span>
                        </button>

                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                            <div class="px-4 py-2 text-sm text-gray-700">
                                {{ auth()->user()->email }}
                            </div>

                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="luxury-link">Login</a>
                        <a href="{{ route('register') }}" class="luxury-link">Register</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>