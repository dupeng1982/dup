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
    //登陆模块
    $router->get('login', 'LoginController@showLoginForm')->name('admin.login');
    $router->post('login', 'LoginController@login');
    $router->match(['get', 'post'], 'logout', 'LoginController@logout')->name('admin.logout');
    //首页
    $router->get('index', 'AdminController@index');
    $router->post('adminSignIn', 'AdminController@adminSignIn');
    $router->post('adminSignOut', 'AdminController@adminSignOut');
    $router->post('uploadAvatar', 'AdminController@uploadAvatar');
    $router->post('changePassword', 'AdminController@changePassword');
    //我的考勤
    $router->get('mysign', 'AdminController@mysign');
    $router->post('adminAskForLeave', 'AdminController@adminAskForLeave');
    $router->post('adminSignApply', 'AdminController@adminSignApply');
    $router->post('getMySign', 'AdminController@getMySign');
    //考勤设置
    $router->get('dateset', 'AdminController@dateset');
    $router->post('getDateEvent', 'AdminController@getDateEvent');
    $router->post('setDateEvent', 'AdminController@setDateEvent');
    $router->post('delDateEvent', 'AdminController@delDateEvent');
    $router->post('setSummerTime', 'AdminController@setSummerTime');
    $router->post('setWinterTime', 'AdminController@setWinterTime');
    //角色管理
    $router->get('roleset', 'AdminController@roleset');
    $router->post('getRoleList', 'AdminController@getRoleList');
    $router->post('delRole', 'AdminController@delRole');
    $router->post('addRole', 'AdminController@addRole');
    $router->post('editRole', 'AdminController@editRole');
    $router->post('getAdminPerms', 'AdminController@getAdminPerms');
    $router->post('allotPrems', 'AdminController@allotPrems');
    //补签审核
    $router->get('signapplylist', 'AdminController@signapplylist');
    $router->post('getSignApplyList', 'AdminController@getSignApplyList');
    $router->post('checkSignApply', 'AdminController@checkSignApply');
    $router->post('checkMoreSignApply', 'AdminController@checkMoreSignApply');
    //请假审核
    $router->get('leaveapplylist', 'AdminController@leaveapplylist');
    $router->post('getLeaveApplyList', 'AdminController@getLeaveApplyList');
    $router->post('checkLeaveApply', 'AdminController@checkLeaveApply');
    $router->post('checkMoreLeaveApply', 'AdminController@checkMoreLeaveApply');
    //考勤统计
    $router->get('signandleavestatistics', 'AdminController@signandleavestatistics');
    $router->post('getMonthAttendanceStatistics', 'AdminController@getMonthAttendanceStatistics');
    $router->any('importMonthAttendanceStatistics', 'AdminController@importMonthAttendanceStatistics');
    //考勤汇总
    $router->get('signandleavesummary', 'AdminController@signandleavesummary');
    $router->post('getMonthAttendanceSummary', 'AdminController@getMonthAttendanceSummary');
    $router->any('importMonthAttendanceSummary', 'AdminController@importMonthAttendanceSummary');
    $router->post('getAdminAttendanceSummary', 'AdminController@getAdminAttendanceSummary');
    //我的信息
    $router->get('myinfo', 'AdminController@myinfo');
    $router->get('getMyAvatar', 'AdminController@getMyAvatar');
    $router->post('getMyFamilyInfo', 'AdminController@getMyFamilyInfo');
    $router->post('getMyCertificateInfo', 'AdminController@getMyCertificateInfo');
    $router->post('getMyAttachmentInfo', 'AdminController@getMyAttachmentInfo');
    $router->get('showMyPic', 'AdminController@showMyPic');
    $router->get('downLoadMyPic', 'AdminController@downLoadMyPic');
    //人员列表
    $router->get('adminmanagelist', 'AdminController@adminmanagelist');
    $router->post('getAdminInfoList', 'AdminController@getAdminInfoList');
    $router->post('addAdminFamily', 'AdminController@addAdminFamily');
    $router->post('getAdminFamily', 'AdminController@getAdminFamily');
    $router->post('getAdminFamilyInfo', 'AdminController@getAdminFamilyInfo');
    $router->post('addAdminFamilyInfo', 'AdminController@addAdminFamilyInfo');
    $router->post('delAdminFamily', 'AdminController@delAdminFamily');
    $router->post('addAdminCertificate', 'AdminController@addAdminCertificate');
    $router->post('getAdminCertificate', 'AdminController@getAdminCertificate');
    $router->post('addAdminCertificateInfo', 'AdminController@addAdminCertificateInfo');
    $router->post('getAdminCertificateInfo', 'AdminController@getAdminCertificateInfo');
    $router->post('delAdminCertificate', 'AdminController@delAdminCertificate');
    $router->post('addAdmininfoPic', 'AdminController@addAdmininfoPic');
    $router->post('addAdmininfoPicInfo', 'AdminController@addAdmininfoPicInfo');
    $router->post('getAdmininfoPic', 'AdminController@getAdmininfoPic');
    $router->post('getAdmininfoPicInfo', 'AdminController@getAdmininfoPicInfo');
    $router->get('showAdmininfoPic', 'AdminController@showAdmininfoPic');
    $router->get('downLoadAdmininfoPic', 'AdminController@downLoadAdmininfoPic');
    $router->post('delAdmininfoPic', 'AdminController@delAdmininfoPic');
    $router->post('addAdminInfo', 'AdminController@addAdminInfo');
    $router->post('editAdminInfo', 'AdminController@editAdminInfo');
    $router->post('delAdmin', 'AdminController@delAdmin');
    $router->get('getAdminAvatar/{dir?}/{img?}', 'AdminController@getAdminAvatar');
    $router->post('resetAdminPassword', 'AdminController@resetAdminPassword');
    //合同管理
    $router->get('contractmanage', 'AdminController@contractmanage');
    //造价项目管理
    $router->get('costprojectmanage', 'AdminController@costprojectmanage');
    //造价项目审核
    $router->get('costprojectcheck', 'AdminController@costprojectcheck');
    //工程单位管理
    $router->get('projectunitmanage', 'AdminController@projectunitmanage');
    $router->post('addProjectUnit', 'AdminController@addProjectUnit');
    $router->post('editProjectUnit', 'AdminController@editProjectUnit');
    $router->post('delProjectUnit', 'AdminController@delProjectUnit');
    $router->post('getProjectUnitList', 'AdminController@getProjectUnitList');
    //我的提成
    $router->get('myextract', 'AdminController@myextract');
    //财务管理
    $router->get('financemanage', 'AdminController@financemanage');

    //上传大文件
    Route::any('aetherupload/preprocess', '\AetherUpload\UploadHandler@preprocess');
    Route::post('aetherupload/uploading', '\AetherUpload\UploadHandler@saveChunk');
    //预览大文件
    Route::get('aetherupload/display/{group}/{subDir}/{resourceName}', '\AetherUpload\ResourceHandler@displayResource');
    //下载大文件
    Route::get('aetherupload/download/{group}/{subDir}/{resourceName}/{newName}', '\AetherUpload\ResourceHandler@downloadResource');

    //测试
    $router->any('test', 'AdminController@getProjectUnitList');
});


