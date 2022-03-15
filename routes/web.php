<?php

use Illuminate\Support\Facades\Route;

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
    // return view('welcome');
});
Route::get('/','App\Http\Controllers\Admin\LoginController@index');
Route::group(['prefix' => 'admin'], function() {
    // $logInUserData = logInUserData();
    Route::get('/','App\Http\Controllers\Admin\LoginController@index');
    Route::get('/logout','App\Http\Controllers\Admin\LoginController@logout')->name('admin-logout');
    // login
    Route::get('/login','App\Http\Controllers\Admin\LoginController@index')->name('admin-login');
    Route::post('/proccess/login','App\Http\Controllers\Admin\LoginController@loginProccess')->name('admin-login-proccess');
    // register
    Route::get('/register','App\Http\Controllers\Admin\RegisterController@index')->name('admin-register');
    Route::get('/active/user/account/{id}','App\Http\Controllers\Admin\RegisterController@activeUserAccount')->name('admin-active-account');
    // forgot password
    Route::get('/forgot/password','App\Http\Controllers\Admin\ForgotPasswordController@index')->name('admin-forgot');
    Route::post('/forgot/password/send/mail','App\Http\Controllers\Admin\ForgotPasswordController@sendMailToUser')->name('admin-forgot-send-mail');
    Route::get('/forgot/password/newpassword/{token}','App\Http\Controllers\Admin\ForgotPasswordController@newPasswordView')->name('admin-new-password-view');
    Route::post('/setnew/password','App\Http\Controllers\Admin\ForgotPasswordController@setNewPassword')->name('admin-set-new-password');


    // after login
    Route::get('/dashboard','App\Http\Controllers\Admin\DashboardController@index')->name('admin-dashboard');

    // deployment
    Route::get('/deployment','App\Http\Controllers\Admin\DeploymentController@index')->name('admin-deployment');
    Route::any('/deployment/dataTable','App\Http\Controllers\Admin\DeploymentController@deploymentDataTable')->name('admin-deployment-datatable');
    Route::post('/insert/deployment/db','App\Http\Controllers\Admin\DeploymentController@deploymentInsert')->name('admin-deployment-insert-db');
    Route::post('/delete/deployment/db','App\Http\Controllers\Admin\DeploymentController@deploymentDelete')->name('admin-deployment-delete-db');
    Route::post('/deployment/edit','App\Http\Controllers\Admin\DeploymentController@deploymentEdit')->name('admin-deployment-edit');
    Route::post('/change/status/info','App\Http\Controllers\Admin\DeploymentController@changeStatusInfoAlert')->name('admin-deployment-change-status-info-alert');
    
    // ManageUsersController  user email exist or not
    Route::get('/user/email/exist/ornot','App\Http\Controllers\Admin\ManageUsersController@emailExistOrNot')->name('admin-users-email-exist-ornot');

    //privacyPolicy
    Route::get('/page/{cms_slug}','App\Http\Controllers\Admin\CmsPagePreviewController@index')->name('privacyPolicy');
    Route::get('/term','App\Http\Controllers\Admin\CmsPagePreviewController@term')->name('term');

    
    // only user Admin access

    if(isset($_COOKIE['is_admin']) && $_COOKIE['is_admin'] != '' && $_COOKIE['is_admin'] == 1){
        
        // settings
        Route::get('/settings','App\Http\Controllers\Admin\SettingController@index')->name('admin-setting');
        Route::post('/save/settings','App\Http\Controllers\Admin\SettingController@saveSettings')->name('admin-save-setting');

        // Manage users
        Route::get('/manage/users','App\Http\Controllers\Admin\ManageUsersController@index')->name('admin-manage-users');
        Route::post('/manage/users/save','App\Http\Controllers\Admin\ManageUsersController@manageUsersSave')->name('admin-manage-users-save');
        Route::post('/manage/users/dataTable','App\Http\Controllers\Admin\ManageUsersController@manageUsersDataTable')->name('admin-manage-users-datatable');
        Route::post('/manage/users/edit','App\Http\Controllers\Admin\ManageUsersController@manageUsersEdit')->name('admin-manage-users-edit');
        Route::post('/manage/users/delete','App\Http\Controllers\Admin\ManageUsersController@manageUsersDelete')->name('admin-manage-users-delete');

        // Manage users
        Route::get('/whitelist/ip','App\Http\Controllers\Admin\WhitelistIpController@index')->name('admin-whitelist-ip');
        Route::post('/whitelist/ip/save','App\Http\Controllers\Admin\WhitelistIpController@whitelistIpSave')->name('admin-whitelist-ip-save');
        Route::post('/whitelist/ip/dataTable','App\Http\Controllers\Admin\WhitelistIpController@whitelistIpDataTable')->name('admin-whitelist-ip-datatable');
        Route::post('/whitelist/ip/edit','App\Http\Controllers\Admin\WhitelistIpController@whitelistIpEdit')->name('admin-whitelist-ip-edit');
        Route::post('/whitelist/ip/delete','App\Http\Controllers\Admin\WhitelistIpController@whitelistIpDelete')->name('admin-whitelist-ip-delete');

         // cms
         Route::get('/view/cms','App\Http\Controllers\Admin\CmsController@index')->name('admin-cms');
         Route::post('/cms/add','App\Http\Controllers\Admin\CmsController@addCms')->name('admin-cms-add');
         Route::post('/cms/datatable','App\Http\Controllers\Admin\CmsController@cmsDatatable')->name('admin-cms-datatable');
         Route::post('/cms/delete','App\Http\Controllers\Admin\CmsController@deleteCmsData')->name('admin-cms-delete');
         Route::post('/cms/edit','App\Http\Controllers\Admin\CmsController@editCmsData')->name('admin-cms-edit');
         Route::any('/cms/checkslug','App\Http\Controllers\Admin\CmsController@checkSlug')->name('admin-cms-checkslug');
    }
});


