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


///////////////// Channel ///////////////////////
//Route::get('threads/{channel}', [
//    'as'   => 'threads.channel.index',
//    'uses' => 'ChannelController@index'
//]);

///////////////// Threads ///////////////////////
//Route::get('threads/{channel}/create', [
//    'as'   => 'threads.create',
//    'uses' => 'ThreadsController@create'
//]);
//Route::post('threads/{channel}', [
//    'as'   => 'threads.store',
//    'uses' => 'ThreadsController@store'
//]);
Route::get('threads/{channel}/{thread}', [
    'as'   => 'threads.show',
    'uses' => 'ThreadsController@show'
]);
Route::resource('threads', 'ThreadsController', [
    'except' => ['show']
]);

/////////////// Replies /////////////////////////
Route::get('threads/{channel}/{thread}/replies', [
    'as'  => 'threads.replies',
    'use' => 'RepliesController@show'
]);
Route::post('threads/{channel}/{thread}/replies', 'RepliesController@store')
    ->name('threads.reply.store');

////////////// Authentication //////////////////
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
