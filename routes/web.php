<?php

Route::get('/', 'ItemsController@getAll');
Route::get('/item/{item}', 'ItemsController@getOne');


// Authorization and Registration Views
Route::get('/login', 'UserController@getLoginPage');
Route::get('/registration', 'UserController@getRegistrationPage');
Route::get('/admin', 'UserController@getAdminPage');
Route::get('/basket', 'BasketController@getBasketPage');
Route::get('/history', 'UserController@getHistoryPage');
Route::get('/admin/history', 'UserController@getAdminHistoryPage');

// Authorization and Registration Controllers
Route::post('auth/login', ['as' => 'login', 'uses' => 'UserController@makeLogin']);
Route::post('auth/register', ['as' => 'registration', 'uses' => 'UserController@makeRegistration']);
Route::post('auth/logout', ['as' => 'logout', 'uses' => 'UserController@deleteUser']);
Route::post('admin/add', ['as' => 'admin', 'uses' => 'UserController@addElement']);
Route::delete('admin/delete/{id}', ['as' => 'admin-remove', 'uses' => 'UserController@removeElement']);

// Comments
Route::post('comments/add', ['as' => 'comments-add', 'uses' => 'CommentsController@addComments']);

Route::post('basket/add/{id}', ['as' => 'user-add', 'uses' => 'BasketController@addToBasket']);
Route::delete('basket/delete/{id}', ['as' => 'user-remove', 'uses' => 'BasketController@removeElement']);

// Users
Route::post('user/change', ['as' => 'change-password', 'uses' => 'UserController@changePassword']);
Route::post('user/take', ['as' => 'take-all', 'uses' => 'BasketController@takeAll']);