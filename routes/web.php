<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/employees', [EmployeesController::class, 'index']);
Route::get('/employees', [EmployeesController::class, 'index'])->middleware('auth:sanctum');
