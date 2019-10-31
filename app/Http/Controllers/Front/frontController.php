<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Model\Cart;
use App\Model\City;
use App\Model\Client;
use App\Model\Comment;
use App\Model\Contact;
use App\Model\Offer;
use App\Model\Order;
use App\Model\Product;
use App\Model\Restaurant;
use App\User;
use Carbon\Carbon;
use Session;
use Illuminate\Http\Request;

class frontController extends Controller
{

    public function index(Request $request)
    {
        $restaurants = Restaurant::available()->where(function ($q) use ($request) {
            if ($request->name) {
                $q->where('name', $request->name);
            }
            if ($request->city_id) {
                $q->whereHas('neighborhood', function ($q2) use ($request) {
                    $q2->whereNeighborhoodId($request->city_id);
                });
            }
        })->with('neighborhood.city')->latest()->paginate(8);
        return view('welcome', compact('restaurants'));
    }

    public function check()
    {
        return view('front.check');
    }

    public function restaurants($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $rate = $restaurant->comments()->avg('evaluate');
//       dd($rate);
        return view('front.restaurants.restaurants', compact('restaurant', 'rate'));
    }

    public function restaurant()
    {
        return view('front.restaurants.restaurant');
    }

    public function addProduct()
    {
        return view('front.restaurants.addProduct');
    }

    public function addProductCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'offer' => 'nullable',
            'time' => 'required',
        ], [
            'name.required' => 'يجب ادخال الاسم',
            'description.required' => 'يجب ادخال الموضوع',
            'price.required' => 'يجب ادخال الموضوع',
            'time.required' => 'يجب ادخال الوقت المحدد للانتظار',
        ]);

        if ($request->offer >= $request->price) {
            flash()->error('سعر العرض اكبر من او يساوى سعر المنيج');
            return redirect(route('addProduct'));
        }
        $record = Product::create($request->all());
        if ($request->hasFile('image')) {
            $logo = $request->image;
            $logo_new_name = time() . $logo->getClientOriginalName();
            $logo->move('uploads/post', $logo_new_name);

            $record->image = 'uploads/post/' . $logo_new_name;
            $record->save();
        }
        $record->restaurant_id = auth('restaurant')->user()->id;
        $record->save();
        flash()->success("تم اضافه المنيج بنجاح");
        return redirect(route('addProduct'));
    }

    public function productEdit($id)
    {
        $model = Product::findOrFail($id);
        if ($id == auth('restaurant')->user()->id) {
            return view('front.restaurants.editProduct', compact('model'));
        }
        abort('404');
    }

    public function postProductEdit(Request $request, $id)
    {
        $records = Product::findOrFail($id);
        $records->update($request->all());
        if ($request->hasFile('image')) {
            $logo = $request->image;
            $logo_new_name = time() . $logo->getClientOriginalName();
            $logo->move('uploads/post', $logo_new_name);

            $records->image = 'uploads/post/' . $logo_new_name;
            $records->save();
        }
        flash()->success('تم التعديل بنجاح');
        return redirect(route('productEdit', $records->id));

    }

    public function deleteProduct($id)
    {
        $record = Product::findOrFail($id);
        $record->delete();
        flash()->success('تم الحذف بنجاح');
        return back();
    }

    public function contactUs()
    {
        return view('front.contactUs');
    }

    public function createContactUs(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'message' => 'nullable',
            'type' => 'required|in:complaint,suggestion,enquiry',
        ], [
            'name.required' => 'يجب ادخال الاسم',
            'email.required' => 'يجب ادخال البريد الالكترونى',
            'phone.required' => 'يجب ادخال رقم الهاتف',
            'message.required' => 'يجب ادخال الرساله',
            'type.required' => 'يجب تحديد نوع الرساله',
        ]);

        $record = Contact::create($request->all());
        flash()->success("تم الاضافه بنجاح");
        return redirect(route('contactUs'));
    }

    public function orders()
    {
        return view('front.restaurants.orders');
    }

    public function acceptedOrder($id)
    {
        $order = Order::where('state', 'pending')->findOrFail($id);
        $orders = $order->update(['state' => 'accepted']);
        return redirect()->route('restaurant.orders');
    }

    public function rejectedOrder($id)
    {
        $order = Order::where('state', 'pending')->findOrFail($id);
        $orders = $order->update(['state' => 'rejected']);
        return redirect()->route('restaurant.orders');
    }

    public function deliveredOrder($id)
    {
        $order = Order::where('state', 'accepted')->findOrFail($id);
        $orders = $order->update(['state' => 'delivered']);
        return redirect()->route('restaurant.orders');
    }

    public function meal(Request $request, $id)
    {
        $meal = Product::findOrFail($id);
        return view('front.meal', compact('meal'));
    }

    public function createComment(Request $request)
    {
        $this->validate($request, [
            'evaluate' => 'required|in:1,2,3,4,5',
            'comment' => 'required',
            'client_id' => 'required',
            'restaurant_id' => 'nullable',
        ], [
            'evaluate.required' => 'يجب ادخال الاسم',
            'comment.required' => 'يجب ادخال البريد الالكترونى',
            'client_id.required' => 'يجب ادخال رقم الهاتف',
            'restaurant_id.required' => 'يجب ادخال الرساله',
        ]);

        $record = auth()->guard('client')->comments()->create($request->all());
        $record->client_id = auth('client')->user()->id;
//        $record->restaurant_id = ;
        flash()->success("تم الاضافه بنجاح");
        return redirect()->back();
    }

    public function offersSeller()
    {
        return view('front.restaurants.offers');
    }

    public function createOffer()
    {
        return view('front.restaurants.createOffer');
    }

    public function postCreateOffer(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'content' => 'required',
            'image' => 'required',
            'from' => 'nullable',
            'to' => 'required',
        ], [
            'name.required' => 'يجب ادخال الاسم',
            'content.required' => 'يجب ادخال الموضوع',
            'image.required' => 'يجب اختيار الصوره',
            'from.required' => 'يجب ادخال بداية وقت العرض',
            'to.required' => 'يجب ادخال نهاية وقت العرض',
        ]);

