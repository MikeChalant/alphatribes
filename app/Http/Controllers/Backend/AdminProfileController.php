<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Rules\CurrentPassword;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class AdminProfileController extends Controller
{
    public function index()
    {
        $user = User::where('id', auth()->user()->user_id)->first();
        return view('profile.index')->with(['user'=>$user]);
    }

    public function update(Request $request)
    {
        if($request->hasFile('user_image')){

            // upload Image
            $orignalName = $request->file('user_image')->getClientOriginalName();
            $fileExt = $request->file('user_image')->getClientOriginalExtension();
            $fileName = pathinfo($orignalName, PATHINFO_FILENAME);
            $imageName = time().'_'.$fileName.'.'.$fileExt;
    
            $imageFolder = 'images/profile';
            if(!is_dir(public_path($imageFolder)))
                mkdir(public_path($imageFolder), 0777);
    
            Image::make($request->file('user_image')->getRealPath())
                ->fit(350,350)
                ->save($imageFolder.'/'.$imageName);
        }

        $user = User::findOrFail(auth()->user()->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_no = $request->phone;
        $user->username = $request->username;
        $user->country_id = $request->country_id;
        $user->about = $request->about;
        $user->website_lintree_url = $request->website;
        if($request->hasFile('user_image')){
            $user->user_image = $imageName;
        }
        $user->save();

        $admin = Admin::where('user_id', auth()->user()->user_id)->first();
        $admin->email = $request->email;
        $admin->save();

        return redirect()->back()->with(['alert'=>'success','message'=>'Update Successful']);
    }

    public function changePassword(Request $request)
    {
        // $user = Admin::where('user_id', auth()->user()->user_id)->first();
        // dd($user);
        $request->validate([
            'current_password' => ['required', new CurrentPassword()],
            'passsword' => ['required','string'],
            'confirm_password' => ['required','same:password']
        ]);
        
        $user = Admin::where('user_id', auth()->user()->user_id)->firstOrFail();
        dd($user->password);
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->back()->with(['alert'=>'success','message'=>'Password Changed']);
    }
}
