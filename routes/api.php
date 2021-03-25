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
Route::post('/signin',"userController@signin");
Route::post('/verifyAccount',"userController@verifyAccount");
Route::post('/updateProfile',"userController@updateProfile");



//Home
Route::get('/home',"HomeController@getHomePage");


//Categories

Route::get('/addCategory',"CategoryController@addCategory");
Route::get('/getCategories',"CategoryController@getCategories");
Route::get('/getCategoryItems',"CategoryController@getCategoryItems");
Route::get('/getItemDetails',"CategoryController@getItemDetails");
Route::get('/likeItem',"CategoryController@likeItem");
Route::get('/addItemToBag',"CategoryController@addItemToBag");


//Offers
Route::get('/getOffersList',"OffersController@getOffersList");


//Bag 
Route::get('/getBagItems',"BagController@getBagItems");
Route::get('/updateBagItem',"BagController@updateBagItem");

