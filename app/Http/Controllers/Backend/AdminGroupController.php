<?php

namespace App\Http\Controllers\Backend;

use App\Models\Group;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\GroupCategory;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class AdminGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::query()
            ->select('id','group_name','image','support_email','group_type','total_subscribers')
            ->where('blocked', 0)
            ->paginate(50);
        return view('groups.index')->with(['groups'=>$groups]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function blockedGroup()
    {
        $groups = Group::query()
            ->select('id','group_name','image','support_email','group_type','total_subscribers')
            ->where('blocked', 1)
            ->paginate(50);
        return view('groups.blocked')->with(['groups'=>$groups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = GroupCategory::get();
        return view('groups.create')->with(['categories'=>$categories]);
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
            'group_name' => ['required','string','max:35'],
            'category_id' => ['required','numeric'],
            'group_image' => ['nullable','mimes:png,jpg,gif,jpeg'],
            'description' => ['nullable','string','max:255'],
            'support_email' => ['nullable','email'],
            'website' => ['nullable','url'],
            'paid_group' => ['required','numeric']
        ]);

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
        $group->user_id = auth()->user()->user_id;
        $group->group_category_id = $request->category_id;
        $group->description = $request->description;
        $group->support_email = $request->support_email ?? null;
        $group->lintree_website_url = $request->website ?? null;
        $group->paid_group = $request->paid_group;
        $group->group_type = ($request->paid_group === 1) ? GROUP::GROUP_PRIVATE : GROUP::GROUP_PUBLIC;
        $group->image = ($request->hasFile('group_image')) ? $imageName : null;
        $group->save();

        if((int)$request->paid_group === 1){
            return redirect()->route('admin.group.payment_option', $group->id)->with(['alert'=>'success','message'=>'Group Created Successfully']);
        }
        return redirect()->back()->with(['alert'=>'success','message'=>'Group Created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::where('id',$id)->with('user','category')->firstOrFail();
        return view('groups.show')->with(['group'=>$group]);
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
        //
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

    public function block($id)
    {
        $group = Group::where('id', $id)->firstOrFail();
        $group->blocked = 1;
        $group->save();
        return redirect()->back()->with(['alert'=>'success','message'=>'Group Blocked Successfully']);
    }

    public function unblock($id)
    {
        $group = Group::where('id', $id)->firstOrFail();
        $group->blocked = 0;
        $group->save();
        return redirect()->back()->with(['alert'=>'success','message'=>'Group Unblocked Successfully']);
    }

    public function searchGroup(Request $request)
    {
        $groups = Group::query()
            ->where('group_name', 'like', '%'.$request->q.'%')
            ->paginate(20);
        return view('groups.index')->with(['groups'=>$groups]);
    }

    public function paymentOption($id)
    {
        // check if step is completed
        $group = Group::where('id', $id)->firstOrFail();
        if(!empty($group->payment_type)){
            if(!empty($group->stripe_connect_email)){
                return redirect()->route('admin.dashboard')->with(['alert'=>'info','message'=>'Step Already Completed']);
 
            }
            return redirect()->route('admin.create_stripe_connect', $id)->with(['alert'=>'info','message'=>'Payment Option Already Completed']);

        }
        $currency_codes = Country::select('currency_code')->get();
        return view('groups.payment_option')->with(['groupId'=>$id,'currency_codes'=>$currency_codes]);
    }

    public function savePaymentOption(Request $request, $id)
    {
        if($request->payment_option === 'onetime'){
            $request->validate([
                'payment_option' => ['required','string','max:20'],
                'onetime_cost' => ['required','numeric','min:0.01'],
            ]);
        }else{
            $request->validate([
                'payment_option' => ['required','string','max:20'],
                'daily_cost' => ['required','numeric','min:0.01'],
                'weekly_cost' => ['required','numeric','min:0.01'],
                'monthly_cost' => ['required','numeric','min:0.01'],
                'yearly_cost' => ['required','numeric','min:0.01'],
            ]);
        }

        $group = Group::where('id', $id)->firstOrFail();
        $group->payment_type = $request->payment_option;
        $group->onetime_cost = $request->onetime_cost ?? null;
        $group->daily_cost = $request->daily_cost ?? null;
        $group->weekly_cost = $request->weekly_cost ?? null;
        $group->monthly_cost = $request->monthly_cost ?? null;
        $group->yearly_cost = $request->yearly_cost ?? null;
        $group->billing_currency = $request->billing_currency;
        $group->save();
        
        if((int)$request->allow_trial === 1){
            return redirect()->route('admin.group.create_trial',$group->id)->with(['alert'=>'success','message'=>'Payment Option Saved']);
        }
        return redirect()->route('admin.group.create_stripe_connect')->with(['alert'=>'success','message'=>'Payment Option Saved']);
    }

    public function createTrial($id)
    {
        return view('groups.create_trial')->with(['groupId'=>$id]);
    }

    public function saveTrial(Request $request, $id)
    {
        $request->validate(['trial_period'=>['required','numeric','min:0.001']]);
        $group = Group::where('id', $id)->firstOrFail();
        $group->trial_duration = $request->trial_period;
        $group->save();
        return redirect()->route('admin.group.create_stripe_connect', $group->id)->with(['alert'=>'success','message'=>'Trial Period Saved']);

    }

    public function createStripeConnect($id)
    {
        // check if step is completed
        $group = Group::where('id', $id)->firstOrFail();
        if(!empty($group->stripe_connect_email)){
            return redirect()->route('admin.dashboard')->with(['alert'=>'info','message'=>'Step Already Completed']);

        }
        return view('groups.create_stripe_connect')->with(['groupId'=>$id]);
    }

    public function saveStripeConnect(Request $request, $id)
    {
        $request->validate(['stripe_connect_email'=>['required','email','max:100']]);
        $group = Group::where('id', $id)->firstOrFail();
        $group->stripe_connect_email = $request->stripe_connect_email;
        $group->save();
        session()->put('stripe_connect_success','stripe');
        return redirect()->route('admin.group.stripe_connect_success')->with(['alert'=>'success','message'=>'Stripe Connection Successful']);

    }

    public function stripeConnectSuccess()
    {
        if(!session('stripe_connect_success')){
            return redirect('/admin');
        }
        session()->forget('stripe_connect_success');
        return view('groups.stripe_connect_success');
    }
}
