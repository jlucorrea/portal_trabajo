<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostulanteController;
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

Route::get('/', function () {
    return view('Jobs/postulacion');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::controller(UserController::class)->middleware(['auth'])->prefix('users')->group(function(){
	Route::get('/', 'index')->name('users');
	Route::post('/', 'store');
	Route::get('/records', 'records');
});

Route::get('/jobs/all_records', [JobController::class, 'records']);

Route::controller(JobController::class)->middleware(['auth'])->prefix('jobs')->group(function(){
	Route::get('/', 'index')->name('jobs');
	Route::post('/', 'store');
	Route::get('/record/{id}', 'record');
	Route::get('/columns', 'columns');
	Route::get('/records', 'records');
	Route::delete('/{id}', 'destroy');
});

Route::post('/postulante/register', [PostulanteController::class, 'register']);

Route::controller(PostulanteController::class)->middleware(['auth'])->prefix('postulante')->group(function(){
	Route::get('/', 'index')->name('postulante');
	Route::post('/', 'store');
});

Route::controller(PostulanteController::class)->middleware(['auth'])->prefix('postulaciones')->group(function(){
	Route::post('', 'postulaciones');
	Route::get('/postulado/{id}', 'postulado');
});