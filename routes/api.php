<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
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


Route::get('/users',"userController@allUser");

//Auth
Route::get('/signin',"userController@signin");
Route::get('/verifyAccount',"userController@verifyAccount");
Route::get('/updateProfile',"userController@updateProfile");



//Home
Route::get('/home',"HomeController@getHomePage");


//Categories
Route::get('/getCategories',"CategoryController@getCategories");
Route::get('/getCategoryItems',"CategoryController@getCategoryItems");
Route::get('/getItemDetails',"CategoryController@getItemDetails");
Route::get('/likeItem',"CategoryController@likeItem");
Route::get('/addItemToBag',"CategoryController@addItemToBag");


//Offers
Route::get('/getFavoriteList',"OffersController@getFavoriteList");


//Bag 
Route::get('/getBagItems',"BagController@getFavoriteList");
Route::get('/updateBagItem',"BagController@updateBagItem");

