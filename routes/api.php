<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BrAccountController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\TransactionController;


    Route::prefix('transactions')->group(function () {
        Route::post('/', [TransactionController::class, 'createApi']);
        Route::put('/{id}', [TransactionController::class, 'updateApi']);
        Route::delete('/{id}', [TransactionController::class, 'deleteApi']);
        Route::get('/{id}', [TransactionController::class, 'getTransactionById']);
    });
    Route::prefix('contributions')->group(function () {
        Route::post('/', [ContributionController::class, 'createApi']);
        Route::put('/{id}', [ContributionController::class, 'updateApi']);
        Route::delete('/{id}', [ContributionController::class, 'deleteApi']);
        Route::get('/{id}', [ContributionController::class, 'getContributionById']);
    });
    Route::prefix('cards')->group(function () {
        Route::post('/', [CardController::class, 'createApi']);
        Route::put('/{id}', [CardController::class, 'updateApi']);
        Route::delete('/{id}', [CardController::class, 'deleteApi']);
        Route::get('/{id}', [CardController::class, 'getCardById']);
    });
    
    Route::prefix('clients')->group(function () {
        Route::post('/', [ClientController::class, 'createApi']);
        Route::put('/{id}', [ClientController::class, 'updateApi']);
        Route::delete('/{id}', [ClientController::class, 'deleteApi']);
        Route::get('/{id}', [ClientController::class, 'getClientById']);
    });



Route::middleware(['api'])->group(function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});
Route::get('/transactions/{card_number}', [TransactionController::class, 'getTransactionsByCardNumber']);
    Route::post('/transaction', [TransactionController::class, 'makeTransaction']);

Route::prefix('br-accounts')->group(function () {
    Route::post('/', [BrAccountController::class, 'createApi']);
    Route::put('/{id}', [BrAccountController::class, 'updateApi']);
    Route::delete('/{id}', [BrAccountController::class, 'deleteApi']);
    Route::get('/{id}', [BrAccountController::class, 'searchById']);
});

