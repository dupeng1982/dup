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
    $router->match(['get', 'post'], 'logout', 'LoginController@logout')->name('admin.logout');

    $router->get('index', 'AdminController@index');
    $router->post('adminSignIn', 'AdminController@adminSignIn');
    $router->post('adminSignOut', 'AdminController@adminSignOut');

    $router->get('mysign', 'AdminController@mysign');
    $router->post('adminAskForLeave', 'AdminController@adminAskForLeave');
    $router->post('adminSignApply', 'AdminController@adminSignApply');
    $router->post('getMySign', 'AdminController@getMySign');

    $router->get('dateset', 'AdminController@dateset');
    $router->post('getDateEvent', 'AdminController@getDateEvent');
    $router->post('setDateEvent', 'AdminController@setDateEvent');
    $router->post('delDateEvent', 'AdminController@delDateEvent');
    $router->post('setSummerTime', 'AdminController@setSummerTime');
    $router->post('setWinterTime', 'AdminController@setWinterTime');

    $router->get('roleset', 'AdminController@roleset');
    $router->any('getRoleList', 'AdminController@getRoleList');
    $router->post('delRole', 'AdminController@delRole');
    $router->post('addRole', 'AdminController@addRole');
    $router->post('editRole', 'AdminController@editRole');
    $router->post('getAdminPerms', 'AdminController@getAdminPerms');
    $router->post('allotPrems', 'AdminController@allotPrems');

    $router->get('signapplylist', 'AdminController@signapplylist');
    $router->post('getSignApplyList', 'AdminController@getSignApplyList');
    $router->post('checkSignApply', 'AdminController@checkSignApply');
    $router->post('checkMoreSignApply', 'AdminController@checkMoreSignApply');

    $router->get('leaveapplylist', 'AdminController@leaveapplylist');
    $router->post('getLeaveApplyList', 'AdminController@getLeaveApplyList');
    $router->post('checkLeaveApply', 'AdminController@checkLeaveApply');
    $router->post('checkMoreLeaveApply', 'AdminController@checkMoreLeaveApply');

    $router->get('signandleavestatistics', 'AdminController@SignAndLeaveStatistics');

    $router->get('signandleavesummary', 'AdminController@SignAndLeaveSummary');

    $router->any('test', 'AdminController@getMonthAttendanceStatistics');
});


