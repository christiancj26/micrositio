<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group([
	'prefix' 		=> 'admin',
	'namespace' 	=> 'admin',
	'middleware' 	=> 'auth'],
function (){
		/*Route::get('/', 'AdminController@index')->name('admin');*/
		//posts
		Route::resource('posts', 'PostsController', ['except' => 'show', 'as' => 'admin']);
		//usuarios
		Route::resource('users', 'UsersController', ['as' => 'admin']);
		Route::get('users/{user}/avatar', 'UsersController@getAvatar');
		//roles de usuario
		Route::get('users/{user}/roles', 'UsersRolesController@edit');
		Route::put('users/{user}/roles/update', 'UsersRolesController@update');
		//permisos de usuario
		Route::get('users/{user}/permissions', 'UsersPermissionsController@edit');
		Route::put('users/{user}/permissions/update', 'UsersPermissionsController@update');
		//roles
		Route::resource('roles', 'RolesController', ['as' => 'admin']);
		//photos
		Route::get('posts/{post}/photos', 'PhotosController@get');
		Route::post('posts/{post}/photos', 'PhotosController@store');
		Route::delete('photos/{photo}', 'PhotosController@destroy');

		Route::get('permission/{post}/{accion}', 'PermissionController@validatePermission');
});

Auth::routes();

Route::get('/admin', 'HomeController@index')->name('home')->middleware('auth');
