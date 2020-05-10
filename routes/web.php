<?php

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

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/add-event', function () {
    return view('add');
})->name('add-event');


// Auth::routes(['register' => false, 'confirm' => false]);

Route::feeds();

Route::get('/calendar/{id}', 'CalendarController')->name('calendar');
Route::get('/{url}', 'StaticTextController')->where('url', '.*')->name('page');

