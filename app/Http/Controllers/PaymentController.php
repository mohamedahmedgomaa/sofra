<?php

namespace App\Http\Controllers;

use App\Model\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $records = Payment::paginate(20);
        return view('payments.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payments.create');
    }

    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'note' => 'required',
            'amount' => 'required|numeric',
            'restaurant_id' => 'required',
        ], [
            'note.required' => trans('admin.note'),
            'amount.required' => trans('admin.amount'),
            'restaurant_id.required' => trans('admin.restaurant')
        ]);

        $record = Payment::create($request->all());
        flash()->success(trans('admin.success'));
        return redirect(route('payment.index'));
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
        $model = Payment::findOrFail($id);
        return view('payments.edit', compact('model'));
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
        $records = Payment::findOrFail($id);
        $records->update($request->all());
        flash()->success(trans('admin.messageEdited'));
        return redirect(route('payment.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Payment::findOrFail($id);
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
