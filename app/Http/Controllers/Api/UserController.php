<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->input(),[
            'fullname' => ['required','string','max:100'],
            'bio' => ['required','string','max:150'],
            'username' => ['required','string','max:30','unique:users,username'],
            'website_lintree_url' => ['nullable','url'],
            'user_image' => ['nullable','mimes:jpg,png,jpeg,gif']
        ]);

        if($validator->fails()){
            return $this->appResponse(false, 'error', $validator->errors()->all(), $validator->errors(), 422);
        }

        $user = User::where('id', auth()->id())->first();
        if(empty($user)){
            return $this->appResponse(false, 'error', 'User not found', [], 404);
        }

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
                ->fit(500,500)
                ->save($imageFolder.'/'.$imageName);
        }

        $user->name = $request->fullname;
        $user->about = $request->bio;
        $user->username = $request->username;
        $user->website_lintree_url = $request->website_lintree_url ?? null;
        if($request->hasFile('user_image')){
            $user->user_image = $imageName;
        }
        $user->save();

        return $this->appResponse(true, 'success', 'updated',[],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
