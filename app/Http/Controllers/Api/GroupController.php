<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Group;
use Stripe\StripeClient;
use App\Models\GroupUser;
use Illuminate\Http\Request;
use App\Models\GroupCategory;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::select('id','group_name','description','image','paid_group')->paginate(20);
        return $this->appResponse(true, 'success','',['groups'=>$groups], 200);
    }

    /**
     * Show group category list.
     *
     * @return \Illuminate\Http\Response
     */
    public function groupCategories()
    {
        $categories = GroupCategory::get();
        return $this->appResponse(true,'success','',['categories'=>$categories],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'group_name' => ['required','string','max:35'],
            'group_category_id' => ['required','numeric'],
            'group_image' => ['nullable','mimes:png,jpg,gif,jpeg'],
            'description' => ['nullable','string','max:255'],
            'support_email' => ['nullable','email'],
            'stripe_connect_email' => ['nullable','email'],
            'lintree_website_url' => ['nullable','url'],
            'paid_group' => ['required','numeric'],
            'group_type' => ['required','string','max:10']
        ]
        );
        if($validator->fails()){
            return $this->appResponse(false,'error',$validator->errors()->all(),$validator->errors(),422);
        }

        // upload Image
        if($request->hasFile('group_image')){
            $orignalName = $request->file('group_image')->getClientOriginalName();
            $fileExt = $request->file('group_image')->getClientOriginalExtension();
            $fileName = pathinfo($orignalName, PATHINFO_FILENAME);
            $imageName = time().'_'.$fileName.'.'.$fileExt;

            $imageFolder = 'images/group_profile';
            if(!is_dir(public_path($imageFolder)))
                mkdir(public_path($imageFolder), 0777);

            Image::make($request->file('group_image')->getRealPath())
                ->fit(350,350)
                ->save($imageFolder.'/'.$imageName);
        }

        $group = new Group();
        $group->group_name = $request->group_name;
        $group->user_id = auth()->id();
        $group->group_category_id = $request->group_category_id;
        $group->description = $request->description;
        $group->support_email = $request->support_email ?? null;
        $group->stripe_connect_email = $request->stripe_connect_email ?? null;
        $group->lintree_website_url = $request->lintree_website_url ?? null;
        $group->paid_group = $request->paid_group;
        $group->group_type = $request->group_type;
        $group->image = ($request->hasFile('group_image')) ? $imageName : null;
        $group->save();

        // Add owner to group members
        $groupUser = new GroupUser();
        $groupUser->group_id = $group->id;
        $groupUser->user_id = auth()->id();
        $groupUser->role = GroupUser::GROUP_ROLE_OWNER;
        $groupUser->save();

        return $this->appResponse(true,'success','',['group_id'=>$group->id],201);
    }

    // Search group using name and category as query string
    public function search(Request $request)
    {
        $groups = Group::where('group_name', 'like', $request->group_name .'%')
            ->where('group_category_id', $request->category_id)->get();

        if(!count($groups)){
            return $this->appResponse(false,'error','No group found',[],200);
           
        }
        
        return $this->appResponse(true,'success','',['groups'=>$groups],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::query()
            ->with('category')
            ->where('id', $id)
            ->select('id','group_category_id','group_name','description','support_email','lintree_website_url','group_type','paid_group','image',
                'payment_type','onetime_cost','daily_cost','weekly_cost','monthly_cost','yearly_cost','billing_currency','trial_duration',
                'total_subscribers','created_at')->first();
        if(empty($group)){
            return $this->appResponse(false,'error','Unknown Group Id',[],404);
        }

        return $this->appResponse(true,'success','',['group'=>$group],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Make sure user is admin
        $user = GroupUser::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('role', GroupUser::GROUP_ROLE_ADMIN)
            ->first();
        if(empty($user)){
            return $this->appResponse(false, 'error', 'Action not permited', [], 403);
        }
        $group = Group::query()
            ->with('category')
            ->where('id', $id)
            ->select('id','group_category_id','group_name','description','stripe_connect_email','support_email','lintree_website_url',
                'group_type','paid_group','image','payment_type','onetime_cost','daily_cost','weekly_cost','monthly_cost','yearly_cost',
                'billing_currency','trial_duration','total_subscribers','created_at')->first();
                
        return $this->appResponse(true,'success','',['group'=>$group],200);
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
        // Make sure user is admin
        $user = GroupUser::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('role', GroupUser::GROUP_ROLE_ADMIN)
            ->first();
        if(empty($user)){
            return $this->appResponse(false, 'error', 'Action not permited', [], 403);
        }

        //Update group
        $validator = Validator::make($request->all(),
        [
            'group_name' => ['required','string','max:35'],
            'group_category_id' => ['required','numeric'],
            'group_image' => ['nullable','mimes:png,jpg,gif,jpeg'],
            'description' => ['nullable','string','max:255'],
            'support_email' => ['nullable','email'],
            'stripe_connect_email' => ['nullable','email'],
            'lintree_website_url' => ['nullable','url'],
            'paid_group' => ['required','numeric'],
            'group_type' => ['required','string','max:10'],
            'payment_type' => ['nullable','string','max:20'],
            'onetime_cost' => ['nullable','float'],
            'daily_cost' => ['nullable','float'],
            'weekly_cost' => ['nullable','float'],
            'monthly_cost' => ['nullable','float'],
            'yearly_cost' => ['nullable','float'],
            'billing_currency' => ['nullable','float'],
            'trial_duration' => ['nullable','numeric']
        ]
        );
        if($validator->fails()){
            return $this->appResponse(false,'error',$validator->errors()->all(),$validator->errors(),422);
        }

        // upload Image
        if($request->hasFile('group_image')){
            $orignalName = $request->file('group_image')->getClientOriginalName();
            $fileExt = $request->file('group_image')->getClientOriginalExtension();
            $fileName = pathinfo($orignalName, PATHINFO_FILENAME);
            $imageName = time().'_'.$fileName.'.'.$fileExt;

            $imageFolder = 'images/group_profile';
            if(!is_dir(public_path($imageFolder)))
                mkdir(public_path($imageFolder), 0777);

            Image::make($request->file('group_image')->getRealPath())
                ->fit(500,500)
                ->save($imageFolder.'/'.$imageName);
        }

        $group = Group::where('id', $id)->first();
        $group->group_name = $request->group_name;
        $group->group_category_id = $request->group_category_id;
        $group->description = $request->description;
        $group->support_email = $request->support_email ?? null;
        $group->stripe_connect_email = $request->stripe_connect_email ?? null;
        $group->lintree_website_url = $request->lintree_website_url ?? null;
        $group->paid_group = $request->paid_group;
        $group->group_type = $request->group_type;
        $group->payment_type = $request->payment_type;
        $group->onetime_cost = $request->onetime_cost ?? null;
        $group->daily_cost = $request->daily_cost ?? null;
        $group->weekly_cost = $request->weekly_cost ?? null;
        $group->monthly_cost = $request->monthly_cost ?? null;
        $group->yearly_cost = $request->yearly_cost ?? null;
        $group->billing_currency = $request->billing_currency ?? null;
        $group->trial_duration = $request->trial_duration ?? null;
        if($request->hasFile('group_image')) {
            $group->image = $imageName ;
        }
        $group->save();

        return $this->appResponse(true,'success','',['group_id'=>$group->id],201);
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

    public function savePaymentOption(Request $request, $id)
    {
        if($request->payment_option === 'onetime'){
            $validator = Validator::make($request->all(),
            [
                'payment_option' => ['required','string','max:20'],
                'onetime_cost' => ['required','numeric','min:0.01'],
            ]
            );
            if($validator->fails()){
                return $this->appResponse(false,'error',$validator->errors()->all(),$validator->errors(),422);
            }
        }else{
            $validator = Validator::make($request->all(),
            [
                'payment_option' => ['required','string','max:20'],
                'daily_cost' => ['required','numeric','min:0.01'],
                'weekly_cost' => ['required','numeric','min:0.01'],
                'monthly_cost' => ['required','numeric','min:0.01'],
                'yearly_cost' => ['required','numeric','min:0.01'],
            ]
            );
            if($validator->fails()){
                return $this->appResponse(false,'error',$validator->errors()->all(),$validator->errors(),422);
            }
        }

        $group = Group::where('id', $id)->first();
        if(empty($group)){
            return $this->appResponse(false,'error','Unknown group id',[],404);
        }
        $group->payment_type = $request->payment_option;
        $group->onetime_cost = $request->onetime_cost ?? null;
        $group->daily_cost = $request->daily_cost ?? null;
        $group->weekly_cost = $request->weekly_cost ?? null;
        $group->monthly_cost = $request->monthly_cost ?? null;
        $group->yearly_cost = $request->yearly_cost ?? null;
        $group->billing_currency = $request->billing_currency;
        $group->save();
        
        return $this->appResponse(true,'success','',['group_id'=>$group->id],201);
    }

    public function saveTrial(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
        ['trial_period'=>['required','numeric','min:1']]
            );
        if($validator->fails()){
            return $this->appResponse(false,'error',$validator->errors()->all(),$validator->errors(),422);
        }
        $group = Group::where('id', $id)->first();
        if(empty($group)){
            return $this->appResponse(false,'error','Unknown group id',[],404);
        }
        $group->trial_duration = $request->trial_period;
        $group->save();
        return $this->appResponse(true,'success','',['group_id'=>$group->id],201);

    }

    public function saveStripeConnect(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            ['stripe_connect_email'=>['required','email','max:100']]
        );
        if($validator->fails()){
            return $this->appResponse(false,'error',$validator->errors()->all(),$validator->errors(),422);
        }

        $user = User::find(auth()->id());

        //Update stripe connection Id and email if not exists
        if(empty($user->stripe_connect_id)){
            
            // Get Stripe connect account Id
            $stripe = new StripeClient(config('app.stripe_secret_key'));
            $StripeAccount = $stripe->accounts->create([
                "type" => "express",
                "email"=>$request->stripe_connect_email,
            ]);

            //update user detail
            $user->stripe_connect_email = $request->stripe_connect_email;
            $user->stripe_connect_account_id = $StripeAccount->id;
            $user->save();
            return $this->appResponse(true,'success','stripe connect successful',[],201);
        }

        return $this->appResponse(true,'success','stripe already connected',[],200);
    }
}
