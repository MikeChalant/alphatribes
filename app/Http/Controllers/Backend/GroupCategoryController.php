<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GroupCategory;
use Illuminate\Http\Request;

class GroupCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = GroupCategory::paginate(20);
        return view('group_categories.index')->with(['categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('group_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name'=>['string','required']]);
        $category = new GroupCategory();
        $category->category_name = $request->name;
        $category->save();
        return redirect()->back()->with(['alert'=>'success','message'=>'Save Succesful']);
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
        $category = GroupCategory::findOrFail($id);
        $category->category_name = $request->name;
        $category->save();
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
        $category = GroupCategory::findOrFail($id);
        $category->delete();
        return redirect()->back()->with(['alert'=>'success','message'=>'Delete Successful']);
    }

    public function searchCategory(Request $request)
    {
        $categories = GroupCategory::query()
            ->where('category_name', 'like', '%'.$request->q.'%')
            ->paginate(20);
        return view('group_categories.index')->with(['categories'=>$categories]);
    }
}
