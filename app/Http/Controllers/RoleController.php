<?php

namespace App\Http\Controllers;

use App\Model\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $records = Role::paginate(20);
        return view('roles.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
//        dd($request->all());
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
            'permissions_list' => 'required|array',
        ], [
            'name.required' => 'يجب ادخال الاسم',
            'display_name.required' => 'يجب ادخال الاسم المعروض',
            'permissions_list.required' => 'يجب اختيا الصلاحيات الخاصه به',
        ]);

        $record = Role::create($request->all());
        $record->permissions()->attach($request->permissions_list);
        flash()->success("تم اضافه الرتبه بنجاح");
        return redirect(route('role.index'));
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
        $model = Role::findOrFail($id);
        return view('roles.edit', compact('model'));
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
        $records = Role::findOrFail($id);
        $records->update($request->all());
        $records->permissions()->sync($request->permissions_list);
        flash()->success('تم التعديل بنجاح');
        return redirect(route('role.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Role::findOrFail($id);
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
