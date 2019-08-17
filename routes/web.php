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

///////////////// Threads & Channels & Subscriptions /////////////
Route::resource('threads', 'ThreadsController', [
    'except' => ['show', 'index', 'destroy']
]);
Route::get('threads/{channel}/{thread}', 'ThreadsController@show')
    ->name('threads.show');
Route::get('threads/{channel?}', 'ThreadsController@index')
    ->name('threads.index');
Route::delete('threads/{channel}/{thread}', 'ThreadsController@destroy')
    ->name('threads.destroy');
Route::post('threads/{channel?}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')
    ->name('threads.subscribe');
Route::delete('threads/{channel?}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')
    ->name('threads.unsubscribe');

/////////////// Favorites ////////////////////////
Route::post('replies/{reply}/favorites', 'FavoritesController@store')
    ->name('replies.favorites.store');
Route::delete('replies/{reply}/favorites', 'FavoritesController@destroy')
    ->name('replies.favorites.delete');

/////////////// Replies /////////////////////////
Route::delete('replies/{reply}', 'RepliesController@destroy')
    ->name('reply.destroy');
Route::patch('replies/{reply}', 'RepliesController@update')
    ->name('reply.update');
Route::get('threads/{channel?}/{thread}/replies', 'RepliesController@index')
    ->name('threads.replies');
Route::post('threads/{channel?}/{thread}/replies', 'RepliesController@store')
    ->name('threads.reply.store');

/////////// Profiles ////////////////////////////
Route::get('profiles/{user}', 'ProfilesController@show')
    ->name('profile');

////////////// Authentication //////////////////
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
