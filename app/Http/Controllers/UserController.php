<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = User::paginate(20);
        return view('users.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name'      =>'required',
            'email' => 'required|email|unique:users,email,' . $request->user()->id,
            'password'  =>'required|confirmed|min:6',
            'roles_list' => 'required'
        ], [
            'name.required' => 'Name is Required',
            'email.required' => 'Email is Required',
            'password.required' => 'Password Id is Required',
            'roles_list.required' => 'Roles List Id is Required'
        ]);
        $request->merge(['password'=>bcrypt($request->password)]);
        $user = User::create($request->except('roles_list'));
        $user->roles()->attach($request->input('roles_list'));
//        $record = User::create($request->all());
        flash()->success("Success");
        return redirect(route('user.index'));
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
        $model = User::findOrFail($id);
        return view('users.edit', compact('model'));
    }

    public function getChangePassword()
    {
        return view('changePassword');
    }

    public function changePassword(Request $request){

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success","Password changed successfully !");

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
        $records = User::findOrFail($id);
        $this->validate($request, [
            'name'      =>'required',
            'email'     =>'required|email|unique:users,email,'.$id,
            'password'  =>'sometimes|nullable|confirmed',
            'roles_list' => 'required'
        ], [
            'name.required' => 'Name is Required',
            'email.required' => 'Email is Required',
            'password.required' => 'Password Id is Required',
            'roles_list.required' => 'Roles List Id is Required'
        ]);
        $records->roles()->sync((array) $request->input('roles_list'));
        $records->update($request->except('password'));
        if (request()->input('password')) {
//            dd($request->password);
            $records->update(['password'=>bcrypt($request->password)]);
        }
        flash()->success('تم التعديل بنجاح');
        return redirect(route('user.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = User::findOrFail($id);
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
