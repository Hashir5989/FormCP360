<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\PublicFormController;
use App\Http\Controllers\Auth\LoginController;
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
    return view('welcome');
});
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/form-list', [PublicFormController::class, 'index']);
Route::get('/form-list/{id}',[PublicFormController::class, 'show']);
Route::post('/form/{id}', [PublicFormController::class, 'store']);

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::resource('forms', FormController::class);
    
});

