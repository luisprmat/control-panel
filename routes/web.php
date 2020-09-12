<?php

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

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\WelcomeUserController;

Route::get('/', function () {
    return view('home');
});

// Users
Route::get('/usuarios', [UserController::class, 'index'])
    ->name('users.index');

Route::get('/usuarios/{user}', [UserController::class, 'show'])
    ->where('user', '[0-9]+')
    ->name('users.show');

Route::get('/usuarios/nuevo', [UserController::class, 'create'])
    ->name('users.create');

Route::post('/usuarios', [UserController::class, 'store']);

Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])
    ->name('users.edit');

Route::put('/usuarios/{user}', [UserController::class, 'update']);

Route::get('/usuarios/papelera', [UserController::class, 'index'])->name('users.trashed');

Route::patch('/usuarios/{user}/papelera', [UserController::class, 'trash'])->name('users.trash');

Route::patch('/usuarios/{id}/restaurar', [UserController::class, 'restore'])
    ->name('users.restore');

Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])
    ->name('users.destroy');

//Profile
Route::get('/editar-perfil/', [ProfileController::class, 'edit']);

Route::put('/editar-perfil/', [ProfileController::class, 'update']);

//Professions
Route::get('/profesiones/', [ProfessionController::class, 'index']);

Route::delete('/profesiones/{profession}', [ProfessionController::class, 'destroy']);

//Skills
Route::get('/habilidades/', [SkillController::class, 'index']);

//Welcome
Route::get('/saludo/{name}/{nickname?}', WelcomeUserController::class);

