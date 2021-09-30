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
    Route::get('/','App\Http\Controllers\Admin\LoginController@index');
    Route::get('/login','App\Http\Controllers\Admin\LoginController@index')->name('admin-login');
    Route::post('/proccess/login','App\Http\Controllers\Admin\LoginController@loginProccess')->name('admin-login-proccess');
    Route::get('/register','App\Http\Controllers\Admin\RegisterController@index')->name('admin-register');

    
    // after login
    Route::get('/dashboard','App\Http\Controllers\Admin\DashboardController@index')->name('admin-dashboard');

    // deployment
    Route::get('/deployment','App\Http\Controllers\Admin\DeploymentController@index')->name('admin-deployment');
    Route::get('/deployment/dataTable','App\Http\Controllers\Admin\DeploymentController@deploymentDataTable')->name('admin-deployment-datatable');
    Route::post('/deployment/edit','App\Http\Controllers\Admin\DeploymentController@deploymentEdit')->name('admin-deployment-edit');

});


