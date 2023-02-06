<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

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

Route::get('/', 'App\Http\Controllers\HomeController@home')->name('home');

Route::get('/about', 'App\Http\Controllers\AboutController@about')->name('about');

Route::get('/news', 'App\Http\Controllers\NewsController@news')->name('news');

Route::get('/submit','App\Http\Controllers\UsersController@submit')->name('submit');
Route::post('/submit/create', 'App\Http\Controllers\UsersController@create')->name('submit.create');

Route::get('/singin', 'App\Http\Controllers\UsersController@singin')->name('singin');
Route::post('/singin/login', 'App\Http\Controllers\UsersController@login')->name('singin.login');
Route::get('/logout', 'App\Http\Controllers\UsersController@logout')->name('logout')->middleware('auth');


Route::get('/useroffice', 'App\Http\Controllers\OfficeController@useroffice')->name('useroffice')->middleware('auth');
Route::get('/userhotel', 'App\Http\Controllers\UserHotelController@userhotel')->name('userhotel')->middleware('auth');
Route::get('/userrooms', 'App\Http\Controllers\UserRoomController@userrooms')->name('userrooms')->middleware('auth');

Route::get('/useroffice/edit', 'App\Http\Controllers\OfficeController@userofficeEdit')->name('useroffice.edit')->middleware('auth');
Route::patch('/useroffice/update', 'App\Http\Controllers\OfficeController@userofficeUpdate')->name('useroffice.update')->middleware('auth');
Route::post('/checkPassword', 'App\Http\Controllers\OfficeController@userofficecheckPassword')->name('checkPassword')->middleware('auth');
Route::post('/updatepassword', 'App\Http\Controllers\OfficeController@userofficeUpdatePass')->name('updatepassword')->middleware('auth');

Route::get('/userhotel/create', 'App\Http\Controllers\UserHotelController@userhotelCreate')->name('userhotel.create')->middleware('auth');
Route::post('/userhotel', 'App\Http\Controllers\UserHotelController@userhotelStore')->name('userhotel.store')->middleware('auth');
Route::get('/userhotel/{hotel}/edit', 'App\Http\Controllers\UserHotelController@userhotelEdit')->name('userhotel.edit')->middleware('auth');
Route::patch('/userhotel/{hotel}', 'App\Http\Controllers\UserHotelController@userhotelUpdate')->name('userhotel.update')->middleware('auth');
Route::delete('/userhotel/{hotel}', 'App\Http\Controllers\UserHotelController@userhotelDestroy')->name('userhotel.delete')->middleware('auth');

Route::get('/userroom/create', 'App\Http\Controllers\UserRoomController@userroomCreate')->name('userroom.create')->middleware('auth');
Route::post('/userroom', 'App\Http\Controllers\UserRoomController@userroomStore')->name('userroom.store')->middleware('auth');
Route::get('/userroom/{room}/edit', 'App\Http\Controllers\UserRoomController@userroomEdit')->name('userroom.edit')->middleware('auth');
Route::patch('/userroom/{room}', 'App\Http\Controllers\UserRoomController@userroomUpdate')->name('userroom.update')->middleware('auth');
Route::delete('/userroom/{room}', 'App\Http\Controllers\UserRoomController@userroomDestroy')->name('userroom.delete')->middleware('auth');

Route::get('/userbookedroom', 'App\Http\Controllers\UserBookedRoomController@userbookedrooms')->name('userbookedrooms')->middleware('auth');

Route::get('/seachCity', 'App\Http\Controllers\SearchController@seachCity');

Route::get('/searchHotels', 'App\Http\Controllers\SearchController@searchHotels');

Route::get('/hotel/{hotel}/{dateFrom}/{dateTo}', 'App\Http\Controllers\HotelController@show')->name('hotel.show');

Route::get('/getroominformation/{room}', 'App\Http\Controllers\RoomController@getroominformation');
Route::post('/bokingroom', 'App\Http\Controllers\RoomController@bookingRoom');

Route::get('/searchBookedRooms/{dateFrom}/{dateTo}', 'App\Http\Controllers\UserBookedRoomController@searchBookedRooms')->middleware('auth');
Route::get('/confirmOrCancelBookedRoom/{id}/{action}', 'App\Http\Controllers\UserBookedRoomController@confirmOrCancelBookedRoom')->middleware('auth');
// Route::get('/getUserRoomsForFillList', 'App\Http\Controllers\UserBookedRoomController@allUserRoom')->middleware('auth');
Route::get('/getUserRoomsForFillList', 'App\Http\Controllers\UserBookedRoomController@allUserRoomToDate')->middleware('auth');

Route::get('/dataOfBookedRoom/{room}', 'App\Http\Controllers\UserBookedRoomController@dataOfBookedRoom')->middleware('auth');
Route::post('/addNewReservation', 'App\Http\Controllers\UserBookedRoomController@addNewReservation')->middleware('auth');
Route::post('/editNewReservation', 'App\Http\Controllers\UserBookedRoomController@editNewReservation')->middleware('auth');

Route::get('/api', 'App\Http\Controllers\HomeController@apiDocument')->name('apiDocument');
