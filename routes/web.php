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

Route::get('/', 'PostsController@index')->name('root');

Auth::routes(['verify' => true]);

//Route::resource('users', 'UsersController', ['only' => ['show', 'edit', 'update']]);

// 文章
Route::resource('posts', 'PostsController',  ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('posts/{post}/{slug?}', 'PostsController@show')->name('posts.show');
Route::post('posts/upload_post_image', 'PostsController@uploadPostImage')->name('posts.upload_post_image');

// 评论
Route::post('comments/store', 'CommentsController@store')->name('comments.store');
Route::post('replies/store', 'CommentsController@replyStore')->name('replies.store');
Route::delete('comments/{comment}', 'CommentsController@destroy')->name('comments.destroy');

// 分类、标签、专题、归档
Route::get('categories/{category}', 'CategoriesController@show')->name('categories.show');
Route::get('tags/{tag}', 'TagsController@show')->name('tags.show');
Route::get('topics', 'TopicsController@index')->name('topics.index');
Route::get('topics/{topic}', 'TopicsController@show')->name('topics.show');
Route::get('archives/{year_month}', 'PostsController@archiveShow')->where('year_month', '\d{4}-\d{2}')->name('archives.show');

// 第三方登录
Route::prefix('socials/{social_type}')
    ->name('socials.authorizations.')
    ->where(['social_type', 'github'])
    ->group(function() {
    Route::get('redirect', 'AuthorizationsController@redirect')->name('store');
    Route::get('callback', 'AuthorizationsController@callback')->name('callback');
});

