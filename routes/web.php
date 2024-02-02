<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GruposController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Grupos
    Route::get('/grupos', [GruposController::class, 'index'])->name('grupos.index');
    Route::get('/gruposJson', [GruposController::class, 'getGrupos'])->name('grupos.getGrupos');
    Route::post('/nuevo', [GruposController::class, 'store'])->name('grupos.store');
    Route::post('/grupos/updtState', [GruposController::class, 'updtState'])->name('grupos.updtState');

    Route::get('/', [GruposController::class, 'index'])->name('grupos.index1');

Route::get('/dashboard', [GruposController::class, 'index'])->name('grupos.index2');

});

require __DIR__.'/auth.php';