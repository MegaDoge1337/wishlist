<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\WishesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/auth/login', [LoginController::class, 'login'])->name('auth.login');
Route::middleware('auth:sanctum')->post('/auth/logout', [LoginController::class, 'logout'])->name('auth.logout');

Route::post('/auth/register', [RegisterController::class, 'register'])->name('auth.register');

Route::middleware('auth:sanctum')->get('/auth/userinfo', function (Request $request) { return $request->user(); })->name('auth.userinfo');

Route::middleware('auth:sanctum')->get('/wishes/storage/all', [WishesController::class, 'all'])->name('wishes.storage.all');
Route::middleware('auth:sanctum')->get('/wishes/storage/single/{id}', [WishesController::class, 'single'])->name('wishes.storage.single');
Route::middleware('auth:sanctum')->get('/wishes/storage/self', [WishesController::class, 'self'])->name('wishes.storage.self');
Route::middleware('auth:sanctum')->get('/wishes/archive/self', [WishesController::class, 'selfArchive'])->name('wishes.storage.archive');

Route::middleware('auth:sanctum')->post('/wishes/actions/store', [WishesController::class, 'store'])->name('wishes.actions.store');
Route::middleware('auth:sanctum')->put('/wishes/actions/edit/{id}', [WishesController::class, 'edit'])->name('wishes.actions.edit');
Route::middleware('auth:sanctum')->delete('/wishes/actions/archive/{id}', [WishesController::class, 'archive'])->name('wishes.actions.delete');

Route::get('/check_connection', function () {
    return 'successfully connected';
});
