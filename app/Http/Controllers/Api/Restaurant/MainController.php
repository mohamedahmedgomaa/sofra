<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Model\Category;
use App\Model\City;
use App\Model\Comment;
use App\Model\Contact;
use App\Model\Neighborhood;
use App\Model\Notification;
use App\Model\Offer;
use App\Model\Order;
use App\Model\PaymentMethod;
use App\Model\Product;
use App\Model\Restaurant;
use App\Model\Setting;
use App\Model\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function settings()
    {
        $settings = Setting::first();
        return responseJson(1, 'تمت العمليه بنجاح', $settings);
    }

    public function contactUs()
    {
        $contact = Contact::paginate(10);
        return responseJson(1, 'تمت العمليه بنجاح', $contact);
    }

    public function categories()
    {
        $categories = Category::paginate(10);
        return responseJson(1, 'تمت العمليه بنجاح', $categories);
    }

    public function notifications()
    {
        $notifications = Notification::paginate(10);
        return responseJson(1, 'تمت العمليه بنجاح', $notifications);
    }

    public function orders()
    {
        $orders = Order::paginate(10);
        return responseJson(1, 'تمت العمليه بنجاح', $orders);
    }

    public function cities()
    {
        $cities = City::paginate(10);
        return responseJson(1, 'تمت العمليه بنجاح', $cities);
    }

    public function neighborhoods(Request $request)
    {
        $neighborhoods = Neighborhood::where(function ($query) use ($request) {
            if ($request->has('city_id')) {
                $query->where('city_id', $request->city_id);
            }
        })->get();;

        return responseJson(1, 'تمت العمليه بنجاح', $neighborhoods);
    }
//
//    public function displayOffer(Request $request)
//    {
//        $validator = validator()->make($request->all(), [
//            'id' => 'required|exists:offers,id', //
//        ]);
//        if ($validator->fails()) {
//            return responseJson(0, $validator->errors()->first(), $validator->errors());
//        }
//        $offer = Offer::find($request->id);
//
//        return responseJson(1, 'تمت العمليه بنجاح', $offer);
//    }


    // Offers
    public function restaurantOffers(Request $request)
    {
        $offer = $request->user()->offers()->get();;
        return responseJson(1, 'تمت العمليه بنجاح', $offer);
    }

    public function displayOfferRestaurant(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'id' => 'required|exists:offers,id', //
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $offer = $request->user()->offers()->find($request->id);
        if ($offer) {
            return responseJson(1, 'تمت العمليه بنجاح', $offer);
        }
        return responseJson(0, 'ليس لديك صلاحيات');
    }

    public function createOffer(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'content' => 'required',
            'image' => 'required',
            'from' => 'required',
            'to' => 'required',
            'restaurant_id' => 'nullable'
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $offer = Offer::create($request->all());
        if ($request->hasFile('image')) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('uploads/post', $image_new_name);

            $offer->image = 'uploads/post/' . $image_new_name;
            $offer->save();
        }

        $offer->restaurant_id = $request->user()->id;
        $offer->save();
        return responseJson(1, 'تمت العمليه بنجاح', $offer);
    }

    public function updateOffer(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'content' => 'required',
            'from' => 'required',
            'to' => 'required',
            'restaurant_id' => 'nullable',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $offer = $request->user()->offers()->find($request->offer_id);
        if ($offer) {
            $offer->update($request->all());
            if ($request->hasFile('image')) {
                $image = $request->image;
                $image_new_name = time() . $image->getClientOriginalName();
                $image->move('uploads/post', $image_new_name);

                $offer->image = 'uploads/post/' . $image_new_name;
                $offer->save();
            }
        }
        return responseJson(1, 'تمت التعديل بنجاح', ['offers' => $offer]);
    }

    public function removeOffer(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'id' => 'required|exists:offers,id', //
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $offer = $request->user()->offers()->find($request->id);
        if ($offer) {
            $offer->delete();
            return responseJson(1, 'تم الحذف بنجاح');
        }
        return responseJson(0, 'لم يتم الحذف');
    }

    // Products
    public function restaurantProducts(Request $request)
    {
        $product = $request->user()->products()->get();
        return responseJson(1, 'تمت العمليه بنجاح', $product);
    }

    public function showProductRestaurant(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'id' => 'required|exists:products,id', //
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $product = $request->user()->products()->find($request->id);
        if ($product) {
            return responseJson(1, 'تمت العمليه بنجاح', $product->load('restaurant'));
        }
        return responseJson(0, 'فشلت العمليه');
    }

    public function createProduct(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
            'price' => 'required',
            'time' => 'required',
            'restaurant_id' => 'nullable'
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        if ($request->offer >= $request->price) {
            return responseJson(0, 'سعر العرض اكبر من او يساوى سعر المنيج');
        }
        $product = Product::create($request->all());
        if ($request->hasFile('image')) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('uploads/post', $image_new_name);

            $product->image = 'uploads/post/' . $image_new_name;
            $product->save();
        }
        $product->restaurant_id = $request->user()->id;
        $product->save();
        return responseJson(1, 'تمت العمليه بنجاح', $product);
    }

    public function updateProduct(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'time' => 'required',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $product = $request->user()->products()->find($request->product_id);
        if ($product) {
            $product->update($request->all());
            if ($request->hasFile('image')) {
                $image = $request->image;
                $image_new_name = time() . $image->getClientOriginalName();
                $image->move('uploads/post', $image_new_name);

                $product->image = 'uploads/post/' . $image_new_name;
                $product->save();
            }
            return responseJson(1, 'تمت التعديل بنجاح', ['product' => $product]);
        }
        return responseJson(0, 'فشل فى تعديل البيانات');
    }

    public function removeProduct(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'id' => 'required|exists:products,id', //
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $product = $request->user()->products()->find($request->id);
        if ($product) {
            $product->delete();
        }
        return responseJson(1, 'تم الحذف بنجاح');
    }

    public function createTokenRestaurant(Request $request)
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
        return responseJson(1, 'تمت العمليه بنجاح');
    }

    public function removeTokenRestaurant(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'token' => 'required',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        Token::where('token', $request->token)->delete();

        return responseJson(1, 'تم الحذف بنجاح');
    }
}
