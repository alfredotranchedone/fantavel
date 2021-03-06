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

/* BUGFIX x ARUBA!!! */
Route::get('/app', function(){
	return redirect('app/public');
});

Route::get('home', 'HomeController@index');


Route::group(['prefix' => 'admin','middleware' => ['auth']], function()
{

    Route::resource('user', 'Admin\UserController');
    Route::resource('team', 'Admin\TeamController');
    Route::resource('moduli', 'Admin\ModuliController');
    Route::resource('classifica', 'Admin\ClassificaController');
    Route::resource('players', 'Admin\Players');


    Route::group(['prefix'=>'config'],function(){
        Route::resource('groups', 'Admin\GroupsController');
        Route::get('/', 'Admin\ConfigController@index');
    });


    Route::get('import', 'Admin\ImportController@index');
    Route::post('import/upload', 'Admin\ImportController@upload');
    Route::post('import/player', 'Admin\ImportController@player');

    Route::controllers([
        'calendario' => 'Admin\CalendarioController',
        'rose' => 'Admin\RoseController',
        'utility/backup' => 'Admin\BackupController',
        'utility' => 'Admin\UtilityController',
        'ajax' => 'Admin\AjaxController',
        'config/groups' => 'Admin\GroupsController'
    ]);

    Route::get('/', 'HomeController@index');

});


Route::get('user', 'HomeController@index');
Route::group(['prefix' => 'user','middleware' => ['auth']], function() {

    Route::controllers(['formazione' => 'User\RoseController']);
    Route::controllers(['calendario' => 'User\CalendarioController']);
    Route::controllers(['classifica' => 'User\ClassificaController']);
    Route::controllers(['players' => 'User\Players']);
    Route::get('rosa','User\RoseController@rosa');
    // Route::controllers(['formazione' => 'User\CalendarioController']);

});



Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);






