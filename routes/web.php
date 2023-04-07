<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\CategoriaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

// ------------------------- MARCA -------------------------

Route::get('marca/carregarTabela', [MarcaController::class, 'carregarTabela'])->name('marca.tabela');

Route::Resource('marca', MarcaController::class)->except([
    'create', 'edit'
]);

// ------------------------- Categoria -------------------------

Route::get('categoria/carregarTabela', [CategoriaController::class, 'carregarTabela'])->name('categoria.tabela');

Route::Resource('categoria', CategoriaController::class)->except([
    'create', 'edit'
]);;