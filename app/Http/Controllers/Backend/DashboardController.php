<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'usersCount' => User::count(),
            'groupsCount' => Group::count(),
            'publicGroupsCount' => Group::where('group_type', 'public')->count(),
            'privateGroupsCount' => Group::where('group_type', 'private')->count(),
            
        ];
        return view('dashboard')->with($data);
    }
}
