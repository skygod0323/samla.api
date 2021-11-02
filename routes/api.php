<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/user/login', 'Api\UserController@login');
Route::post('/user/sendVerifyEmail', 'Api\UserController@sendVerifyEmail');
Route::get('/user/verifyMail/{confirm_code}', 'Api\UserController@verifyMail');

Route::get('/user/loadBusinessUsers', 'Api\UserController@loadBusinessUsers');

Route::post('/upload/image', 'Api\UploadController@upload');

Route::get('/uploadmanagement/getCategoryList', 'Api\UploadmanagementController@getCategoryList');
Route::get('/uploadmanagement/getImageList', 'Api\UploadmanagementController@getImageList');
Route::get('/uploadmanagement/getImage', 'Api\UploadmanagementController@getImage');

Route::get('/uploadmanagement/getModelReleaseList', 'Api\UploadmanagementController@getModelReleaseList');


Route::post('/download/checkout', 'Api\DownloadController@checkout');
Route::get('/download/checkDownload/{download_code}', 'Api\DownloadController@checkDownload');
Route::get('/download/download/{download_code}', 'Api\DownloadController@download');

Route::group(['middleware' => ['jwt.auth']], function()
{
    Route::post('/event/createEvent', 'Api\EventController@createEvent');
    Route::get('/account/getAccount', 'Api\AccountController@getAccount');

    Route::get('/account/getProfile', 'Api\AccountController@getProfile');



    ////  user management
    Route::post('/user/createAdminUser', 'Api\UsermanagementController@createAdminUser');
    Route::post('/user/updateAdminUser', 'Api\UsermanagementController@updateAdminUser');
    Route::post('/user/deleteAdminUser', 'Api\UsermanagementController@deleteAdminUser');
    
    Route::get('/user/getAdminList', 'Api\UsermanagementController@getAdminList');
    Route::get('/user/getAdminUser', 'Api\UsermanagementController@getAdminUser');


    //// upload management
    
    Route::post('/uploadmanagement/createCategory', 'Api\UploadmanagementController@createCategory');
    Route::post('/uploadmanagement/updateCategory', 'Api\UploadmanagementController@updateCategory');
    Route::post('/uploadmanagement/createImage', 'Api\UploadmanagementController@createImage');
    Route::post('/uploadmanagement/updateImage', 'Api\UploadmanagementController@updateImage');
    Route::post('/uploadmanagement/deleteImage', 'Api\UploadmanagementController@deleteImage');
    Route::post('/uploadmanagement/createModelRelease', 'Api\UploadmanagementController@createModelRelease');

    

    /// dashboard 
    Route::get('/dashboard/getDahsobardInfo', 'Api\DashboardController@getDahsobardInfo');
    
    
});
