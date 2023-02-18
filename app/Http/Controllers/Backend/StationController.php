<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\Backend\Division;
use App\Models\Backend\Kachari;
use App\Models\Backend\District;
use App\Models\Backend\Upazila;
use App\Models\Backend\Station;

use Illuminate\Support\Facades\Validation;

use App\Http\Controllers\Controller;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.content.station.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['division'] = Division::get(['division_name', 'division_id']);
        return view('backend.content.station.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $station_data = $this->stationDataValidation();
      
        $add_station = Station::insert($station_data);

        if ($add_station) {
            return redirect()
                ->back()
                ->withFlashSuccess('Station created successfully');
        }

        return redirect()
            ->back()
            ->withFlashWarning('Something went wrong !');
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

        $station = Station::where('station_id', $id)->first();
        $division = Division::pluck('division_name', 'division_id');
        //dd($division);
        $district = District::pluck('district_name', 'district_id');

        $upazila = Upazila::pluck('upazila_name', 'upazila_id');

        $kachari = Kachari::pluck('kachari_name', 'kachari_id');

        /// dd($station);
        return view('backend.content.station.edit', compact('division', 'district', 'kachari', 'upazila', 'station'));
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
        //dd($request->all());
        $station_validate_data=$this->stationDataValidation();
        //dd($station_validate_data);

        unset($station_validate_data['_token'],$station_validate_data['_method']);

        $station_update = Station::where('station_id', $id)->update($station_validate_data);

        if ($station_update) {
            return redirect()
                ->route('admin.station.index')
                ->withFlashSuccess('স্টেশান সফলভাবে সংশোধন করা হয়েছে');
        }
        return redirect()
            ->back()
            ->withFlashWarning('স্টেশান সংশোধন হইনি !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $station = Station::where('station_id', $id)->first();
        if (!$station) {
            return response(["msg" => "Invalid Delete Request!", 'icon' => "error"]);
        }

        Station::where('station_id', $station->station_id)->delete();
        return response(["msg" => "Station Deleted", 'icon' => "success"]);
    }

    public function stationDataValidation()
    {
        $data = request()->validate([
            'division_id' => 'required|numeric|max:255',
            'district_id' => 'required|numeric|max:255',
            'kachari_id' => 'required|numeric|max:255',
            'upazila_id' => 'required|numeric|max:255',
            'station_name' => 'required|string|max:255',
        ]);

        return $data;
    }
}
