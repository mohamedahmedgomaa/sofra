<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Model\Client;
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
    public function restaurantNewOrder(Request $request)
    {
        $order = $request->user()->orders()->whereIn('state', ['pending'])->get();

        return responseJson(1, 'تمت العمليه بنجاح', ['order' => $order->load('client', 'paymentMethod')]);
    }

    public function restaurantCurrentOrder(Request $request)
    {
        $order = $request->user()->orders()->whereIn('state', ['accepted'])->get();

        return responseJson(1, 'تمت العمليه بنجاح', ['order' => $order->load('client', 'paymentMethod')]);
    }

    public function restaurantOldOrder(Request $request)
    {
        $order = $request->user()->orders()->whereIn('state', ['rejected', 'delivered', 'declined'])->get();

        return responseJson(1, 'تمت العمليه بنجاح', ['order' => $order->load('client', 'paymentMethod')]);
    }

    public function commission(Request $request){
        $restaurant_sales = $request->user()->orders()->where('state','delivered')->sum('price') ;
        $app_commissions = $request->user()->orders()->where('state','delivered')->sum('commission') ;
        $restaurant_payments = $request->user()->payments()->pluck('amount')->first();
        $rest_of_commissions =   $app_commissions - $restaurant_payments ;
        $setting = Setting::first();
        $commission =  $setting->commission * 100 .' %';
//        $elahly_bank =  $setting->elahly_bank ;
//        $alrajhi_bank =  $setting->alrajhi_bank ;
        return responseJson(1, 'تمت العمليه بنجاح', compact('restaurant_sales', 'app_commissions', 'restaurant_payments'
            , 'rest_of_commissions', 'commission'));
    }

    public function acceptedOrder(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $order = $request->user()->orders()->find($request->order_id);
        if ($order->state == 'pending') {
            $orders = $order->update([
                'state' => 'accepted'
            ]);

            $client = $order->client;
            $notification = $client->notifications()->create([
                'title' => 'تمت الموافقه على الطلب',
                'body' => 'تمت الموافقه على الطلب من المطعم ' . $request->user()->name,
                'order_id' => $request->order_id,
            ]);
//            $send = null;
            $tokens = $client->tokens()->where('token', '!=', '')->pluck('token')->toArray();
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
        }
        return responseJson(0, 'هذا الطلب لا يمكن رفضه');
    }

    public function rejectedOrder(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $order = $request->user()->orders()->find($request->order_id);
        if ($order->state == 'pending') {
            $orders = $order->update(['state' => 'rejected']);

            $client = $order->client;
            $notification = $client->notifications()->create([
                'title' => 'تمت رفض الطلب',
                'body' => 'تمت رفض الطلب من المطعم ' . $request->user()->name,
                'order_id' => $request->order_id,
            ]);
//            $send = null;
            $tokens = $client->tokens()->where('token', '!=', '')->pluck('token')->toArray();
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
        }
        return responseJson(0, 'هذا الطلب لا يمكن رفضه');

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
        if($order) {
            if ($order->state == 'pending' || $order->state == 'accepted') {
                $orders = $order->update([
                    'state' => 'delivered' // تسليم
                ]);

                $client = $order->client;
                $notification = $client->notifications()->create([
                    'title' => 'تمت التاكيد على ان الطلب تم تسليمه',
                    'body' => 'تمت التاكيد من مطعم ' . $request->user()->name . 'على ان الطلب تم تسليم للعمليل ' . $client->name,
                    'order_id' => $request->order_id,
                ]);
//            $send = null;
                $tokens = $client->tokens()->where('token', '!=', '')->pluck('token')->toArray();
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

                return responseJson(1, 'تم الارسال بنجاح', $data);
            }
        }
        return responseJson(0, 'هذا الطلب لا يمكن الموافقه عليه');
    }
}
