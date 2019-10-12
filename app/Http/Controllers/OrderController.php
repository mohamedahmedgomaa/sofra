<?php

namespace App\Http\Controllers;

use App\Model\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function index()
//    {
//        //
//        $records = Order::paginate(20);
//        return view('orders.index', compact('records'));
//    }

    public function index(Request $request)
    {
        $order = Order::where(function($q) use($request){
            if ($request->order_id)
            {
                $q->where('id',$request->order_id);
            }
            if ($request->restaurant_id)
            {
                $q->where('restaurant_id',$request->restaurant_id);
            }
            if ($request->state)
            {
                $q->where('state',$request->state);
            }
            if ($request->from && $request->to)
            {
                $q->whereDate('created_at' , '>=' , $request->from);
                $q->whereDate('created_at' , '<=' , $request->to);
            }
        })->with('restaurant')->latest()->paginate(20);
        return view('orders.index',compact('order'));
    }

    public function show($id)
    {
        //
        $order = Order::findOrFail($id);
        //dd($order);
        return view('orders.show', compact('order'));
    }



    public function destroy($id)
    {
        $record = Order::findOrFail($id);
        if (!$record) {
            return response()->json([
                'status' => 0,
                'message' => trans('admin.error')
            ]);
        }

        $record->delete();
        return response()->json([
            'status' => 1,
            'message' => trans('admin.deleted'),
            'id' => $id
        ]);
    }
}
