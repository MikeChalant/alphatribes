<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::get()->toArray();
        $users = User::whereIn('id', array_column($admins, 'user_id'))->get();
        return view('users.index')->with(['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['string', 'required', 'max:50', 'min:2'],
            'email' => ['email','required','unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'username' => ['required','unique:users,username'],
            'country_id' => ['required','numeric'],
            'about' => ['required','string','max:255'],
            'user_image' => ['required','mimes:jpg,png,jpeg,gif'],
            'password' => ['required','string'],
            'confirm_password' => ['required','same:password']
        ]);

        // upload Image
        if($request->hasFile('user_image')){
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

        $user = new User();
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

        //create admin login
        $admin = new Admin();
        $admin->user_id = $user->id;
        $admin->email = $user->email;
        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->back()->with(['alert'=>'success','message'=>'Save Successful']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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

        $user = User::findOrFail($id);
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

        $admin = Admin::where('user_id', $id)->first();
        $admin->email = $request->email;
        $admin->save();

        return redirect()->back()->with(['alert'=>'success','message'=>'Update Successful']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        $admin = Admin::where('user_id', $id)->first();
        $admin->delete();

        return redirect()->back()->with(['alert'=>'success','message'=>'Delete Successful']);

    }

    public function searchUser(Request $request)
    {
        $admins = Admin::get()->toArray();
        $users = User::query()
            ->whereIn('id', array_column($admins, 'user_id'))
            ->where('name', 'like', '%'.$request->q.'%')
            ->orWhere('phone_no', 'like', $request->q.'%')
            ->paginate(20);
        return view('users.index')->with(['users'=>$users]);
    }
}
