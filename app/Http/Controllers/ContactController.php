<?php

namespace App\Http\Controllers;

use App\Model\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Contact::paginate(20);
        return view('contacts.index', compact('records'));
    }

    public function complaint()
    {
        $records = Contact::where('type', 'complaint')->paginate(10);
//        if ($records->type = 'complaint') {
            return view('contacts.complaint', compact('records'));
//        }
//        return view('contacts.index', compact('records'));
    }

    public function suggestion()
    {
        $records = Contact::where('type', 'suggestion')->paginate(10);
            return view('contacts.suggestion', compact('records'));
    }

    public function enquiry()
    {
        $records = Contact::where('type', 'enquiry')->paginate(10);
            return view('contacts.enquiry', compact('records'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Contact::findOrFail($id);
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
