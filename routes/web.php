<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PhotoController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [UserController::class, 'index'])->name('homepage');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register-action', [UserController::class, 'registerAction'])->name('register.action');
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login-action', [UserController::class, 'loginAction'])->name('login.action');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/profil', [UserController::class, 'profil'])->name('profil');
    Route::post('/profil', [UserController::class, 'profilUpdate'])->name('profil.update');
    Route::get('/photos', [PhotoController::class, 'index'])->name('photo.list');
    Route::get('/photos-create', [PhotoController::class, 'create'])->name('photo.create');
    Route::post('/photos', [PhotoController::class, 'store'])->name('photo.store');
    Route::get('/photos/:{id}', [PhotoController::class, 'detail'])->name('photo.detail');
    Route::put('/photos/:{id}', [PhotoController::class, 'update'])->name('photo.update');
    Route::delete('/photos/:{id}', [PhotoController::class, 'delete'])->name('photo.delete');
    Route::post('/photos/:{id}/like', [PhotoController::class, 'like'])->name('photo.like');
    Route::post('/photos/:{id}/unlike', [PhotoController::class, 'unlike'])->name('photo.unlike');
});