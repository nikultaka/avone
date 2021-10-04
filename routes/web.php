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
    Route::get('/login','App\Http\Controllers\Admin\LoginController@index')->name('admin-login');
    Route::get('/logout','App\Http\Controllers\Admin\LoginController@logout')->name('admin-logout');
    Route::post('/proccess/login','App\Http\Controllers\Admin\LoginController@loginProccess')->name('admin-login-proccess');
    Route::get('/register','App\Http\Controllers\Admin\RegisterController@index')->name('admin-register');

    // after login
    Route::get('/dashboard','App\Http\Controllers\Admin\DashboardController@index')->name('admin-dashboard');

    // deployment
    Route::get('/deployment','App\Http\Controllers\Admin\DeploymentController@index')->name('admin-deployment');
    Route::get('/deployment/dataTable','App\Http\Controllers\Admin\DeploymentController@deploymentDataTable')->name('admin-deployment-datatable');
    Route::post('/deployment/edit','App\Http\Controllers\Admin\DeploymentController@deploymentEdit')->name('admin-deployment-edit');
    Route::post('/change/status/info','App\Http\Controllers\Admin\DeploymentController@changeStatusInfoAlert')->name('admin-deployment-change-status-info-alert');
    

    // settings
    Route::get('/settings','App\Http\Controllers\Admin\SettingController@index')->name('admin-setting');
    Route::post('/save/settings','App\Http\Controllers\Admin\SettingController@saveSettings')->name('admin-save-setting');

    // if($logInUserData['is_admin'] == 1){
        // Manage users
        Route::get('/manage/users','App\Http\Controllers\Admin\ManageUsersController@index')->name('admin-manage-users');
        Route::post('/manage/users/save','App\Http\Controllers\Admin\ManageUsersController@manageUsersSave')->name('admin-manage-users-save');
        Route::get('/user/email/exist/ornot','App\Http\Controllers\Admin\ManageUsersController@emailExistOrNot')->name('admin-users-email-exist-ornot');
        Route::post('/manage/users/dataTable','App\Http\Controllers\Admin\ManageUsersController@manageUsersDataTable')->name('admin-manage-users-datatable');
        Route::post('/manage/users/edit','App\Http\Controllers\Admin\ManageUsersController@manageUsersEdit')->name('admin-manage-users-edit');
        Route::post('/manage/users/delete','App\Http\Controllers\Admin\ManageUsersController@manageUsersDelete')->name('admin-manage-users-delete');
    // }
    
});


