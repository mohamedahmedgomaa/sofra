<?php

namespace App\Http\Controllers;

use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Product::paginate(20);
        return view('products.index', compact('records'));
    }

    public function search(Request $request)
    {
        $records = Product::with('restaurant')->where(function ($product) use ($request) {
            if ($request->input('search')) {
                $product->where(function ($products) use ($request) {
                    $products->where('name', 'like', '%' . $request->search . '%');
                    $products->orWhere('description', 'like', '%' . $request->search . '%');
                    $products->orWhere('restaurant_id', 'like', '%' . $request->search . '%');
//                    $product->orWhere('description', 'like', '%' . $request->search . '%');
                });
            }
        })->latest()->paginate(10);

        return view('products.index', compact('records'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        $record = Product::findOrFail($id);
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
