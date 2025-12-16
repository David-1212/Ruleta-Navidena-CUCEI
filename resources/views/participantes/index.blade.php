<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">👥 Participantes</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">

        {{-- IMPORTAR CSV --}}
        <form method="POST"
              action="{{ route('participantes.importar') }}"
              enctype="multipart/form-data"
              class="mb-6 flex flex-wrap items-center gap-4">
            @csrf
            <input type="file" name="archivo" required>
            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Importar CSV
            </button>
        </form>

        {{-- BÚSQUEDA POR NOMBRE --}}
        <div class="mb-6 flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Buscar por nombre</label>
                <input
                    type="text"
                    id="buscar"
                    placeholder="Escribe un nombre..."
                    class="border rounded px-3 py-2 w-64"
                >
            </div>
        </div>

        {{-- TABLA --}}
        <div id="tabla-participantes">
            @include('participantes._tabla')
        </div>

    </div>

    {{-- JS AJAX --}}
    <script>
        const buscarInput = document.getElementById('buscar');
        const tabla = document.getElementById('tabla-participantes');

        let timeout = null;

        function buscar(url = null) {
            const buscar = buscarInput.value;

            const endpoint = url ?? `{{ route('participantes.buscar') }}?` +
                new URLSearchParams({ buscar });

            fetch(endpoint, {
                credentials: 'same-origin'
            })
                .then(res => res.text())
                .then(html => tabla.innerHTML = html);
        }

        buscarInput.addEventListener('keyup', () => {
            clearTimeout(timeout);
            timeout = setTimeout(buscar, 300);
        });

        // paginación AJAX
        document.addEventListener('click', e => {
            const link = e.target.closest('.pagination a');
            if (link) {
                e.preventDefault();
                buscar(link.href);
            }
        });
    </script>
</x-app-layout>
