<?php

namespace App\Http\Controllers;

use App\Model\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
//        return view('settings.edit');
        return view('settings.edit')->with('settings', Setting::first());
    }


    public function update(Request $request)
    {

        $this->validate($request, [
            'phone' => 'required',
            'email' => 'required',
            'text' => 'required',
            'contents' => 'required',
            'image' => 'nullable|image',
            'whats_app' => 'required',
            'instagram' => 'required',
            'you_tube' => 'required',
            'twitter' => 'required',
            'facebook' => 'required',
            'max_credit' => 'nullable',
            'commission' => 'nullable',
        ]);

        $setting = Setting::first();

        if ( $request->hasFile('image')  ) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('uploads/setting', $image_new_name);

            $setting->image = 'uploads/setting/'.$image_new_name;
        }

        $setting->phone = $request->phone;
        $setting->email = $request->email;
        $setting->text = $request->text;
        $setting->contents = $request->contents;
        $setting->whats_app = $request->whats_app;
        $setting->instagram = $request->instagram;
        $setting->you_tube = $request->you_tube;
        $setting->twitter = $request->twitter;
        $setting->facebook = $request->facebook;
        $setting->max_credit = $request->max_credit;
        $setting->commission = $request->commission;
        $setting->save();

        flash()->success("تم التعديل بنجاح");
        return redirect()->back();


    }
}
