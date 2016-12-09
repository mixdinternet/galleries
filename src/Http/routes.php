<?php

Route::group(['prefix' => 'admin'], function () {

    Route::group(['middleware' => 'auth.admin'], function () {
        Route::post('galleries/upload', ['uses' => 'GalleriesAdminController@upload', 'as' => 'admin.galleries.upload']);
        Route::post('galleries/sort', ['uses' => 'GalleriesAdminController@sort', 'as' => 'admin.galleries.sort']);
        Route::post('galleries/destroy', ['uses' => 'GalleriesAdminController@destroy', 'as' => 'admin.galleries.destroy']);
        Route::post('galleries/update', ['uses' => 'GalleriesAdminController@update', 'as' => 'admin.galleries.update']);
    });

});

Route::group(['prefix' => 'api'], function () {
    Route::get('galleries/images', ['uses' => 'ApiController@images',  'as' => 'api.galleries.images']);
});