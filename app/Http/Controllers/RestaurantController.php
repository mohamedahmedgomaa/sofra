<?php

namespace App\Http\Controllers;

use App\Model\Restaurant;
use Illuminate\Http\Request;

//use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $records = Restaurant::where(function ($q) use ($request) {
            if ($request->name) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('name', 'LIKE', '%' . $request->name . '%');
                });
            }
            if ($request->city_id) {
                $q->whereHas('neighborhood',function ($q2) use($request){
                    // search in restaurant region "Region" Model
                    $q2->whereCityId($request->city_id);
                });
            }
            if ($request->activated) {
                $q->where('activated',$request->activated);
            }
        })->with('neighborhood.city')->latest()->paginate(20);
        return view('restaurants.index', compact('records'));
    }


    public function search(Request $request)
    {
        $records = Restaurant::with('neighborhood')->where(function ($restaurant) use ($request) {
            if ($request->input('search')) {
                $restaurant->where(function ($restaurants) use ($request) {
                    $restaurants->where('name', 'like', '%' . $request->search . '%');
                    $restaurants->orWhere('email', 'like', '%' . $request->search . '%');
                    $restaurants->orWhere('phone', 'like', '%' . $request->search . '%');
                    $restaurants->orWhere('neighborhood_id', 'like', '%' . $request->search . '%');
//                    $restaurant->orWhere('description', 'like', '%' . $request->search . '%');
                });
            }
        })->latest()->paginate(10);

        return view('restaurants.index', compact('records'));
    }

    public function activated($id)
    {
        $record = Restaurant::findOrFail($id);
        if ($record->activated == 1) {
            $record->activated = 0;
            $update = $record->update(['activated' => $record->activated]);
        } else {
            $record->activated = 1;
            $update = $record->update(['activated' => $record->activated]);
        }
        return back();
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Restaurant::findOrFail($id);
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
