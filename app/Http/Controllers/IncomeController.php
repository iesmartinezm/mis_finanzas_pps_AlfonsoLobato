<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * Muestra la lista de ingresos.
     */
    public function index()
    {
        $title = 'Ingresos de USUARIO';

        // Obtener los datos de la sesión o inicializar arrays vacíos
        $incomes = session('incomes', []);
        $headers = session('headers', ['Monto', 'Fecha', 'Descripción']);

        // Preparar los datos para la tabla
        $rows = [];
        foreach ($incomes as $income) {
            $row = [];
            foreach ($headers as $header) {
                $row[strtolower($header)] = $income[strtolower($header)] ?? '';
            }
            $rows[] = $row;
        }

        return view('income.index', [
            'incomes' => $incomes,
            'headers' => $headers,
            'rows' => $rows, // Pasar la variable $rows a la vista
            'title' => $title,
        ]);
    }

    /**
     * Almacena un nuevo ingreso o añade un nuevo campo.
     */
    public function store(Request $request)
    {
        // Obtener los datos de la sesión o inicializar arrays vacíos
        $incomes = session('incomes', []);
        $headers = session('headers', ['Monto', 'Fecha', 'Descripción']);
    
        // Si se está añadiendo un nuevo campo (columna)
        if ($request->has('add_column')) {
            // Validar solo el campo 'new_column'
            $request->validate([
                'new_column' => 'required|string|max:255',
            ]);
    
            $newColumn = $request->input('new_column');
            if (!in_array($newColumn, $headers)) {
                $headers[] = $newColumn; // Añadir el nuevo campo a los encabezados
            }
        }
    
        // Si se está añadiendo una nueva fila
        if ($request->has('add_row')) {
            // Definir las reglas de validación para los campos de la fila
            $rules = [];
            foreach ($headers as $header) {
                $field = strtolower($header); // Usar el nombre del campo en minúsculas
                if ($field === 'fecha') {
                    // Validar que sea una fecha válida solo si se ingresa un valor
                    $rules[$field] = 'nullable|date';
                } else {
                    // Validar que los demás campos no estén vacíos solo si se ingresa un valor
                    $rules[$field] = 'nullable|string|max:255';
                }
            }
    
            // Validar los datos del formulario
            $request->validate($rules);
    
            // Añadir la nueva fila
            $newRow = [];
            foreach ($headers as $header) {
                $newRow[strtolower($header)] = $request->input(strtolower($header)) ?? ''; // Usar vacío si el campo no se completó
            }
            $incomes[] = $newRow;
        }
    
        // Guardar los datos en la sesión
        session(['incomes' => $incomes]);
        session(['headers' => $headers]);
    
        // Redirigir a la página de ingresos
        return redirect()->route('incomes.index');
    }
    

    public function delete(Request $request)
    {
        // Obtener los datos de la sesión
        $incomes = session('incomes', []);
        $headers = session('headers', ['Monto', 'Fecha', 'Descripción']);
    
        // Borrar una fila específica
        if ($request->has('delete_row_index')) {
            $index = $request->input('delete_row_index');
            if (isset($incomes[$index])) {
                unset($incomes[$index]); // Eliminar la fila
                $incomes = array_values($incomes); // Reindexar el array
            }
        }
    
        // Borrar un campo específico
        if ($request->has('delete_column')) {
            $columnToDelete = $request->input('delete_column');
    
            // Eliminar el campo de los encabezados
            $headers = array_filter($headers, function ($header) use ($columnToDelete) {
                return $header !== $columnToDelete;
            });
    
            // Eliminar el campo de todas las filas
            $incomes = array_map(function ($row) use ($columnToDelete) {
                unset($row[strtolower($columnToDelete)]);
                return $row;
            }, $incomes);
        }
    
        // Guardar los datos actualizados en la sesión
        session(['incomes' => $incomes]);
        session(['headers' => $headers]);
    
        // Redirigir a la página de ingresos
        return redirect()->route('incomes.index');
    }

    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


}