<?php

Route::get('getRoom/{room?}', "EnxRtc\RoomController@getRoom");
Route::post('createRoom/', "EnxRtc\RoomController@createRoom");
Route::post('createToken/', "EnxRtc\RoomController@createToken");
