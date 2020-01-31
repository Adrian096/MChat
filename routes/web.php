<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function() {
    return view('welcome');
})->name('welcome');

Route::post('/room/create', 'RoomController@createRoom')->middleware('auth')->name('room-create');
Route::post('/room/authorizeUser', 'RoomController@authorizeUser')->middleware('auth')->name('room-auth');
Route::get('/profile/settings', function(){
    return view('settings');
})->middleware('auth')->name('settings');
Route::get('/profile/fetchFavorites', 'RoomController@fetchFavorites')->middleware('auth')->name('fetch-favorites');
Route::post('/profile/settings', 'SettingsController@update')->middleware('auth')->name('save-settings');
Route::post('room/{id}/favorites', 'RoomController@addFavorite')->middleware('auth')->name('favorite');
Route::middleware('room.auth')->group( function () {

    Route::get('/room/{id}', function(){
        return view('rooms.room');
    })->name('room');
    Route::post('/room/{id}/sendMessage', 'RoomController@sendMessage')->name('send-message');
    Route::post('room/{id}/fetchMessages', 'RoomController@fetchMessages')->name('fetch-messages');
});
