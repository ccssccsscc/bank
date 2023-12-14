<?php

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


use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BrAccountController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\TransactionController;






Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'registerWeb'])->name('register');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'loginWeb'])->name('login');
Route::post('/createaccount', [BrAccountController::class, 'createWeb'])->name('createaccount');
use App\Http\Controllers\MainController;
Route::get('/br_account', [MainController::class, 'BrAcc']);
Route::get('/Card', [MainController::class, 'cardpage']);
Route::get('/Contribution', [MainController::class, 'contributionpage']);
Route::get('/Client', [MainController::class, 'clientpage']);
Route::get('/transaction', [MainController::class, 'transaction']);
Route::get('/homeq', [MainController::class, 'Homepage']);
