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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//前台用户
Route::group(['prefix' => '', 'namespace' => 'Auth'], function ($router) {

});

//后台路由
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function ($router) {
    $router->get('login', 'LoginController@showLoginForm')->name('admin.login');
    $router->post('login', 'LoginController@login');

    $router->get('index', 'AdminController@index');

    $router->get('dateset', 'AdminController@dateset');
    $router->post('getDateEvent', 'AdminController@getDateEvent');
    $router->post('setDateEvent', 'AdminController@setDateEvent');
    $router->post('delDateEvent', 'AdminController@delDateEvent');
    $router->post('setSummerTime', 'AdminController@setSummerTime');
    $router->post('setWinterTime', 'AdminController@setWinterTime');
});


