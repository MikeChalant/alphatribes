<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\GroupUser;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupMemberController extends Controller
{
    // List all group members
    public function index($id)
    {
        $members = GroupUser::where('group_id', $id)->select('user_id')->paginate(100);
        $membersId = [];
        foreach($members as $member){
            array_push($membersId, $member->user_id);
        }
        $users = User::whereIn('id', $membersId)
            ->select('id','name','user_image','last_seen')->paginate(100);

        return $this->appResponse(true, 'success', '', ['members'=>$users,'group_id'=>$id],200);
    }

    // Add multiple members by group owner/admin
    public function addMembers(Request $request)
    {
        //Check if user is group admin/owner
        $adminUser = GroupUser::where('user_id', auth()->id())->first();
        if(!in_array($adminUser->role, [GroupUser::GROUP_ROLE_ADMIN, GroupUser::GROUP_ROLE_OWNER])){
            return $this->appResponse(true,'error','You must be an admin to perform action',[],403);
        } 

        for($i = 0; $i < count($request->user_id); $i++){
            //Check if user already exists in group
            $user = GroupUser::where('user_id', $request->user_id[$i])->where('group_id', $request->group_id)->first();
            if($user){
                continue;
            }
            $groupUser = new GroupUser();
            $groupUser->group_id = $request->group_id;
            $groupUser->user_id = $request->user_id[$i];
            $groupUser->role = null;
            $groupUser->save();
        }
        
        return $this->appResponse(true,'success','Member(s) saved',[],201);
    }

    
    // Join free group
    public function joinFreeGroup(Request $request)
    {
        //Check if user already exists in group
        $user = GroupUser::where('user_id', $request->user_id)->where('group_id', $request->group_id)->first();
        if(!empty($user)){
            return $this->appResponse(true,'success','Already a member',[],200);
        }
        $groupUser = new GroupUser();
        $groupUser->group_id = $request->group_id;
        $groupUser->user_id = $request->user_id;
        $groupUser->role = null;
        $groupUser->save();

        return $this->appResponse(true,'success','Join successful',[],201);

    }

    // Subscribe to a paid group
    public function joinPaidGroup(Request $request)
    {
        //Check if user already exists in group
        $user = GroupUser::where('user_id', $request->user_id)->where('group_id', $request->group_id)->first();
        if($user){
            return $this->appResponse(true,'success','Already a member',[],204);
        }
        $groupUser = new GroupUser();
        $groupUser->group_id = $request->group_id;
        $groupUser->user_id = $request->user_id;
        $groupUser->role = null;
        $groupUser->save();

        $subscription = new Subscription();
        $subscription->user_id = $request->user_id;
        $subscription->group_id = $request->group_id;
        $subscription->plan = $request->plan;
        $subscription->subscription_start = Carbon::now();
        $subscription->subscription_end = $this->subscriptionEnd($request->plan);
        $subscription->save();
        
        return $this->appResponse(true,'success','Join successful',['subscription_id'=>$subscription->id],201);
    }

    //show detail of a group member
    public function show($id)
    {
        $user = User::where('id', $id)->select('name','username','about','user_image')->first();
        if(empty($user)){
            return $this->appResponse(false,'error','Unknown user Id',[],404);
        }
        return $this->appResponse(true,'success','',['user'=>$user],200);

    }

    // Determine when the subscription ends
    private function subscriptionEnd($plan)
    {
        switch($plan){
            case $plan === 'onetime':
                return null;
            case $plan === 'daily':
                return Carbon::now()->addDay(1);
            case $plan === 'weekly':
                return Carbon::now()->addDays(7);
            case $plan === 'monthly':
                return Carbon::now()->addMonth(1);
            case $plan === 'yearly':
                return Carbon::now()->addYear(1);
        }
    }
   
}
