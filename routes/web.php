<?php

use App\Http\Controllers\AncateController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LineMessagingController;
use App\Http\Controllers\LineWebhookController;
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



Route::get('/send-line-notification', [LineMessagingController::class, 'sendNotification']);
Route::post('/webhook', [LineWebhookController::class, 'webhook']);



Route::get('login', [LoginController::class, 'redirectToLine'])->name('login');
Route::get('line/callback', [LoginController::class, 'handleLineCallback']);


Route::middleware(['auth'])->group(function () {
    Route::get('/', [AncateController::class, 'index'])->name('ancate.index');
    Route::post('/', [AncateController::class, 'store'])->name('ancate.store');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
