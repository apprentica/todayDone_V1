<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\ProfileController;
use GuzzleHttp\Middleware;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});


Route::get('/done', 'App\Http\Controllers\TodoController@done')->name('todo.done');

Route::resource('todo', TodoController::class)
    ->only(['index','create','store','show','edit','update','destroy'])
    ->middleware(['auth','verified']);

Route::get('/dashboard', function () {
    return view('auth.login');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
