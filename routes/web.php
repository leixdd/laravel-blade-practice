<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



Route::group(['prefix' => 'account'], function () {
    Route::get('/', [AccountController::class, 'index'])->name('account');
    Route::post('/save', [AccountController::class, 'save'])->name('account.save');
    //Route::get('/save', [AccountController::class, 'save'])->name('account.save');
});

Route::group(['prefix' => 'requests'], function () {
    Route::get('/', [RequestController::class, 'index'])->name('requests');
    Route::get('/new', [RequestController::class, 'create'])->name('requests.create');
    Route::post('/save', [RequestController::class, 'save'])->name('requests.save');
});

require __DIR__.'/auth.php';
