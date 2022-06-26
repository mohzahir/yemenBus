<?php

namespace App\Http\Controllers\Admin;

use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::orderBy('id','desc')->paginate(15);
        return view('cities.index',[
            'cities' => $cities
        ]);
    }
    public function create()
    { 
        return view('cities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|min:2',
            'country' => 'required|int|in:1,2',
        ]);

        City::create([
            'name' => $request->name, 
            'country' => $request->country,
        ]);

        return redirect()->route('admin.city.index')->with('success','تم اضافة المدينة بنجاح');
    }

    public function edit($id)
    {
        $city=City::where('id',$id)->first();
         return view('cities.edit')->with('city',$city);

    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100|min:2',
            'country' => 'required|int|in:1,2',
        ]);

        $city = City::findOrFail($id);
            $city->name = $request->name;
            $city->country = $request->country;
            $city->save();

        return redirect()->route('admin.city.index')->with('success','تم تعديل المدينة بنجاح');
    }

    public function delete($id)
    {
        $city = City::findOrFail($id);
       $city->delete();

       return response()->json(['success' => 'deleted successfully']);
    }
}
