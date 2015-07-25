<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@index');


Route::group(['prefix' => 'admin','middleware' => ['auth']], function()
{

    Route::resource('user', 'Admin\UserController');
    Route::resource('team', 'Admin\TeamController');
    Route::resource('moduli', 'Admin\ModuliController');

    Route::get('import', 'Admin\ImportController@index');
    Route::post('import/upload', 'Admin\ImportController@upload');

    Route::controllers([
        'calendario' => 'Admin\CalendarioController',
        'rose' => 'Admin\RoseController',
        'utility/backup' => 'Admin\BackupController',
        'utility' => 'Admin\UtilityController',
        'ajax' => 'Admin\AjaxController'
    ]);

    Route::get('/', 'HomeController@index');

});


Route::get('user', 'HomeController@index');
Route::group(['prefix' => 'user','middleware' => ['auth']], function() {

    Route::controllers(['formazione' => 'User\RoseController']);

});



Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);






