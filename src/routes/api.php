<?php

Route::group(['middleware' => ['api'], 'prefix' => 'api'], function () {
    Route::get('galleries/images', ['uses' => 'ApiController@images', 'as' => 'api.galleries.images']);
});