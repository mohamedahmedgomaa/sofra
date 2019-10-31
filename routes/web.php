<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes(['register' => false]);

Route::group(['middleware' => ['auth', 'auto-check-permission'], 'prefix' => 'admin'], function () { //

    Route::resource('user', 'UserController');
    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('role', 'RoleController');
    Route::resource('PaymentMethod', 'PaymentMethodController');
    Route::resource('category', 'CategoryController');
    Route::resource('city', 'CityController');
    Route::resource('neighborhood', 'NeighborhoodController');
    Route::resource('payment', 'PaymentController');

    Route::get('client', 'ClientController@index')->name('client.index');
    Route::delete('client/{id}', 'ClientController@destroy')->name('client.destroy');
    Route::put('is_active/{id}', 'ClientController@is_active')->name('client.is_active');

    Route::get('contact', 'ContactController@index')->name('contact.index');
    Route::get('complaint', 'ContactController@complaint')->name('contact.complaint');
    Route::get('suggestion', 'ContactController@suggestion')->name('contact.suggestion');
    Route::get('enquiry', 'ContactController@enquiry')->name('contact.enquiry');
    Route::delete('contact/{id}', 'ContactController@destroy')->name('contact.destroy');

    Route::get('restaurant', 'RestaurantController@index')->name('restaurant.index');
    Route::delete('restaurant/{id}', 'RestaurantController@destroy')->name('restaurant.destroy');
    Route::put('activated/{id}', 'RestaurantController@activated')->name('restaurant.activated');

    Route::get('comment', 'CommentController@index')->name('comment.index');
    Route::delete('comment/{id}', 'CommentController@destroy')->name('comment.destroy');

    Route::get('product', 'ProductController@index')->name('product.index');
    Route::delete('product/{id}', 'ProductController@destroy')->name('product.destroy');

    Route::get('offer', 'OfferController@index')->name('offer.index');
    Route::delete('offer/{id}', 'OfferController@destroy')->name('offer.destroy');

    Route::get('order', 'OrderController@index')->name('order.index');
    Route::get('show/{id}', 'OrderController@show')->name('order.show');
    Route::delete('order/{id}', 'OrderController@destroy')->name('order.destroy');

    Route::get('/settings', 'SettingController@index')->name('settings');
    Route::post('/settings/update', 'SettingController@update')->name('settings.update');

    Route::post('/changePassword', 'UserController@changePassword')->name('changePassword');
    Route::get('/getChangePassword', 'UserController@getChangePassword')->name('getChangePassword');


    Route::get('lang/{lang}', function ($lang) {
        session()->has('lang') ? session()->forget('lang') : '';
        $lang == 'ar' ? session()->put('lang', 'ar') : session()->put('lang', 'en');
        return back();
    });

///////////////////// Search /////////////////////
    Route::get('/search', 'ProductController@search');
    Route::get('/search', 'RestaurantController@search');
///////////////////// Search /////////////////////

});

