<?php

use App\Http\Controllers\ListdestinationController;
use App\Http\Controllers\ListuserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('dashboard.index');
// })->middleware(['auth', 'verified']);
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/manage-user', function () {
        return view('manage-user.index');
    });
    Route::get('/manage-destination', function () {
        return view('manage-destination.index');
    });
    Route::controller(ListuserController::class)->group(function () {
        foreach (['index', 'show', 'create', 'update', 'delete', 'getData', 'savesuspend', 'deleteUser'] as $key => $value) {
            Route::post('/listuser/' . $value, $value);
        }
    });
    Route::controller(ListdestinationController::class)->group(function () {
        foreach (['index', 'show', 'create', 'update', 'delete', 'getData', 'savesuspend', 'deleteUser'] as $key => $value) {
            Route::post('/listdest/' . $value, $value);
        }
    });
});

require __DIR__ . '/auth.php';
