@props(['headers', 'rows'])

<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-200">
        <thead class="bg-gray-50">
            <tr>
                @foreach ($headers as $header)
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ $header }}
                    </th>
                @endforeach
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach ($rows as $index => $row)
                <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-gray-100">
                    @foreach ($headers as $header)
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $row[strtolower($header)] ?? '' }}
                        </td>
                    @endforeach
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <form action="{{ route('incomes.delete') }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="delete_row_index" value="{{ $index }}">
                            <button type="submit" class="p-2 bg-red-500 text-white rounded">Borrar Fila</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>