<?php

namespace App\Http\Controllers\Api\Client;

use App\Model\City;
use App\Model\Comment;
use App\Model\Contact;
use App\Model\Neighborhood;
use App\Model\Offer;
use App\Model\PaymentMethod;
use App\Model\Product;
use App\Model\Restaurant;
use App\Model\Setting;
use App\Model\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function showOffers()
    {
        $offers = Offer::paginate(10);
        return responseJson(1, 'تمت العمليه بنجاح', $offers);
    }

    public function paymentMethods()
    {
        $paymentMethods = PaymentMethod::paginate(10);
        return responseJson(1, 'تمت العمليه بنجاح', $paymentMethods);
    }

    public function restaurants(Request $request)
    {
//        $restaurants = Restaurant::available()->paginate(10);
        $restaurants = Restaurant::available()->with('neighborhood')->where(function ($query) use ($request) {
            if ($request->input('neighborhood_id')) {
                $query->where('neighborhood_id', $request->neighborhood_id);
            }
            if ($request->input('keyword')) {
                $query->where(function ($restaurant) use ($request) {
                    $restaurant->where('name', 'like', '%' . $request->keyword . '%');
//                    $posts->orWhere('email', 'like', '%' . $request->keyword . '%');
//                    $posts->orWhere('phone', 'like', '%' . $request->keyword . '%');
                });
            }
        })->latest()->paginate(10);
        //dd($posts);
        if ($restaurants->count() == 0) {
            return responseJson(0, 'Failed');
        }
        return responseJson(1, 'success', $restaurants);
//        return responseJson(1, 'تمت العمليه بنجاح', $restaurants);
    }

    public function commentsInsideRestaurant(Request $request)
    {

        $validator = validator()->make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id', // |exists:restaurants,id
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $restaurant = Restaurant::where('id', $request->restaurant_id)->get();
        $comments = Comment::where('restaurant_id', $request->restaurant_id)->get();

        return responseJson(1, 'تمت الاضافه بنجاح', [
            'restaurant' => $restaurant,
            'restaurant comments' => $comments,
        ]);
    }

    public function productsInsideRestaurant(Request $request)
    {

        $validator = validator()->make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id', // |exists:restaurants,id
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $restaurant = Restaurant::where('id', $request->restaurant_id)->get();
        $products = Product::where('restaurant_id', $request->restaurant_id)->get();

        return responseJson(1, 'تمت الاضافه بنجاح', [
            'restaurant' => $restaurant,
            'restaurant products' => $products,
        ]);
    }

    public function offerProducts(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id', // |exists:restaurants,id
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $product = Product::where('restaurant_id' , $request->restaurant_id)->where('offer', '!=', null)->get();
        if (!empty($product)) {
            return responseJson(1, 'تمت العمليه بنجاح', $product);
        }
        return responseJson(0, 'لا توجد عروض');
    }

    public function informationRestaurant(Request $request)
    {

        $validator = validator()->make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id', // |exists:restaurants,id
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $restaurant = Restaurant::where('id', $request->restaurant_id)->get();

        return responseJson(1, 'تمت الاضافه بنجاح', [
            'restaurant' => $restaurant
        ]);
    }

    public function createComment(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'comment' => 'required',
            'evaluate' => 'required|in:1,2,3,4,5',
            'restaurant_id' => 'required',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $comments = Comment::create($request->all());
        $comments->client_id = $request->user()->id;
        $comments->save();
        return responseJson(1, 'تمت الاضافه بنجاح', [
            'comments' => $comments
        ]);
    }


    public function contactUs(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'message' => 'required',
            'type' => 'required|in:complaint,suggestion,enquiry',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $contact = Contact::create($request->all());
        $contact->save();
        return responseJson(1, 'تمت الاضافه بنجاح', [
            'contact' => $contact
        ]);
    }

    public function createTokenClient(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'token' => 'required',
            'type' => 'required|in:android,ios',

        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        Token::where('token', $request->token)->delete();
        $request->user()->tokens()->create($request->all());
        return responseJson(1,'تمت العمليه بنجاح');
    }

    public function removeTokenClient(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'token' => 'required',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        Token::where('token', $request->token)->delete();

        return responseJson(1,'تم الحذف بنجاح');
    }
}
