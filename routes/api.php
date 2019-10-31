<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group(['namespace' => 'Api'], function () {

    Route::group(['namespace' => 'Client', 'prefix' => 'client'], function () {

        Route::get('payment-methods', 'MainController@paymentMethods');
        Route::post('contact-us', 'MainController@contactUs');
        Route::get('restaurants', 'MainController@restaurants');
        Route::get('restaurant-inside-comments', 'MainController@commentsInsideRestaurant');
        Route::get('restaurant-inside-products', 'MainController@productsInsideRestaurant');
        Route::get('information-restaurant', 'MainController@informationRestaurant');
        Route::get('offer-products', 'MainController@offerProducts');
        Route::get('show-offers', 'MainController@showOffers');

        Route::post('registerClient', 'AuthController@registerClient');
        Route::post('loginClient', 'AuthController@loginClient');
        Route::post('reset-password-client', 'AuthController@resetPasswordClient');
        Route::post('new-password-client', 'AuthController@newPasswordClient');

        Route::group(['middleware' => 'auth:api'], function () {

            Route::post('new-order', 'OrderController@newOrder');
            Route::post('delivered-order', 'OrderController@deliveredOrder');
            Route::post('declined-order', 'OrderController@declinedOrder');
            Route::get('client-current-order', 'OrderController@clientCurrentOrder');
            Route::get('client-old-order', 'OrderController@clientOldOrder');
            Route::post('show-order', 'OrderController@showOrder');

            Route::post('profile-edit-client', 'AuthController@profileEditClient');
            Route::post('create-comment', 'MainController@createComment');
            Route::get('show-profile-client', 'AuthController@showProfileClient');

            Route::post('create-token-client', 'MainController@createTokenClient');
            Route::post('remove-token-client', 'MainController@removeTokenClient');

        });
    });

    Route::group(['namespace' => 'Restaurant', 'prefix' => 'restaurant'], function () {

        Route::get('cities', 'MainController@cities');
        Route::get('neighborhoods', 'MainController@neighborhoods');
        Route::get('settings', 'MainController@settings');
        Route::get('contactUs', 'MainController@settings');
        Route::get('categories', 'MainController@settings');
        Route::get('notifications', 'MainController@settings');
        Route::get('orders', 'MainController@settings');
//        Route::get('display-offer', 'OfferController@displayOffer');

        Route::post('registerRestaurant', 'AuthController@registerRestaurant');
        Route::post('loginRestaurant', 'AuthController@loginRestaurant');
        Route::post('reset-password-restaurant', 'AuthController@resetPasswordRestaurant');
        Route::post('new-password-restaurant', 'AuthController@newPasswordRestaurant');

        Route::group(['middleware' => 'auth:restaurants'], function () {
            Route::post('profile-edit-restaurant', 'AuthController@profileEditRestaurant');
            Route::get('show-profile-restaurant', 'AuthController@showProfileRestaurant');
            Route::get('show-product-restaurant', 'MainController@showProductRestaurant');

            Route::get('restaurant-offers', 'MainController@restaurantOffers');
            Route::post('create-offer', 'MainController@createOffer');
            Route::post('update-offer', 'MainController@updateOffer');
            Route::post('remove-offer', 'MainController@removeOffer');
            Route::get('display-offer-restaurant', 'MainController@displayOfferRestaurant');

            Route::get('restaurant-products', 'MainController@restaurantProducts');
            Route::post('create-product', 'MainController@createProduct');
            Route::post('update-product', 'MainController@updateProduct');
            Route::post('remove-product', 'MainController@removeProduct');

            Route::post('create-token-restaurant', 'MainController@createTokenRestaurant');
            Route::post('remove-token-restaurant', 'MainController@removeTokenRestaurant');

            Route::get('restaurant-new-order', 'OrderController@restaurantNewOrder');
            Route::get('restaurant-current-order', 'OrderController@restaurantCurrentOrder');
            Route::get('restaurant-old-order', 'OrderController@restaurantOldOrder');

            Route::post('accepted-order', 'OrderController@acceptedOrder');
            Route::post('rejected-order', 'OrderController@rejectedOrder');
            Route::post('delivered-order', 'OrderController@deliveredOrder');
            Route::get('commission', 'OrderController@commission');

        });

    });

});