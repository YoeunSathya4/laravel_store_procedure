<?php 
//:::::::::::::>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> User Profile
Route::group(['as' => 'profile.', 'prefix' => 'profile'], function() {
	Route::get('/', 		['as' => 'edit', 	'uses' => 'ProfileController@edit']);
	Route::post('update', 	['as' => 'update', 	'uses' => 'ProfileController@update']);
	Route::get('password', 	['as' => 'edit-password', 	'uses' => 'ProfileController@editPassword']);
	Route::post('password/update', 	['as' => 'update-password', 	'uses' => 'ProfileController@changePassword']);
	Route::get('logs', 				['as' => 'logs', 	'uses' => 'ProfileController@logs']);
});

//:::::::::::::>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> User
Route::group(['as' => 'user.',  'prefix' => 'user'], function () {
	Route::get('/', 				['as' => 'index', 			'uses' => 'UsersController@index']);
	Route::get('/{id}', 			['as' => 'edit', 			'uses' => 'UsersController@edit']);
	Route::post('/', 				['as' => 'update', 			'uses' => 'UsersController@update']);
	Route::get('/create', 			['as' => 'create', 			'uses' => 'UsersController@create']);
	Route::put('/', 				['as' => 'store', 			'uses' => 'UsersController@store']);
	Route::delete('/{id}', 			['as' => 'trash', 			'uses' => 'UsersController@destroy']);
	Route::post('/update-status', 	['as' => 'update-status', 	'uses' => 'UsersController@updateStatus']);
	Route::post('/update-valid-ip', ['as' => 'update-valid-ip', 'uses' => 'UsersController@updateValidateIP']);
	Route::post('/update-password', ['as' => 'update-password', 'uses' => 'UsersController@updatePassword']);
	Route::get('/{id}/logs', 		['as' => 'logs', 			'uses' => 'UsersController@logs']);

	Route::get('/{id}/system-permision', 		['as' => 'system-permision', 			'uses' => 'UsersController@permision']);
	Route::get('/check-system-permision', 	['as' => 'check-system-permision', 		'uses' => 'UsersController@checkPermisions']);

	Route::get('/{id}/zone', 		['as' => 'zone', 			'uses' => 'UsersController@zone']);
	Route::get('/check-zone', 	['as' => 'check-zone', 		'uses' => 'UsersController@checkZones']);

	
});
