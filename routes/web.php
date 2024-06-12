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

// LINE系
Route::get('login', [LoginController::class, 'redirectToLine'])->name('login');
Route::get('line/callback', [LoginController::class, 'handleLineCallback']);
Route::post('/webhook', [LineWebhookController::class, 'webhook']);


// 管理者のみ実行可能
Route::get('/send-line-notification', [LineMessagingController::class, 'sendNotification']);


// ログインしたユーザーのみ
Route::middleware(['auth'])->group(function () {
    Route::get('/', [AncateController::class, 'index'])->name('ancate.index');
    Route::post('/store', [AncateController::class, 'store'])->name('ancate.store');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
