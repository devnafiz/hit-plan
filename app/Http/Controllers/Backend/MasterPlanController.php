<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Record;
use App\Models\Backend\Section;
use App\Models\Backend\Division;
use App\Models\Backend\LandType;
use App\Models\Backend\District;
use App\Models\Backend\Kachari;
use App\Models\Backend\ledger;
use App\Models\Backend\MasterPlan;
use App\Models\Backend\MasterPlanMouja;
use App\Models\Backend\MasterPlanPlot;
use App\Models\Backend\Mouja;
use App\Models\Backend\plot;
use App\Models\Backend\Station;
use App\Models\Backend\Upazila;
use Illuminate\Http\Request;
use Session;

class MasterPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $masterplan_no = request('masterplan_mo', "");
        $record_name = request('record_name', "");

        $masterplans = MasterPlan::with('kachari');

        if (
            $division_id || $kachari_id || $district_id || $upazila_id || $station_id || $mouja_id || $masterplan_no ||
            $record_name
        ) {
            if ($division_id) {
                $masterplans = $masterplans->where('division_id', $division_id);
            }

            if ($kachari_id) {
                $masterplans = $masterplans->where('kachari_id', $kachari_id);
            }

            if ($district_id) {
                $masterplans = $masterplans->where('district_id', $district_id);
            }

            if ($upazila_id) {
                $masterplans = $masterplans->where('upazila_id', $upazila_id);
            }

            if ($station_id) {
                $masterplans = $masterplans->where('station_id', $station_id);
            }

            if ($mouja_id) {
                $masterplans = $masterplans->where('mouja_id', $mouja_id);
            }

            if ($masterplan_no) {
                $masterplans = $masterplans->where('masterplan_no', $masterplan_no);
            }

            if ($record_name) {
                $masterplans = $masterplans->where('record_name', $record_name);
            }
            $masterplans = $masterplans->orderByDesc('id')->paginate(20);
        } else {
            $masterplans = $masterplans->orderByDesc('id')->paginate(20);
        }
        return view('backend.content.masterplan.index', compact('masterplans', 'division', 'district', 'kachari', 'upazila', 'station', 'record', 'mouja'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisions = Division::pluck('division_name', 'division_id');
        $kachari = Kachari::pluck('kachari_name', 'kachari_id');
        $district = District::pluck('district_name', 'district_id');
        $upazila = Upazila::pluck('upazila_name', 'upazila_id');
        $station = Station::pluck('station_name', 'station_id');
        $data['division'] = Division::get(['division_name', 'division_id']);
        $data1['record'] = Record::get(['id', 'record_name']);
        $data2['section'] = Section::get(['section_id', 'section_name']);
        $data['land_type'] = LandType::get(['land_type_id', 'land_type']);
        $masterplans = MasterPlan::orderBy('id', 'DESC')->get(['id', 'masterplan_no']);
        return view('backend.content.masterplan.create', compact('masterplans', 'divisions', 'kachari', 'district', 'upazila', 'station'), $data, $data1)->with($data2);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $masterplan_data = $this->masterplanValidation($request);
        $masterPlanCheck = MasterPlan::where('division_id', $masterplan_data['division_id'])
            ->where('kachari_id', $masterplan_data['kachari_id'])
            ->where('district_id', $masterplan_data['district_id'])
            ->where('upazila_id', $masterplan_data['upazila_id'])
            ->where('station_id', $masterplan_data['station_id'])
            ->where('masterplan_no', $masterplan_data['masterplan_no'])
            ->first();

        if ($masterPlanCheck) {
            return redirect()->back()->withFlashDanger("মাস্টারপ্লান নম্বরটি পূর্বে ব্যবহৃত হয়েছে");
        }

        if (!empty($request->file('masterplan_doc'))) {
            $documents = uniqid() . '.' . $request->masterplan_doc->getClientOriginalExtension();
            $request->masterplan_doc->move(public_path('uploads/masterplan/'), $documents);
            $masterplan_data['masterplan_doc'] = $documents;
        }

        $masterplan_data['masterplan_no'] = ledger::bn2en($masterplan_data['masterplan_no']);

        $masterplan_id = MasterPlan::insertGetId($masterplan_data);
        $masterplan_moujas = $this->masterplanMoujaValidation();

        if ($masterplan_id && $masterplan_moujas) {
            // Multiple moujas creating with masterplan id
            foreach ($masterplan_moujas['mouja'] as $mouja) {
                unset($mouja['plotId']);
                if (!empty($mouja['property_amount'])) {
                    $mouja['plot_id'] = json_encode($mouja['plot_id']);
                    $mouja['masterplan_id'] = $masterplan_id;
                    MasterPlanMouja::insert($mouja);
                }
            }
            return redirect()->route('admin.masterplan.create', ['id' => $masterplan_id, 'tab' => 'plots']);
            // ->withFlashSuccess('নতুন মাস্টারপ্লান সফলভাবে যুক্ত করা হয়েছে');
        } else {
            return redirect()
                ->back()
                ->withFlashWaring('নতুন মাস্টারপ্লান যুক্ত হইনি');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $masterplan = MasterPlan::where('id', $id)->with('masterPlanMouja')->first();
        $masterPlanPlot = MasterPlanPlot::where('masterplan_id', $masterplan->id)->paginate(20);
        return view('backend.content.masterplan.masterplan_info', compact('masterplan', 'masterPlanPlot'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $masterplan = MasterPlan::with('masterPlanMouja', 'masterPlanPlot')->findOrfail($id);
        $data['division'] = Division::get(['division_name', 'division_id']);
        $data['district'] = District::pluck('district_name', 'district_id');
        $data['upazila'] = Upazila::pluck('upazila_name', 'upazila_id');
        $data['moujas'] = Mouja::pluck('mouja_name', 'mouja_id');
        $data['station'] = Station::pluck('station_name', 'station_id');
        $data['ledger'] = ledger::pluck('ledger_number', 'id');
        $data['plot'] = plot::get(['plot_number', 'plot_id', 'land_amount']);
        $data['record'] = Record::pluck('record_name', 'id');
        $data['section'] = Section::get(['section_id', 'section_name']);
        $data['kachari'] = Kachari::pluck('kachari_name', 'kachari_id');
        $data['land_type'] = LandType::get(['land_type_id', 'land_type']);
        // dd($masterplan->masterPlanMouja);
        $plots = Plot::get();
        return view('backend.content.masterplan.edit', compact('masterplan', 'data', 'plots'));
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
        $masterplan_data = $this->masterplanValidation($request);
        // $masterPlanCheck = MasterPlan::where('division_id', $masterplan_data['division_id'])
        // ->where('kachari_id', $masterplan_data['kachari_id'])
        // ->where('district_id', $masterplan_data['district_id'])
        // ->where('upazila_id', $masterplan_data['upazila_id'])
        // ->where('station_id', $masterplan_data['station_id'])
        // ->where('masterplan_no', $masterplan_data['masterplan_no'])
        // ->get();

        // if (!empty($masterPlanCheck)) {
        //     return redirect()->back()->withFlashDanger("মাস্টারপ্লান নম্বরটি পূর্বে ব্যবহৃত হয়েছে");
        // }

        if (!empty($request->file('masterplan_doc'))) {
            $documents = uniqid() . '.' . $request->masterplan_doc->getClientOriginalExtension();
            $request->masterplan_doc->move(public_path('uploads/masterplan/'), $documents);
            $masterplan_data['masterplan_doc'] = $documents;
        }

        $masterplan_data['masterplan_no'] = ledger::bn2en($masterplan_data['masterplan_no']);
        MasterPlan::where('id', $id)->update($masterplan_data);
        $masterplan_moujas = $this->masterplanMoujaValidation();
        if ($masterplan_moujas) {
            // Multiple moujas creating with masterplan id
            foreach ($masterplan_moujas['mouja'] as $mouja) {
                $mouja['masterplan_id'] = $id;
                if (array_key_exists('plot_id', $mouja) && $mouja['plot_id']) {
                    $mouja['plot_id'] = json_encode($mouja['plot_id']);
                } else {
                    $mouja['plot_id'] = json_encode([]);
                }
                if (array_key_exists('plotId', $mouja) && $mouja['plotId']) {
                    $mouja_id = $mouja['plotId'];
                    unset($mouja['plotId']);
                    MasterPlanMouja::where('id', $mouja_id)->update($mouja);
                } else {
                    MasterPlanMouja::insert($mouja);
                }
            }
            return redirect()
                ->back()
                ->withFlashSuccess('মাস্টারপ্লান সফলভাবে সংশোধন করা হয়েছে');
        } else {
            return redirect()
                ->back()
                ->withFlashWaring('মাস্টারপ্লান সংশোধন হইনি');
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
        $delete_mouja = MasterPlan::find($id)->delete();
        if ($delete_mouja) {
            return response(['msg' => 'মাস্টারপ্লান সফলভাবে মুছেফেলা হয়েছে']);
        }
    }

    public function moujaRemove($id)
    {
        $delete_mouja = MasterPlanMouja::find($id)->delete();
        if ($delete_mouja) {
            return response(['msg' => 'মাস্টারপ্লান মৌজা সফলভাবে মুছেফেলা হয়েছে']);
        }
    }


    public function masterplanValidation()
    {
        return request()->validate([
            'masterplan_no' => 'required|string',
            'masterplan_name' => 'nullable|string',
            'approval_date' => 'nullable|date',
            'leased_area' => 'nullable|numeric',
            'division_id' => 'required|numeric|max:255',
            'district_id' => 'required|numeric|max:255',
            'kachari_id' => 'required|numeric|max:255',
            'upazila_id' => 'required|numeric|max:255',
            'station_id' => 'required|numeric|max:255',
            'masterplan_doc' => 'nullable|file',
        ]);
    }

    public function masterplanMoujaValidation()
    {
        return request()->validate([
            'mouja.*.mouja_id' => 'nullable|numeric',
            'mouja.*.record_name' => 'nullable|numeric',
            'mouja.*.ledger_id' => 'nullable|numeric',
            'mouja.*.plot_id' => 'nullable',
            'mouja.*.property_amount' => 'nullable|string',
            'mouja.*.plotId' => 'nullable|string',
        ]);
    }
}
