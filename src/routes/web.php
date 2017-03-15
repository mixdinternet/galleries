<?php

Route::group(['middleware' => ['web'], 'prefix' => config('admin.url')], function () {

    Route::group(['middleware' => 'auth.admin'], function () {
        Route::post('galleries/upload', ['uses' => 'GalleriesAdminController@upload', 'as' => 'admin.galleries.upload']);
        Route::post('galleries/sort', ['uses' => 'GalleriesAdminController@sort', 'as' => 'admin.galleries.sort']);
        Route::post('galleries/destroy', ['uses' => 'GalleriesAdminController@destroy', 'as' => 'admin.galleries.destroy']);
        Route::post('galleries/update', ['uses' => 'GalleriesAdminController@update', 'as' => 'admin.galleries.update']);
    });

});