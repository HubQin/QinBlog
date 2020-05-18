<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->get('users', 'UsersController@index');

    $router->resource('categories', CategoriesController::class);
    $router->resource('tags', TagsController::class);
    $router->resource('posts', PostsController::class);
    $router->resource('comments', CommentsController::class);

    $router->post('comments/review', 'CommentsController@review');

    $router->resource('columns', ColumnsController::class);

    $router->get('settings', 'SettingsController@settings')->name('admin.settings');

    $router->resource('links', LinksController::class);


});
