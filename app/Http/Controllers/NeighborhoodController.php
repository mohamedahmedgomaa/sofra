<?php

namespace App\Http\Controllers;

use App\Model\Neighborhood;
use Illuminate\Http\Request;

class NeighborhoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $records = Neighborhood::paginate(20);
        return view('neighborhoods.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('neighborhoods.create');
    }

    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required',
            'city_id' => 'required',
        ], [
            'name.required' => trans('admin.name'),
            'city_id.required' => trans('admin.city')
        ]);

        $record = Neighborhood::create($request->all());
//        dd($request->all());
        flash()->success(trans('admin.success'));

        return redirect(route('neighborhood.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Neighborhood::findOrFail($id);
        return view('neighborhoods.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $records = Neighborhood::findOrFail($id);
        $records->update($request->all());
        flash()->success(trans('admin.messageEdited'));
        return redirect(route('neighborhood.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Neighborhood::findOrFail($id);
        if (!$record) {
            return response()->json([
                'status' => 0,
                'message' => trans('admin.error')
            ]);
        }

        $record->delete();
        return response()->json([
            'status' => 1,
            'message' => trans('admin.messageDeleted'),
            'id' => $id
        ]);
    }
}
