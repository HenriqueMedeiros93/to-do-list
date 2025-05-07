<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoListController;

Route::prefix('task')->group(function () {
    Route::get('/', [TodoListController::class, 'getTasks']);
    Route::post('/', [TodoListController::class, 'createTask']);
    Route::put('/{id}', [TodoListController::class, 'updateTask']);
    Route::delete('/{id}', [TodoListController::class, 'deleteTask']);
});