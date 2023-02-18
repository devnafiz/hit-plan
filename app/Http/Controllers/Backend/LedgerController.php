<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Acquisition;
use App\Models\Backend\District;
use App\Models\Backend\Division;
use App\Models\Backend\Kachari;
use App\Models\Backend\LandType;
use App\Models\Backend\ledger;
use App\Models\Backend\MasterPlan;
use App\Models\Backend\MasterPlanPlot;
use App\Models\Backend\Mouja;
use App\Models\Backend\plot;
use App\Models\Backend\Record;
use App\Models\Backend\Section;
use App\Models\Backend\Station;
use App\Models\Backend\Upazila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('backend.content.ledger.index');
    }

    public function create()
    {
        $data['division'] = Division::get(['division_name', 'division_id']);
        $data1['record'] = Record::get(['id', 'record_name']);
        $data2['section'] = Section::get(['section_id', 'section_name']);
        $data['land_type'] = LandType::get(['land_type_id', 'land_type']);
        return view('backend.content.ledger.create', $data, $data1)->with($data2);
    }

    public function fetchKachari(Request $request)
    {
        $data['kachari'] = Kachari::where('division_id', $request->division_id)->get(['kachari_name', 'kachari_id']);
        return response()->json($data);
    }

    public function fetchDistrict(Request $request)
    {
        $data['district'] = District::where('kachari_id', $request->kachari_id)->get(['district_name', 'district_id']);
        return response()->json($data);
    }

    public function fetchUpazila(Request $request)
    {
        $data['upazila'] = Upazila::where('district_id', $request->district_id)->get(['upazila_name', 'upazila_id']);
        return response()->json($data);
    }

    public function fetchStation(Request $request)
    {
        $data['station'] = Station::where('upazila_id', $request->upazila_id)->get(['station_name', 'station_id']);
        return response()->json($data);
    }

    public function fetchMouja(Request $request)
    {
        $data['mouja'] = Mouja::where('station_id', $request->station_id)->get(['mouja_name', 'mouja_id']);
        return response()->json($data);
    }

    public function fetchLandType(Request $request)
    {
        $data['land_type'] = LandType::get(['land_type_id', 'land_type']);
        return response()->json($data);
    }

    public function fetchSection(Request $request)
    {
        $data['section'] = Section::where('section_id', $request->section_id)->get(['section_id', 'section_name']);
        return response()->json($data);
    }

    public function fetchRecord(Request $request)
    {
        $data['record'] = Record::get(['id', 'record_name']);
        return response()->json($data);
    }

    public function fetchLedger(Request $request)
    {
        $data['ledger'] = ledger::where('mouja_id', $request->mouja_id)->where('record_name', $request->record_id)->get(['id', 'ledger_number']);
        return response()->json($data);
    }

    public function fetchMasterPlan(Request $request)
    {
        $data['masterplan'] = MasterPlan::where("station_id", $request->station_id)->get(['id', 'masterplan_no']);
        // $masterplan_data = MasterPlanMouja::where('ledger_id', $request->ledger_id)->with('masterPlan')->get();
        // $data = [];
        // $cheker = [];

        // foreach ($masterplan_data as $key => $value) {
        //     if (!in_array($value->masterPlan->id, $cheker)) {
        //         $cheker[] = $value->masterPlan->id;
        //         $data['masterplan'][$key] = [
        //             'id' => $value->masterPlan->id,
        //             'masterplan_no' => $value->masterPlan->masterplan_no,
        //         ];
        //     }
        // }

        return response()->json($data);
    }

    public function fetchMasterplanPlot(Request $request)
    {
        $data['masterplanplot'] = MasterPlanPlot::where('masterplan_id', $request->ledger_id)->get(['id', 'plot_number', 'total_sft']);
        return response()->json($data);
    }

    public function fetchPlot(Request $request)
    {
        $data['plot'] = plot::where('ledger_id', $request->ledger_id)->get(['plot_id', 'plot_number', 'land_amount']);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ledger_data = $this->ledgerValidation($request);
        if ($ledger_data->fails()) {
            return response(['errors' => $ledger_data->errors()]);
        }

        $ledger_data = $request->all();
        $ledger_data['ledger_number'] = Ledger::bn2en($ledger_data['ledger_number']);

        $ledgerCheck = Ledger::where('division_id', $ledger_data['division_id'])
            ->where('kachari_id', $ledger_data['kachari_id'])
            ->where('district_id', $ledger_data['district_id'])
            ->where('upazila_id', $ledger_data['upazila_id'])
            ->where('station_id', $ledger_data['station_id'])
            ->where('mouja_id', $ledger_data['mouja_id'])
            ->where('record_name', $ledger_data['record_name'])
            ->where('ledger_number', $ledger_data['ledger_number'])
            ->get();

        if (count($ledgerCheck) > 0) {
            return response(['errors' => 'পূর্বে উক্ত খতিয়ান সংরক্ষণ করা হয়েছে !']);
        }

        if (!empty($request->file('documents'))) {
            $document = $request->file('documents');
            $documents = uniqid() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('uploads/ledger'), $documents);
            $ledger_data['documents'] = $documents;
        }

        unset($ledger_data['_token']);
        $data = ledger::insertGetId($ledger_data);
        return response($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ledger = ledger::findOrFail($id);
        return view('backend.content.ledger.show', compact('ledger'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ledger = Ledger::findOrFail($id);
        $acquisitions = Acquisition::where('ledger_id', $id)->get();
        $division = Division::pluck('division_name', 'division_id');
        $district = District::pluck('district_name', 'district_id');
        $mouja = Mouja::pluck('mouja_name', 'mouja_id');
        $record = Record::pluck('record_name', 'id');
        $section = Section::pluck('section_name', 'section_id');
        $sections = Section::get(['section_id', 'section_name']);

        $upazila = Upazila::pluck('upazila_name', 'upazila_id');
        $station = Station::pluck('station_name', 'station_id');
        $kachari = Kachari::pluck('kachari_name', 'kachari_id');
        $land_types = LandType::get(['land_type_id', 'land_type']);
        $land_type = LandType::pluck('land_type', 'land_type_id');
        return view('backend.content.ledger.edit', compact('kachari', 'upazila', 'station', 'ledger', 'division', 'record', 'section', 'sections', 'land_type', 'district', 'mouja', 'acquisitions', 'id', 'land_types'));
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
        $ledger_data = $this->ledgerUpDataValidation();

        if (!empty($ledger_data['documents'])) {
            $documents = uniqid() . '.' . $request->documents->getClientOriginalExtension();
            $request->documents->move(public_path('uploads/ledger/'), $documents);
            $ledger_data['documents'] = $documents;
        }

        if (Ledger::where('id', $id)->update($ledger_data)) {
            return redirect()
                ->back()
                ->withFlashSuccess('Ledger update Successfully !');
        } else {
            return redirect()
                ->back()
                ->withFlashWarning('Something went wrong !');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (ledger::findOrFail($id)->delete()) {
            return response(['msg' => 'Ledger deleted successfully', 'icon' => 'success']);
        } else {
            return response(['msg' => "it's can't be deleted", 'icon' => 'warning']);
        }
    }


    public function search()
    {
        $division = Division::pluck('division_name', 'division_id');
        $district = District::pluck('district_name', 'district_id');
        $kachari = Kachari::pluck('kachari_name', 'kachari_id');
        $upazila = Upazila::pluck('upazila_name', 'upazila_id');
        $station = Station::pluck('station_name', 'station_id');
        $mouja = Mouja::pluck('mouja_name', 'mouja_id');
        $record = Record::pluck('record_name', 'id');

        $division_id = request('division_id', "");
        $kachari_id = request('kachari_id', "");
        $district_id = request('district_id', "");
        $upazila_id = request('upazila_id', "");
        $station_id = request('station_id', "");
        $mouja_id = request('mouja_id', "");
        $record_name = request('record_name', "");

        $searchResult = Ledger::with('record');

        if ($division_id || $kachari_id || $district_id || $upazila_id || $station_id || $mouja_id || $record_name) {
            if ($division_id) {
                $searchResult = $searchResult->where('division_id', $division_id);
            }

            if ($kachari_id) {
                $searchResult = $searchResult->where('kachari_id', $kachari_id);
            }

            if ($district_id) {
                $searchResult = $searchResult->where('district_id', $district_id);
            }

            if ($upazila_id) {
                $searchResult = $searchResult->where('upazila_id', $upazila_id);
            }

            if ($station_id) {
                $searchResult = $searchResult->where('station_id', $station_id);
            }

            if ($mouja_id) {
                $searchResult = $searchResult->where('mouja_id', $mouja_id);
            }

            if ($record_name) {
                $searchResult = $searchResult->where('record_name', $record_name);
            }

            $searchResult = $searchResult->orderByDesc('id')->paginate(20);
        } else {
            $searchResult = [];
        }

        return view('backend.content.ledger.searchpage', compact('searchResult', 'division', 'district', 'kachari', 'upazila', 'station', 'record', 'mouja'));
    }

    public function ledgerValidation(Request $request)
    {
        $req_data = $request->all();
        return Validator::make($req_data, [
            'division_id' => 'required|numeric|max:255',
            'district_id' => 'required|numeric|max:255',
            'kachari_id' => 'required|numeric|max:255',
            'upazila_id' => 'required|numeric|max:255',
            'station_id' => 'required|numeric|max:255',
            'record_name' => 'required|string|max:255',
            'ledger_number' => 'required|max:11',
            'owner_name' => 'required|string|max:255',
            'owner_address' => 'nullable|string|max:255',
            'mouja_id' => 'required|string|max:255',
            'comments' => 'nullable|string',
            'user_id' => 'required|numeric|max:255',
            'comments_byDataEntry' => 'nullable|string',
            'comments_byDataEntry' => 'nullable|string',
            'comments_byDataEntry' => 'nullable|string',
        ]);
    }

    public function ledgerUpDataValidation()
    {
        return request()->validate([
            'division_id' => 'required|numeric|max:255',
            'district_id' => 'required|numeric|max:255',
            'kachari_id' => 'required|numeric|max:255',
            'upazila_id' => 'required|numeric|max:255',
            'station_id' => 'required|numeric|max:255',
            'record_name' => 'required|string|max:255',
            'ledger_number' => 'required|max:11',
            'owner_name' => 'required|string|max:255',
            'owner_address' => 'nullable|string|max:255',
            'mouja_id' => 'required|string|max:255',
            'comments' => 'nullable|string',
            'user_id' => 'required|numeric|max:255',
            'comments_byDataEntry' => 'nullable|string',
            'comments_byDataEntry' => 'nullable|string',
            'comments_byDataEntry' => 'nullable|string',
            'documents' => 'nullable|file',
        ]);
    }
}
