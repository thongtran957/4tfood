<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('login', 'Auth\LoginController@login');

Route::post('register', 'Auth\RegisterController@create');
Route::get('activation/register', 'Auth\RegisterController@changeStatus');

Route::get('4tfood/categories', 'CategoryAPIController@getCategories');
Route::get('4tfood/recipes', 'RecipeAPIController@getRecipes');
Route::get('4tfood/onerecipe', 'RecipeAPIController@getRecipe');


Route::group(['middleware' => ['checklogin']], function () {
	
	Route::resource('categories', 'CategoryAPIController');
	Route::get('list/categories', 'CategoryAPIController@getList');
	
	Route::resource('recipes', 'RecipeAPIController');
	Route::post('add/recipes', 'RecipeAPIController@addRecipe');
	Route::post('edit/recipes', 'RecipeAPIController@editRecipe');


});
 
	