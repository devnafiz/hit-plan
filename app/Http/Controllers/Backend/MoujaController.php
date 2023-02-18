<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\Backend\Division;
use App\Models\Backend\Mouja;
use Illuminate\Support\Facades\Validation;

use App\Http\Controllers\Controller;
use App\Models\Backend\District;
use App\Models\Backend\Kachari;
use App\Models\Backend\Record;
use App\Models\Backend\Station;
use App\Models\Backend\Upazila;

class MoujaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.content.mouja.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['division'] = Division::get(['division_name', 'division_id']);
        return view('backend.content.mouja.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mouja_data = $this->moujaDataValidation();
        $add_mouja = Mouja::insert($mouja_data);

        if ($add_mouja) {
            return redirect()
                ->back()
                ->withFlashSuccess('মৌজা সফলভাবে যুক্ত করা হয়েছে');
        }

        return redirect()
            ->back()
            ->withFlashWarning('মৌজা যুক্ত হইনি !');
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
        $mouja = Mouja::where('mouja_id', $id)->first();

        $division = Division::pluck('division_name', 'division_id');
        $district = District::pluck('district_name', 'district_id');
        $record = Record::pluck('record_name', 'id');
        $upazila = Upazila::pluck('upazila_name', 'upazila_id');
        $station = Station::pluck('station_name', 'station_id');
        $kachari = Kachari::pluck('kachari_name', 'kachari_id');
        return view('backend.content.mouja.edit', compact('mouja', 'division', 'district', 'kachari', 'upazila', 'station', 'record'));
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
        $mouja_validate_data = $this->moujaDataValidation();
        //dd($mouja_validate_data);
        unset($mouja_validate_data['_token'], $mouja_validate_data['_method']);

        //$mouja_update = Mouja::where('mouja_id', $id)->update($mouja_validate_data);
        $mouja_update = Mouja::where('mouja_id', $id)->update($mouja_validate_data);

        if ($mouja_update) {
            return redirect()
                ->route('admin.mouja.index')
                ->withFlashSuccess('মৌজা সফলভাবে সংশোধন করা হয়েছে');
        }
        return redirect()
            ->back()
            ->withFlashWarning('মৌজা সংশোধন হইনি !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        

        $mouja = Mouja::where('mouja_id', $id)->first();
       
        if (!$mouja) {
            return response(["msg" => "Invalid Delete Request!", 'icon' => "error"]);
        }
        
        Mouja::where('mouja_id', $mouja->mouja_id)->delete();
        return response(["msg" => "Mouja Deleted", 'icon' => "success"]);
    }

    public function moujaDataValidation()
    {
        $data = request()->validate([
            'division_id' => 'required|numeric|max:255',
            'district_id' => 'required|numeric|max:255',
            'kachari_id' => 'required|numeric|max:255',
            'upazila_id' => 'required|numeric|max:255',
            'station_id' => 'required|numeric|max:255',
            'mouja_name' => 'required|string|max:255',
        ]);

        return $data;
    }
}
