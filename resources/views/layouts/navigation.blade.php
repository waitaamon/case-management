<nav class="bg-indigo-500 border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600"/>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('cases.index')" :active="request()->routeIs('cases.index')">
                        {{ __('Cases') }}
                    </x-nav-link>
                    @if(\Illuminate\Support\Str::afterLast(auth()->user()->role, '-') == 'admin')
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                            {{ __(auth()->user()->role == 'agency-admin' ? 'Investigators' : 'Judicial Officers') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="font-medium text-base text-gray-300">{{ Auth::user()->name }}</div>
                <div class="">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a class="font-medium text-base text-red-300 hover:text-red-400 focus::text-red-400"
                           href="{{route('logout')}}"
                           onclick="event.preventDefault();
                               this.closest('form').submit();"
                        >
                            {{ __('Log out') }}
                        </a>
                    </form>
                </div>

            </div>
        </div>
    </div>
</nav>
