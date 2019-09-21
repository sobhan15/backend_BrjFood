<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', "BrjFoodController@__construct");
$router->post('/signUp', "BrjFoodController@_signUp");
$router->post('/logIn', "BrjFoodController@_logIn");
$router->post('/getResturanData', "BrjFoodController@_getResturanData");
$router->post('/addResturan', "BrjFoodController@_addResturan");
$router->post('/getFoodData',"BrjFoodController@_getFoodData");
$router->post('/addFood',"BrjFoodController@_addFood");
$router->post('/getFoodByGroup',"BrjFoodController@_getFoodByGroup");
$router->post('/getFoodByName',"BrjFoodController@_getFoodByName");
$router->post('/addOrder',"BrjFoodController@_addOrder");
