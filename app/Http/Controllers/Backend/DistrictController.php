<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\Backend\District;
use Illuminate\Support\Facades\Auth;
use App\Models\Backend\Division;
use App\Models\Backend\Kachari;


class DistrictController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $districts = District::all();
        return view('backend.content.district.index', compact('districts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['division'] = Division::get(['division_name', 'division_id']); 
        return view('backend.content.district.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $data = $this->DistrictValidation();
       
        if (District::create($data)) {
            return redirect()->route("admin.district.index")->withFlashSuccess('District created successfully');
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
        $district = District::where('district_id', $id)->first();
        $division = Division::pluck('division_name', 'division_id');
        $kachari = Kachari::pluck('kachari_name', 'kachari_id');
        return view('backend.content.district.edit', compact('district','division','kachari'));
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
        $data = $this->DistrictValidation();
        $district = District::where('district_id', $id)->update($data);
        if ($district) {
            return redirect()->route("admin.district.index")->withFlashSuccess('District updated successfully');
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
        $district = District::where('district_id', $id)->first();
       
        if (!$district) {
            return response(["msg" => "Invalid Delete Request!", 'icon' => "error"]);
        }
        
        District::where('district_id', $district->district_id)->delete();
        return response(["msg" => "District Deleted", 'icon' => "success"]);
    
    }

    public function DistrictValidation()
    {
        $data = request()->validate([
            'division_id' => 'required|numeric|max:255',
            'kachari_id' => 'required|numeric|max:255',
            'district_name' => 'required|string',
           
        ]);

        return $data;
    }
}
