<?php

Route::post('/store', 'ObjectAppearanceController@store');
Route::post('/camera', 'ObjectAppearanceController@storeCamera');
Route::post('/sync', 'ObjectAppearanceController@sync');

