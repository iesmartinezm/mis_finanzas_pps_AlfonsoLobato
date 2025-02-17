<x-layouts.main :title="$title">
    <p>El body de incomes:</p>

    <!-- Mostrar mensajes de error -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulario para añadir un nuevo campo -->
    <form action="{{ route('incomes.store') }}" method="POST" class="mb-6">
        @csrf
        <div>
            <label for="new_column" class="block text-sm font-medium text-gray-700">Nuevo Campo</label>
            <input type="text" name="new_column" id="new_column" placeholder="Nombre del nuevo campo" class="p-2 border rounded">
            <button type="submit" name="add_column" class="p-2 bg-green-500 text-white rounded">Añadir Campo</button>
        </div>
    </form>

    <!-- Formulario para añadir una nueva fila -->
    <form action="{{ route('incomes.store') }}" method="POST" class="mb-6">
        @csrf
        <div class="flex gap-4">
            @foreach ($headers as $header)
                <div>
                    <label for="{{ strtolower($header) }}" class="block text-sm font-medium text-gray-700">{{ $header }}</label>
                    <input type="text" name="{{ strtolower($header) }}" id="{{ strtolower($header) }}" placeholder="{{ $header }}" class="p-2 border rounded">
                </div>
            @endforeach
            <button type="submit" name="add_row" class="p-2 bg-blue-500 text-white rounded self-end">Añadir Fila</button>
        </div>
    </form>

    <!-- Mostrar la tabla dinámica -->
    <x-table :headers="$headers" :rows="$rows" />

    <!-- Lista de campos añadidos con botones para borrar -->
    <div class="mt-6">
        <h3 class="text-lg font-semibold mb-4">Campos Añadidos</h3>
        <ul class="space-y-2">
            @foreach ($headers as $header)
                @if (!in_array($header, ['Monto', 'Fecha', 'Descripción']))
                    <li class="flex items-center justify-between p-2 bg-gray-50 rounded">
                        <span>{{ $header }}</span>
                        <form action="{{ route('incomes.delete') }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="delete_column" value="{{ $header }}">
                            <button type="submit" class="p-2 bg-red-500 text-white rounded">Borrar</button>
                        </form>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</x-layouts.main>