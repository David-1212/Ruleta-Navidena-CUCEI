{{-- TOP BAR / CRÉDITOS --}}
<div class="w-full bg-gray-900 text-gray-300 text-sm">
    <div class="max-w-7xl mx-auto px-4 py-2 flex justify-center sm:justify-end">
        <span class="flex items-center gap-2">
            🎰 <span>Creado por</span>
            <span class="font-semibold text-green-400">CTA CUCEI</span>
        </span>
    </div>
</div>

{{-- NAVBAR --}}
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

    {{-- CONTENEDOR --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- IZQUIERDA --}}
            <div class="flex">

                {{-- LOGO --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo />
                    </a>
                </div>

                {{-- LINKS DESKTOP --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        📊 Estadísticas
                    </x-nav-link>

                    <x-nav-link :href="route('rifa.index')" :active="request()->routeIs('rifa.*')">
                        🎰 Ruleta
                    </x-nav-link>

                    <x-nav-link :href="route('premios.index')" :active="request()->routeIs('premios.*')">
                        🎁 Premios
                    </x-nav-link>

                    <x-nav-link :href="route('participantes.index')" :active="request()->routeIs('participantes.*')">
                        👥 Participantes
                    </x-nav-link>
                </div>
            </div>

            {{-- USUARIO DESKTOP --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white rounded-md hover:text-gray-700 transition">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Perfil
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- BOTÓN HAMBURGUESA --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MENÚ RESPONSIVE --}}
    <div x-show="open" class="sm:hidden border-t border-gray-200">

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                📊 Estadísticas
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('rifa.index')" :active="request()->routeIs('rifa.*')">
                🎰 Ruleta
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('premios.index')" :active="request()->routeIs('premios.*')">
                🎁 Premios
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('participantes.index')" :active="request()->routeIs('participantes.*')">
                👥 Participantes
            </x-responsive-nav-link>
        </div>

        {{-- USUARIO RESPONSIVE --}}
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">
                    {{ Auth::user()->name }}
                </div>
                <div class="font-medium text-sm text-gray-500">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Perfil
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link
                        :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Cerrar sesión
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
