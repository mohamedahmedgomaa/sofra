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

Route::get('/', function () {
    return view('welcome');
});

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