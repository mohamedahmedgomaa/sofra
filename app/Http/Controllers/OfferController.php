<?php

namespace App\Http\Controllers;

use App\Model\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $records = Offer::paginate(20);
        return view('offers.index', compact('records'));
    }

    public function destroy($id)
    {
        $record = Offer::findOrFail($id);
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
