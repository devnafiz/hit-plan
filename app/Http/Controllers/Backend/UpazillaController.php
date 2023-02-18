<?php

namespace App\Http\Controllers\Backend;

use App\Models\Backend\Upazila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Backend\Division;
use App\Models\Backend\District;
use App\Models\Backend\Kachari;
use App\Models\Backend\Record;
use App\Models\Backend\Station;



class UpazillaController

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $upazilla = Upazila::all();
        return view('backend.content.upazilla.index', compact('upazilla'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $districts = districts();
        $division = Division::get(['division_name', 'division_id']);
        return view('backend.content.upazilla.create', compact('districts','division'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $user = Auth::user()->id;
        $data = $this->UpazillaValidation();
        
        if (Upazila::create($data)) {
            return redirect()->route("admin.upazilla.index")->withFlashSuccess('Upazila created successfully');
        }
        return redirect()->back()->withFlashWarning('Something went wrong !');
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
        $upazilla = Upazila::where('upazila_id', $id)->first();
        $division = Division::pluck('division_name', 'division_id');
        //dd($division);
        $district = District::pluck('district_name', 'district_id');
         
        $kachari = Kachari::pluck('kachari_name', 'kachari_id');
       
        return view('backend.content.upazilla.edit', compact('upazilla', 'district','division','kachari'));
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
        $data = $this->UpazillaValidation();
        if (Upazila::where('upazila_id', $id)->update($data)) {
            return redirect()->route("admin.upazilla.index")->withFlashSuccess('Upazila updated successfully');
        }
        return redirect()->back()->withFlashWarning('Something went wrong !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if (Upazila::where('upazilla_id', $id)->delete()) {
        //     return redirect()->back()->withFlashSuccess('Upazila deleted successfully');
        // }
        // return redirect()->back()->withFlashWarning('Something went wrong !');

        
        $upazila = Upazila::where('upazila_id',$id)->first();
        if (!$upazila) {
            return response(["msg" => "Invalid Delete Request!", 'icon' => "error"]);
        }
        
        Upazila::where('upazila_id', $upazila->upazila_id)->delete();
        return response(["msg" => "Upazila Deleted", 'icon' => "success"]);
    }

    public function UpazillaValidation()
    {
        $data = request()->validate([
            'division_id' => 'required|numeric|max:255',
            'district_id' => 'required|numeric|max:255',
            'kachari_id' => 'required|numeric|max:255',
            'upazila_name' => 'required|string',
            
        ]);
        return $data;
    }
}
