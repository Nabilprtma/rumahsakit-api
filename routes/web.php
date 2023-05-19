<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RsakitController;

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

Route::get('/rsakits', [RsakitController::class, 'index']);
Route::get('/generate-token', [RsakitController::class, 'createToken']);
Route::post('/rsakits/tambah-data', [RsakitController::class, 'store']);
Route::get('/rsakits/{id}', [RsakitController::class, 'show']);
Route::patch('/rsakits/{id}/update', [RsakitController::class, 'update']);
Route::delete('/rsakits/{id}/delete', [RsakitController::class, 'destroy']);
Route::get('/rsakits/show/trash', [RsakitController::class, 'trash']);
Route::get('/rsakits/trash/restore/{id}', [RsakitController::class, 'restore']);
Route::get('/rsakits/trash/delete/permanent/{id}', [RsakitController::class, 'permanentDelete']);