//        if ($request->from >= $request->to) {
//            flash()->error('سعر العرض اكبر من او يساوى سعر المنيج');
//            return redirect(route('addProduct'));
//        }
        $record = Offer::create($request->all());
        if ($request->hasFile('image')) {
            $logo = $request->image;
            $logo_new_name = time() . $logo->getClientOriginalName();
            $logo->move('uploads/offer', $logo_new_name);

            $record->image = 'uploads/offer/' . $logo_new_name;
            $record->save();
        }
        $record->restaurant_id = auth('restaurant')->user()->id;
        $record->save();
        flash()->success("تمت الاضافه بنجاح");
        return redirect()->back();
    }

    public function editOffer($id)
    {
        $model = Offer::findOrFail($id);
        if ($id == auth('restaurant')->user()->id) {
            return view('front.restaurants.editOffer', compact('model'));
        }
        abort('404');
    }

    public function postEditOffer(Request $request, $id)
    {
        $records = Offer::findOrFail($id);
        $records->update($request->all());
        if ($request->hasFile('image')) {
            $logo = $request->image;
            $logo_new_name = time() . $logo->getClientOriginalName();
            $logo->move('uploads/offer', $logo_new_name);

            $records->image = 'uploads/offer/' . $logo_new_name;
            $records->save();
        }
        flash()->success('تم التعديل بنجاح');
        return redirect(route('restaurant.editOffer', $records->id));
    }

    public function profile($id)
    {
        $profile = auth('restaurant')->user();
        $cities = City::all();
        if ($id == auth('restaurant')->user()->id) {
            return view('front.restaurants.profile', compact('profile', 'cities'));
        }
        abort('404');
    }

    public function editProfile(Request $request, $id)
    {
        $records = Restaurant::findOrFail($id);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:restaurants,email,' . $id,
            'phone' => 'required',
            'password' => 'nullable|confirmed',
            'neighborhood_id' => 'required',
            'minimum' => 'required',
            'delivery' => 'required',
            'whats_app' => 'required',
            'restaurant_phone' => 'required',
            'state' => 'required|in:open,close',
            'categories' => 'required|exists:categories,id',
        ]);


        $records->update($request->except('password'));
        if (request()->input('password')) {
            $records->update(['password' => bcrypt($request->password)]);
        }
        if ($request->hasFile('image')) {
            $logo = $request->image;
            $logo_new_name = time() . $logo->getClientOriginalName();
            $logo->move('uploads/restaurant', $logo_new_name);

            $records->image = 'uploads/restaurant/' . $logo_new_name;
            $records->save();
        }

        $records->categories()->sync($request->categories);

        flash()->success('تم التعديل بنجاح');
        return redirect(route('restaurant.profile', $records->id));
    }

    public function profileClient($id)
    {
        $profile = auth('client')->user();
//        dd($profile->id);
        $cities = City::all();
        if ($id == auth('client')->user()->id) {
            return view('front.clients.profile', compact('profile', 'cities'));
        }
        abort('404');
    }

    public function editProfileClient(Request $request, $id)
    {
        $records = Client::findOrFail($id);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:clients,email,' . $id,
            'phone' => 'required',
            'password' => 'nullable|confirmed',
            'neighborhood_id' => 'required',
        ]);


        $records->update($request->except('password'));
        if (request()->input('password')) {
            $records->update(['password' => bcrypt($request->password)]);
        }
        if ($request->hasFile('image')) {
            $logo = $request->image;
            $logo_new_name = time() . $logo->getClientOriginalName();
            $logo->move('uploads/client', $logo_new_name);

            $records->image = 'uploads/client/' . $logo_new_name;
            $records->save();
        }

        flash()->success('تم التعديل بنجاح');
        return redirect(route('client.profile', $records->id));
    }

    public function ordersClient()
    {
        return view('front.clients.orderClient');
    }

    public function deliveredOrderClient($id)
    {
        $order = Order::where('state', 'accepted')->findOrFail($id);
        $orders = $order->update(['state' => 'delivered']);
        return redirect()->route('client.orders');
    }

    public function declinedOrderClient($id)
    {
        $order = Order::where('state', 'pending')->findOrFail($id);
        $orders = $order->update(['state' => 'declined']);
        return redirect()->route('client.orders');
    }

    public function clientOffers()
    {
        $now = Carbon::now()->toDate();
        $offers = Offer::where('from','<',$now)->where('to','>',$now)->paginate(10);
        return view('front.clients.offerClient', compact('offers'));
    }

    public function getAddToCart(Request $request,$id)
    {
        $product = Product::find($id);
        $restaurant = $product->restaurant();
        if(session()->exists('restaurant_id'))
        {

            if($restaurant->first()->id != session('restaurant_id'))
            {
                flash()->error('error');
                return back();
            }
        }
        $oldCart = Session::has('cart') ? Session::get('cart') : null;

        Cart::addRestaurantId($oldCart , $restaurant->first()->id);

        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);
        $request->session()->put('cart', $cart);
