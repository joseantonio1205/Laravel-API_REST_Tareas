<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//Crear, Leer, Actualizar, Eliminar
//mostrar
Route::get('/task',[TaskController::class, 'index'])->name('task_mostrar');

//mostrar solo una tarea
Route::get('/task/mostrar/{id}', [TaskController::class, 'show'])->name('task_mostrar_1');

//crear
Route::post('/task/create', [TaskController::class, 'store'])->name('task_create');

//actualizar todo
Route::put('/task/update/{id}', [TaskController::class, 'update'])->name('task_update');

//actualizar solo un dato
Route::patch('/task/update/oneitems/{id}', [TaskController::class, 'edit'])->name('task_up_edit');

//eliminar
Route::delete('/task/delete/{id}', [TaskController::class, 'destroy'])->name('eliminar');