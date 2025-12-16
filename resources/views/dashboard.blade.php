<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-8">

                <div class="text-center">
                    <h3 class="text-2xl font-bold mb-8">🎁 Estado de la rifa</h3>

                    {{-- Datos --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-10 text-center">

                        <div>
                            <p class="text-sm text-gray-500">🎁 Premios totales</p>
                            <p class="font-bold text-3xl text-gray-800">
                                {{ $totalPremios }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">🎁 Premios restantes</p>
                            <p class="font-bold text-3xl text-green-600">
                                {{ $premiosRestantes }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">👥 Participantes totales</p>
                            <p class="font-bold text-3xl text-gray-800">
                                {{ $totalParticipantes }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">👥 Sin regalo</p>
                            <p class="font-bold text-3xl text-red-600">
                                {{ $personasRestantes }}
                            </p>
                        </div>

                    </div>


                    {{-- LÓGICA SIMPLE --}}
                    @php
                        $porcentajeReal = $totalPremios > 0
                            ? ($premiosRestantes / $totalPremios) * 100
                            : 0;

                        $porcentajeReal = max(0, min(100, $porcentajeReal));

                        // Mínimo visual para que no desaparezca hasta llegar a 0
                        $porcentajeVisual = $porcentajeReal > 0
                            ? max($porcentajeReal, 4)
                            : 0;
                    @endphp

                    {{-- REGALO / PILA HORIZONTAL (SIEMPRE VERDE) --}}
                    <div class="flex justify-center mt-10">
                        <div class="relative w-full max-w-xl h-20 border-4 border-gray-700 rounded-xl bg-gray-300 overflow-hidden shadow-lg">

                            {{-- CARGA --}}
                            <div
                                class="absolute left-0 top-0 h-full bg-green-500 transition-all duration-700 ease-out z-10"
                                style="width: {{ $porcentajeVisual }}%"
                            ></div>

                            {{-- LAZOS --}}
                            <div class="absolute inset-y-0 left-1/2 w-6 bg-red-600 -translate-x-1/2 z-20 pointer-events-none"></div>
                            <div class="absolute inset-x-0 top-1/2 h-4 bg-red-600 -translate-y-1/2 z-20 pointer-events-none"></div>

                            {{-- ICONO --}}
                            <div class="absolute inset-0 flex items-center justify-center z-30 pointer-events-none">
                                <span class="text-4xl">🎁</span>
                            </div>
                        </div>
                    </div>

                    <p class="mt-4 text-lg font-semibold">
                        {{ round($porcentajeReal) }}% de regalos disponibles
                    </p>

                    {{-- Mensaje final --}}
                    @if ($premiosRestantes == 0 && $totalPremios > 0)
                        <p class="mt-5 text-xl font-bold text-green-700">
                            🎉 ¡Todos los regalos han sido repartidos!
                        </p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
