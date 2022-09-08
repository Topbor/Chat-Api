<?php

use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use \App\Events\NewMessage;

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
})->name('home');

Auth::routes(['register' => false]);

Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');

Route::get('chat', function () {
    broadcast(new NewMessage('sadf', '1', ''));
});