Route::group(['namespace' => 'Front'], function () {
    Route::get('/sofra', 'frontController@index')->name('index');
    Route::get('/', 'frontController@check')->name('check');
    Route::get('login-client', 'AuthController@getLogin')->name('front.client.get');
    Route::post('post-login-client', 'AuthController@loginClient')->name('front.client.login');
    Route::get('login-restaurant', 'AuthController@loginRestaurant')->name('front.restaurant.get');
    Route::post('post-login-restaurant', 'AuthController@postRestaurantLogin')->name('front.restaurant.login');

    Route::get('register-client', 'AuthController@frontRegisterClient')->name('register.client');
    Route::post('post-register-client', 'AuthController@registerClient')->name('post.register.client');
    Route::get('register-restaurant', 'AuthController@frontRegisterRestaurant')->name('register.restaurant');
    Route::post('post-register-restaurant', 'AuthController@registerRestaurant')->name('post.register.restaurant');

    Route::get('logoutClient', 'AuthController@logoutClient');
    Route::get('logoutRestaurant', 'AuthController@logoutRestaurant');

    Route::get('/reset-client', 'AuthController@resetClient')->name('auth.resetClient');
    Route::post('/reset-password-client', 'AuthController@resetPasswordClient')->name('auth.resetPasswordClient');
    Route::get('/new-password-client', 'AuthController@newPasswordClient')->name('auth.newPasswordClient');
    Route::post('/new-password-client', 'AuthController@postNewPasswordClient')->name('auth.postNewPasswordClient');

    Route::get('/reset-restaurant', 'AuthController@resetRestaurant')->name('auth.resetRestaurant');
    Route::post('/reset-password-restaurant', 'AuthController@resetPasswordRestaurant')->name('auth.resetPasswordRestaurant');
    Route::get('/new-password-restaurant', 'AuthController@newPasswordRestaurant')->name('auth.newPasswordRestaurant');
    Route::post('/new-password-restaurant', 'AuthController@postNewPasswordRestaurant')->name('auth.postNewPasswordRestaurant');

    Route::get('/restaurants/{id}', 'frontController@restaurants')->name('restaurants');

    Route::get('contact-us', 'frontController@contactUs')->name('contactUs');
    Route::post('create-contact-us', 'frontController@createContactUs')->name('createContactUs');

    Route::get('meal/{id}', 'frontController@meal')->name('meal');
    Route::post('create-comment', 'frontController@createComment')->name('createComment');

    Route::get('add-to-cart/{id}', 'frontController@getAddToCart')->name('client.getAddToCart');
    Route::get('shopping-cart', 'frontController@shoppingCart')->name('client.shoppingCart'); // 14
    Route::get('reduce/{id}', 'frontController@getReduceByOne')->name('client.reduceByOne');
    Route::get('remove/{id}', 'frontController@getRemoveItem')->name('client.remove');


    // restaurant auth
    Route::group(['middleware' => 'auth:restaurant', 'prefix' => 'restaurant'], function () {
        Route::get('/', 'frontController@restaurant')->name('restaurant'); // 15
        Route::get('profile/{id}', 'frontController@profile')->name('restaurant.profile');
        Route::post('editProfile/{id}', 'frontController@editProfile')->name('restaurant.editProfile');

        Route::get('add-product', 'frontController@addProduct')->name('addProduct');
        Route::post('add-product-create', 'frontController@addProductCreate')->name('addProductCreate');
        Route::get('product-edit/{id}', 'frontController@productEdit')->name('productEdit');
        Route::post('post-product-edit/{id}', 'frontController@postProductEdit')->name('postProductEdit');
        Route::delete('delete-product/{id}', 'frontController@deleteProduct')->name('deleteProduct');

        Route::get('orders', 'frontController@orders')->name('restaurant.orders');
        Route::post('accepted-order/{id}', 'frontController@acceptedOrder')->name('restaurant.acceptedOrder');
        Route::post('rejected-order/{id}', 'frontController@rejectedOrder')->name('restaurant.rejectedOrder');
        Route::post('delivered-order/{id}', 'frontController@deliveredOrder')->name('restaurant.deliveredOrder');

        Route::get('offers', 'frontController@offersSeller')->name('restaurant.offers');
        Route::get('create-offer', 'frontController@createOffer')->name('restaurant.createOffer');
        Route::post('postCreateOffer', 'frontController@postCreateOffer')->name('restaurant.postCreateOffer');
        Route::get('edit-offer/{id}', 'frontController@editOffer')->name('restaurant.editOffer');
        Route::post('postEditOffer/{id}', 'frontController@postEditOffer')->name('restaurant.postEditOffer');

    });

    Route::group(['middleware' => 'auth:client', 'prefix' => 'client'], function () {
        Route::get('profile/{id}', 'frontController@profileClient')->name('client.profile');
        Route::post('editProfile/{id}', 'frontController@editProfileClient')->name('client.editProfile');

        Route::get('orders', 'frontController@ordersClient')->name('client.orders');
        Route::post('delivered-order/{id}', 'frontController@deliveredOrderClient')->name('client.deliveredOrder');
        Route::post('declined-order/{id}', 'frontController@declinedOrderClient')->name('client.declinedOrder');

        Route::get('offers', 'frontController@clientOffers')->name('client.offers');

        Route::get('checkout', function(){
            return view('front.clients.editShoppingCart');
        });
        Route::post('add-order', 'frontController@addOrder')->name('client.addOrder');
        Route::get('edit-shopping-cart/{id}', 'frontController@editShoppingCart')->name('client.editShoppingCart');
        Route::post('update-note-address/{id}', 'frontController@updateNoteAddress')->name('client.updateNoteAddress');

        //Route::post('postCheckout', 'frontController@postCheckoutClient')->name('client.postCheckout');
    });

});


