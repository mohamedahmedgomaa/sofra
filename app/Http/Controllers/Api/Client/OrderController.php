<?php

namespace App\Http\Controllers\Api\Client;

use App\Model\Comment;
use App\Model\Order;
use App\Model\Product;
use App\Model\Restaurant;
use App\Model\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
//->where(function ($query) {
//    $query->where('state', 'accepted');
//    $query->whereIn('state', ['pending',]);
//})
    public function clientCurrentOrder(Request $request)
    {
        $order = $request->user()->orders()->whereIn('state', ['pending', 'accepted'])->get();

        return responseJson(1, 'تمت العمليه بنجاح', ['order' => $order->load('client', 'paymentMethod')]);
    }

    public function showOrder(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'id' => 'required|exists:orders,id', //
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $order = $request->user()->orders()->find($request->id);
        if ($order) {
            return responseJson(1, 'تمت العمليه بنجاح', ['order' => $order->load('client', 'paymentMethod')]);
        }
        return responseJson(1, 'تم الحذف بنجاح');
    }

    public function clientOldOrder(Request $request)
    {
        $order = $request->user()->orders()->whereIn('state', ['rejected', 'delivered', 'declined'])->get();

        return responseJson(1, 'تمت العمليه بنجاح', ['order' => $order->load('client', 'paymentMethod')]);
    }

    public function newOrder(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.qty' => 'required',
            'address' => 'required',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $restaurant = Restaurant::find($request->restaurant_id);

        if ($restaurant->state == 'close') {
            return responseJson(0, 'عزرا المطعم غير متاح فى الوقت الحالى');
        }

        $order = $request->user()->orders()->create([
            'restaurant_id' => $request->restaurant_id,
            'note' => $request->note,
            'state' => 'pending',
            'address' => $request->address,
            'payment_method_id' => $request->payment_method_id
        ]);

        $cost = 0;
        $delivery_cost = $restaurant->delivery;
        foreach ($request->products as $i) {
            $product = Product::find($i['product_id']);
            $readyItem = [
                $i['product_id'] => [
                    'qty' => $i['qty'],
                    'price' => $product->price,
                    'note' => (isset($i['note'])) ? $i['note'] : ''
                ]
            ];
            $order->products()->attach($readyItem);
            $cost += ($product->price * $i['qty']);

        }
        if ($cost >= $restaurant->minimum) {
            $total = $cost + $delivery_cost;

            $commission = settings()->commission * $cost;
            $net = $total - settings()->commission;

            $update = $order->update([
                'price' => $cost,
                'delivery' => $delivery_cost,
                'total' => $total,
                'commission' => $commission,
                'net' => $net,
            ]);

            $notification = $restaurant->notifications()->create([
                'title' => 'لديك طلب جديد',
                'body' => 'لديك طلب جديد من العمليل ' . $request->user()->name,
                'order_id' => $order->id
            ]);

            $send = null;

            $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();

            if (count($tokens)) {
                $title = $notification->title;
                $body = $notification->body;
                $data = [
                    'order_id' => $order->name
                ];
                $send = notifyByFirebase($title, $body, $tokens, $data);
            }

            $data = [
                'order' => $order->fresh()->load('products')
            ];

            return responseJson(1, 'تم الطلب بنجاح', ['data' => $data, 'send' => $send]);
        } else {
            $order->products()->delete();
            $order->delete();
            return responseJson(0, 'الطلب لابد ان لا يكون اقل من ' . $restaurant->minimum . ' $');
        }
    }

    public function deliveredOrder(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $order = $request->user()->orders()->find($request->order_id);
        if ($order->state == 'pending' || $order->state == 'accepted') {
            $orders = $order->update([
                'state' => 'delivered' // تسليم
            ]);

            $restaurant = $order->restaurant;
            $notification = $restaurant->notifications()->create([
                'title' => 'تمت الموافقه على ان الطلب تم تسليمه',
                'body' => 'تمت الموافقه على الطلب من المستخدم ' . $request->user()->name . 'على انه استلمه',
                'order_id' => $request->order_id,
            ]);
//            $send = null;
            $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();
            if (count($tokens)) {
                $title = $notification->title;
                $body = $notification->body;
                $data = [
                    'order_id' => $order->name
                ];
                $send = notifyByFirebase($title, $body, $tokens, $data);

            }

            $data = [
                'order' => $order->fresh()->load('products')
            ];

            return responseJson(1, 'تم الارسال بنجاح', ['data' => $data, 'send' => $send]);
        }
        return responseJson(0, 'هذا الطلب لا يمكن الموافقه عليه');
    }

    public function declinedOrder(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $order = $request->user()->orders()->find($request->order_id);
        if ($order->state == 'pending' || $order->state == 'accepted') {
            $orders = $order->update([
                'state' => 'declined' // رفض
            ]);
            $restaurant = $order->restaurant;
            $notification = $restaurant->notifications()->create([
                'title' => 'تمت رفض الطلب',
                'body' => 'تمت رفض الطلب من المستخدم ' . $request->user()->name,
                'order_id' => $request->order_id
            ]);
            //$send = null;
            $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();
            dd($tokens);
//            dd($tokens);
            if (count($tokens)) {
                $title = $notification->title;
                $body = $notification->body;
                $data = [
                    'order_id' => $order->name
                ];
                $send = notifyByFirebase($title, $body, $tokens, $data);
//dd($send);
            }

            $data = [
                'order' => $order->fresh()->load('products')
            ];

            return responseJson(1, 'تم الطلب بنجاح',$data);
        }
        return responseJson(0, 'هذا الطلب لا يمكن الموافقه عليه');
    }
}
