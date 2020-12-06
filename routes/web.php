<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware'=>'json'], function() use ($router){
	$router->post('/login','UsersController@login');
	$router->post('/registrer','UsersController@registrer');
	$router->group(['middleware'=>'auth'], function() use ($router){
		$router->get('/users','UsersController@index');
		$router->get('/create','UsersController@create');
		$router->get('/logout','UsersController@logout');
		$router->get('/usuario_empresa','UsersController@empresa');
		// Cotizacion
		$router->get('/documentos','DocumentoController@index');
		$router->post('/crear_documento','DocumentoController@create');
	});
});





