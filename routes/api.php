<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/posts', 'PostController@index');
Route::get('/posts/{post}', 'PostController@show');

Route::post('/register', 'Auth\RegisterController@register');

Route::post('/login', 'Auth\LoginController@login')->name('login');

Route::post('/logout', 'Auth\LoginController@logout');
Route::post('/token/refresh', 'Auth\LoginController@refresh');
Route::post('/add-mark', 'MapController@create');

Route::post('/user/profile/update', 'ProfileController@update')->middleware('auth:api');

Route::post('/sendMessage', 'MessageController@sendMessage')->middleware('auth:api');

Route::post('/message', 'MessageController@messages')->middleware('auth:api');
Route::post('/message/{user_id}', 'MessageController@show')->middleware('auth:api');

Route::get('/show-mark', 'MapController@show');
Route::get('/show-mark/{markerId}', 'MapController@showMarker');
Route::get('/show-comments/{markerId}', 'CommentController@showComments');

Route::post('/addComments','CommentController@addComments')->middleware('auth:api');
Route::post('/add-favorite/{markerId}','FavoriteController@addFavorite')->middleware('auth:api');
Route::post('/is-favorited/{markerId}','FavoriteController@isFavorited')->middleware('auth:api');
Route::post('/show-favorite','FavoriteController@showFavorite')->middleware('auth:api');
Route::post('/my-markers','MapController@showMyMarkers')->middleware('auth:api');
Route::post('/my-comments','CommentController@showMyComments')->middleware('auth:api');

Route::post('/avatar','UsersController@changAvatar')->middleware('auth:api');