//        dd($request->session()->get('cart'));
        return redirect()->back();
    }

    public function shoppingCart()
    {
        if (!Session::has('cart')) {
            return view('front.clients.shoppingCart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('front.clients.shoppingCart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);

    }

    public function getReduceByOne($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }

        return redirect()->route('client.shoppingCart');
    }

    public function getRemoveItem($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return redirect()->route('client.shoppingCart');
    }

    public function addOrder(Request $request)
    {
        $this->validate($request, [
            'address' => 'required',
            'payment_method_id' => 'required',
        ]);
        $client =  auth()->guard('client')->user();
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $products = new Cart($oldCart);

        $restaurant = Restaurant::find(session('restaurant_id'));

        if($restaurant)
        {
            $order = $client->orders()->create($request->all());
            $order->update(
                [
                    'restaurant_id' => $restaurant->id ,
                    'price' => $products->totalPrice,
                    'delivery' => $restaurant->delivery,
                    'total' => $products->totalPrice + $restaurant->delivery
                ]
            );
            foreach ($products->items as $product)
            {
                $order->products()->attach($product['product_id'],
                    [
                        'qty' =>$product['qty'] ,
                        'price' =>$product['price']
                    ]);
            }
            session()->forget('cart');
            session()->forget('restaurant_id');

            flash()->success('تم اضافة االطلب بنجاح');
            return redirect('/sofra');
//            return view('front.clients.editShoppingCart', compact('order'));
        }
    }

    public function editShoppingCart($id)
    {
        $model = Order::findOrFail($id);
        return view('front.clients.editShoppingCart', compact('model'));
    }

//    public function updateNoteAddress(Request $request, $id)
//    {
//        $records = Order::findOrFail($id);
//        $this->validate($request, [
//            'note' => 'required',
//            'address' => 'required',
//            'payment_method_id' => 'required',
//        ]);
//        $records->update($request->all());
//
//        flash()->success('تم التعديل بنجاح');
//        return redirect()->route('index');
//    }
}
