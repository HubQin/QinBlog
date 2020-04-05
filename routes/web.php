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

Route::get('/', 'PagesController@root')->name('root');

Auth::routes(['verify' => true]);

//Route::resource('users', 'UsersController', ['only' => ['show', 'edit', 'update']]);

Route::resource('posts', 'PostsController',  ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);

Route::get('posts/{post}/{slug?}', 'PostsController@show')->name('posts.show');

Route::post('posts/upload_post_image', 'PostsController@uploadPostImage')->name('posts.upload_post_image');

Route::post('comments/store', 'CommentsController@store')->name('comments.store');
Route::post('replies/store', 'CommentsController@replyStore')->name('replies.store');
Route::delete('comments/{comment}', 'CommentsController@destroy')->name('comments.destroy');

Route::get('/home', 'HomeController@index')->name('home');
