<?php

use App\Http\Controllers\ScoreUpdateController;
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

// Route::get('/', function () {
//     return view('ScoreBoard');
// });
Route::get('/', function () {
    return view('ScoreBoard');
});
Route::get('/update', function () {
    return view('ScoreUpdate');
});

Route::post('/push-score', [ScoreUpdateController::class, 'pushScoreValue']);
