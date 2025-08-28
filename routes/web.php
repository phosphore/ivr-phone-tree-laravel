<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IvrController;

Route::get('/', function () {
    return response()->view('instructions');
});

Route::match(['GET', 'POST'], '/ivr/welcome', [IvrController::class, 'welcome'])->name('welcome');
Route::match(['GET', 'POST'], '/ivr/age-response', [IvrController::class, 'ageResponse'])->name('age-response');
Route::match(['GET', 'POST'], '/ivr/main-menu', [IvrController::class, 'mainMenu'])->name('main-menu');
Route::match(['GET', 'POST'], '/ivr/main-response', [IvrController::class, 'mainResponse'])->name('main-response');
Route::match(['GET', 'POST'], '/ivr/recording-cb', [IvrController::class, 'recordingCallback'])->name('recording-cb');

