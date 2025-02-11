<?php

use App\Http\Controllers\IncomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/incomes',[IncomeController::class, 'index'])->name('incomes.index');

Route::get('/mi-primer-api-point', function () {
    
    $miArray = [
        'clave1'=>'valor1',
        'clave2'=>'valor2',
        'clave3'=>[
            3,24
        ]
    ];
    return $miArray;
    //return '<p>Mi primera página</p>';
});
