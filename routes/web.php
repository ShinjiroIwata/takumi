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
Route::get('/admin', [LineMessagingController::class, 'index']);
Route::post('/admin/send-line-notification', [LineMessagingController::class, 'sendNotification'])->name('admin.send');


// ログインしたユーザーのみ
Route::middleware(['auth'])->group(function () {
    Route::get('/ancate1', [AncateController::class, 'ancate1'])->name('ancate.index');
    Route::post('/ancate1/store', [AncateController::class, 'ancate1store'])->name('ancate.store');
    Route::get('/ancate2', [AncateController::class, 'ancate2'])->name('ancate2.index');
    Route::post('/ancate2/store', [AncateController::class, 'ancate2store'])->name('ancate2.store');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
