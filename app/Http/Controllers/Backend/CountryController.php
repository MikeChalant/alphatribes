<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::paginate(20);
        return view('countries.index')->with(['countries'=>$countries]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('countries.create');
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
            'name' => ['required','string','max:100','unique:countries,country_name'],
            'code' => ['required', 'string', 'max:4','unique:countries,country_code'],
            'currency_code' => ['required','string','min:3' ,'max:3','unique:countries,currency_code']
        ]);

        $country = new Country();
        $country->country_name = $request->name;
        $country->country_code = $request->code;
        $country->currency_code = $request->currency_code;
        $country->save();
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
        $country = Country::findOrFail($id);
        $country->country_name = $request->country_name;
        $country->country_code = $request->country_code;
        $country->currency_symbol = $request->currency_symbol;
        $country->save();
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
        $country = Country::findOrFail($id);
        $country->delete();
        return redirect()->back()->with(['alert'=>'success','message'=>'Delete Successful']);
    }

    public function searchCountry(Request $request)
    {
        $countries = Country::query()
            ->where('country_name', 'like', '%'.$request->q.'%')
            ->orWhere('country_code', 'like', $request->q.'%')
            ->paginate(20);
        return view('countries.index')->with(['countries'=>$countries]);
    }
}
