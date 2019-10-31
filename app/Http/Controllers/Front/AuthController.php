<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Mail\ResetPasswordRestaurant;
use App\Model\City;
use App\Model\Client;
use App\Model\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function frontRegisterClient()
    {
        $cities = City::all();
        return view('front.auth.registerClient',compact('cities'));
    }

    public function registerClient(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:clients',
            'phone' => 'required',
            'password' => 'required',
            'city_id' => 'required',
            'neighborhood_id' => 'required',
            'image' => 'required',
        ], [
            'name.required' => 'يجب كتابه الاسم',
            'email.required' => 'يجب كتابه الايميل',
            'number_phone.required' => 'يجب كتابه رقم الهاتف',
            'password.required' => 'يجب كتابه الرقم السرى',
            'city_id.required' => 'يجب اختيار المدينه',
            'neighborhood_id.required' => 'يجب كتابه تاريخ الميلاد',
            'image.required' => 'يجب اختيار صوره',
        ]);

        $request->merge(['password'=>bcrypt($request->password)]);
        $client = Client::create($request->all());
        if ( $request->hasFile('image')  ) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('uploads/clients', $image_new_name);

            $client->image = 'uploads/clients/'.$image_new_name;
            $client->save();
        }
        $client->api_token = str_random(60);
        $client->save();
        flash()->success("تم انشاء الحساب بنجاح");
        return redirect(route('front.client.get'));
    }

    public function frontRegisterRestaurant()
    {
        $cities = City::all();
        return view('front.auth.registerRestaurant',compact('settings','cities'));
    }

    public function registerRestaurant(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:restaurants',
            'phone' => 'required',
            'password' => 'required',
            'city_id' => 'required',
            'neighborhood_id' => 'required',
            'image' => 'required',
            'minimum' => 'required',
            'delivery' => 'required',
            'whats_app' => 'required',
            'restaurant_phone' => 'required',
            'categories' => 'required',
        ], [
            'name.required' => 'يجب كتابه الاسم',
            'email.required' => 'يجب كتابه الايميل',
            'number_phone.required' => 'يجب كتابه رقم الهاتف',
            'password.required' => 'يجب كتابه الرقم السرى',
            'city_id.required' => 'يجب اختيار المدينه',
            'neighborhood_id.required' => 'يجب اختيار الحى',
            'image.required' => 'يجب اختيار صوره',
            'minimum.required' => 'يجب كتابه الحد الادفى للطلب',
            'delivery.required' => 'يجب كتابه سعر خدمه التوصيل',
            'whats_app.required' => 'يجب كتابه رقم الواتس اب',
            'restaurant_phone.required' => 'يجب كتابه رقم هاتف  المطعم',
            'categories.required' => 'يجب اختيار الاقسام الخاصه بالمطعم',
        ]);

        $request->merge(['password'=>bcrypt($request->password)]);
        $restaurant = Restaurant::create($request->all());
        if ( $request->hasFile('image')  ) {
            $logo = $request->image;
            $logo_new_name = time() . $logo->getClientOriginalName();
            $logo->move('uploads/restaurants', $logo_new_name);

            $restaurant->image = 'uploads/restaurants/'.$logo_new_name;
            $restaurant->save();
        }
        $restaurant->categories()->attach($request->input('categories'));
        $restaurant->api_token = str_random(60);
        $restaurant->save();
        flash()->success("تم انشاء الحساب بنجاح");
        return redirect(route('front.restaurant.get'));
    }

    public function getLogin()
    {
        return view('front.auth.loginClient');
    }

    public function loginClient(Request $request)
    {
        $rememberme = request('rememberme') == 1 ? true : false;
        if (auth()->guard('client')->attempt(['email' => request('email'), 'password' => request('password')], $rememberme)) {
            return redirect()->route('index');
        } else {
            return back()->with('error', 'Wrong Login Details');
        }
    }

    public function loginRestaurant()
    {
        return view('front.auth.loginRestaurant');
    }

    public function postRestaurantLogin(Request $request)
    {
//        dd();
        $rememberme = request('rememberme') == 1 ? true : false;
        if (auth()->guard('restaurant')->attempt(['email' => request('email'), 'password' => request('password')], $rememberme)) {
            if (auth('restaurant')->user()->activated == 0) {
                auth()->guard('restaurant')->logout();
                flash()->error("لا يمكنك التسجيل . الحساب غير مفعل . يمكنك التواصل مع المشرف لتفعيل الحساب");
                return redirect()->route('front.restaurant.get');
            }
            return redirect('/restaurant');
        } else {
            return back()->with('error', 'Wrong Login Details');
        }
    }

    public function logoutClient()
    {
        if (auth('client')->check())
        {
            auth()->guard('client')->logout();
            return redirect()->route('index');
        }
        return redirect()->back();
    }

    public function logoutRestaurant()
    {
        if (auth('restaurant')->check()){
            auth()->guard('restaurant')->logout();
            return redirect()->route('index');
        }
        return redirect()->back();
    }

    public function resetClient()
    {
        return view('front.auth.resetClient');
    }

    public function resetPasswordClient(Request $request) {
        $this->validate($request, [
            'email' => 'required',
        ]);

        $user = Client::where('email',$request->email)->first();
//        dd($user);
        if ($user) {
            $code = rand(1111, 9999);
//            $code = random_int(1111, 9999);
            $update = $user->update(['pin_code' => $code]);
//            dd($user->update(['pin_code' => $code])) ;
            if ($update) {

                Mail::to($user->email)
                    ->bcc('mido.15897@gmail.com')
                    ->send(new ResetPassword($code));
                return redirect()->route('auth.resetClient');
            } else {
                return back()->with('error', 'Wrong Email Details');
            }
        } else {
            return back()->with('error', 'Wrong Email Details');
        }

    }

    public function newPasswordClient()
    {
        return view('front.auth.newPasswordClient');
    }

    public function postNewPasswordClient(Request $request) {
        $this->validate($request, [
            'pin_code' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);

        $user = Client::where('pin_code',$request->pin_code)->where('pin_code', '!=' , 0)
            ->where('email',$request->email)->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->pin_code = null;

            if ($user->save())
            {
                return redirect()->route('front.client.get');
            } else {
                return back()->with('error', 'Wrong email Or Code Or Password Details');
            }
        } else {
            return back()->with('error', 'Wrong email Or Code Or Password Details');
        }
    }


    public function resetRestaurant()
    {
        return view('front.auth.resetRestaurant');
    }

    public function resetPasswordRestaurant(Request $request) {
        $this->validate($request, [
            'email' => 'required',
        ]);

        $user = Restaurant::where('email',$request->email)->first();
//        dd($user);
        if ($user) {
            $code = rand(1111, 9999);
//            $code = random_int(1111, 9999);
            $update = $user->update(['pin_code' => $code]);
//            dd($user->update(['pin_code' => $code])) ;
            if ($update) {

                Mail::to($user->email)
                    ->bcc('mido.15897@gmail.com')
                    ->send(new ResetPasswordRestaurant($code));
                return redirect()->route('auth.resetRestaurant');
            } else {
                return back()->with('error', 'Wrong Email Details');
            }
        } else {
            return back()->with('error', 'Wrong Email Details');
        }

    }

    public function newPasswordRestaurant()
    {
        return view('front.auth.newPasswordRestaurant');
    }

    public function postNewPasswordRestaurant(Request $request) {
        $this->validate($request, [
            'pin_code' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);

        $user = Restaurant::where('pin_code',$request->pin_code)->where('pin_code', '!=' , 0)
            ->where('email',$request->email)->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->pin_code = null;

            if ($user->save())
            {
                return redirect()->route('front.restaurant.get');
            } else {
                return back()->with('error', 'Wrong email Or Code Or Password Details');
            }
        } else {
            return back()->with('error', 'Wrong email Or Code Or Password Details');
        }
    }
}
