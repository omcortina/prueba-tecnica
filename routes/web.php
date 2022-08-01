<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

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

Route::get('/', [EmployeeController::class, 'list']);
Route::any('create', [EmployeeController::class, 'create'])->name('create');
Route::any('edit/{id}', [EmployeeController::class, 'edit'])->name('edit');
Route::get('delete/{id}', [EmployeeController::class, 'delete'])->name('delete');
