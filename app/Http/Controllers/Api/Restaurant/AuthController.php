<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Mail\ResetPassword;
use App\Model\Client;
use App\Model\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function registerRestaurant(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:restaurants',
            'phone' => 'required',
            'password' => 'required|confirmed',
            'neighborhood_id' => 'required',
            'minimum' => 'required',
            'delivery' => 'required',
            'image' => 'required',
            'whats_app' => 'required',
            'restaurant_phone' => 'required',
            'state' => 'required|in:open,close',
            'categories' => 'required|exists:categories,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0,$validator->errors()->first(), $validator->errors());
        }

        $request->merge(['password'=>bcrypt($request->password)]);
        $restaurant = Restaurant::create($request->all());
        if ( $request->hasFile('image')  ) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('uploads/post', $image_new_name);

            $restaurant->image = 'uploads/post/'.$image_new_name;
            $restaurant->save();
        }
        $restaurant->categories()->attach($request->categories);
        $restaurant->api_token = str_random(60);
        $restaurant->save();
        return responseJson(1, 'تمت الاضافه بنجاح', [
            'api_token' => $restaurant->api_token,
            'restaurant' => $restaurant->load('categories'),

        ]);
    }

    public function loginRestaurant(Request $request) {
        $validator = validator()->make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return responseJson(0,$validator->errors()->first(), $validator->errors());
        }
//        $auth = auth()->guard('api')->validate($request->all());
//        return responseJson(1, 'success', $auth);
        $restaurant = Restaurant::where('email',$request->email)->first();
        if ($restaurant) {
            if (Hash::check($request->password, $restaurant->password)) {
                return responseJson(1,'تم تسجيل الدخول بنجاح', [
                    'api_token' => $restaurant->api_token,
                    'restaurant' =>  $restaurant->load('categories'),
                ]);
            } else {
                return responseJson(0,'بيانات الدخول غير صحيحه');
            }
        } else {
            return responseJson(0,'بيانات الدخول غير صحيحه');
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPasswordRestaurant(Request $request) {
        $validator = validator()->make($request->all(), [
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return responseJson(0,$validator->errors()->first(), $validator->errors());
        }
        $user = Restaurant::where('email',$request->email)->first();
        if ($user) {
            $code = rand(1111, 9999);
//            $code = random_int(1111, 9999);
            $update = $user->update(['pin_code' => $code]);
//            dd($user->update(['pin_code' => $code])) ;
            if ($update) {

                Mail::to($user->email)
                    ->bcc('mido.15897@gmail.com')
                    ->send(new ResetPassword($code));
                return responseJson(1,'برجاء فحص الايميل الخاص بك', ['pin_code_for_test' => $code]);
            } else {
                return responseJson(0,'حدث خطا . حاول مره اخرى');
            }
        } else {
            return responseJson(0,'بيانات الدخول غير صحيحه');
        }

    }

    public function newPasswordRestaurant(Request $request) {
        $validator = validator()->make($request->all(), [
            'pin_code' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);
        if ($validator->fails()) {
            return responseJson(0,$validator->errors()->first(), $validator->errors());
        }
        $user = Restaurant::where('pin_code',$request->pin_code)->where('pin_code', '!=' , 0)
            ->where('email',$request->email)->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->pin_code = null;

            if ($user->save())
            {
                return responseJson(1, 'تم تغيير كلمه المرور بنجاح');
            } else {
                return responseJson(0, 'حدث خطا . حاول مره اخرى');
            }
        } else {
            return responseJson(1, 'هذا الكود غير صحيح');
        }
    }

    public function profileEditRestaurant(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:restaurants,email,' . $request->user()->id,
            'phone' => 'required',
            'password' => 'nullable|confirmed',
            'neighborhood_id' => 'required',
            'minimum' => 'required',
            'delivery' => 'required',
            'image' => 'required',
            'whats_app' => 'required',
            'restaurant_phone' => 'required',
            'state' => 'required|in:open,close',
            'categories' => 'required|exists:categories,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        if (request()->has('password')) {
            $request->merge(['password' => bcrypt($request->password)]);
        }

        $request->user()->update($request->all());
        $request->user()->categories()->sync($request->categories);

        return responseJson(1, 'تمت التعديل بنجاح', [
            'restaurant' => $request->user()->load('categories'),
        ]);
    }

    public function showProfileRestaurant(Request $request)
    {
//        $restaurant = $request->user()->get();
        return responseJson(1, 'تمت الاضافه بنجاح', ['restaurant' => $request->user()]);
    }

}