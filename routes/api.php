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
Route::post('/home',"HomeController@getHomePage");
Route::get('/getGoldPrice',"HomeController@getGoldPrice");

//Categories

Route::get('/addCategory',"CategoryController@addCategory");
Route::get('/getCategories',"CategoryController@getCategories");
Route::post('/getCategoryItems',"CategoryController@getCategoryItems");
Route::get('/getItemDetails/{id}',"CategoryController@getItemDetails");
Route::post('/likeItem',"CategoryController@likeItem");
Route::post('/getLikedItems',"CategoryController@getLikedItems");
Route::get('/addItemToBag',"CategoryController@addItemToBag");


//Offers
Route::get('/getOffersList',"OffersController@getOffersList");


//Bag 
Route::get('/getBagItems',"BagController@getBagItems");
Route::get('/updateBagItem',"BagController@updateBagItem");


//orders
Route::post('/registerOrder' , "orderController@registerOrder");
Route::post('/registerOrderOffer' , "orderController@registerOrderOffer");
Route::post('/getOrders' , "orderController@getOrders");

//message
Route::post('/submitMessage' , "customerServiceController@submitMessage");

