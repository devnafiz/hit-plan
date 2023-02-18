<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\AgriOwner;
use App\Models\Backend\MasterPlan;
use App\Models\Backend\MasterPlanPlot;
use Illuminate\Http\Request;

class MasterPlanPlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.content.masterplan_plot.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function masterPlanPlotCreate($id)
    {
        $masterplans = MasterPlan::get(['id', 'masterplan_no']);
        return view('backend.content.masterplan_plot.create', compact('masterplans', 'id'));
    }

    public function create()
    {
        $masterplans = MasterPlan::get(['id', 'masterplan_no']);
        return view('backend.content.masterplan_plot.create', compact('masterplans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $masterplan_plot = $this->masterplanMoujaValidation();
        foreach ($masterplan_plot['masterplan_plot'] as $key => $ms_plot) {
            $ms_plot['masterplan_id'] = $request->masterplan_id;
            $masterplanplot_data = MasterPlanPlot::create($ms_plot);
        }
        if ($masterplanplot_data) {
            return redirect()->route('admin.masterplan.create')->withFlashSuccess("নতুন মাস্টারপ্লান প্লট সফলভাবে যুক্ত করা হয়েছে");
        } else {
            return redirect()->back()->withFlashWarning("মাস্টারপ্লান প্লট যুক্ত হইনি");
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
        return view('backend.content.masterplan_plot.masterplan_plot_info', compact('masterplan', 'masterPlanPlot'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $masterplan = MasterPlan::findOrFail($id);
        $masterplan_plot = MasterPlanPlot::where('masterplan_id', $id)->paginate(20);
        return view('backend.content.masterplan_plot.edit', compact('masterplan_plot', 'masterplan'));
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
        $masterplan_plot = $this->masterplanMoujaValidation();
        foreach ($masterplan_plot['masterplan_plot'] as $key => $ms_plot) {
            if (array_key_exists('masterplanplot_id', $ms_plot)) {
                $plotId = $ms_plot['masterplanplot_id'];
                unset($ms_plot['masterplanplot_id']);
                $ms_plot['masterplan_id'] =  $masterplan_plot['masterplan_id'];
                $masterplanplot_data = MasterPlanPlot::where('id', $plotId)->update($ms_plot);
            } else {
                $ms_plot['masterplan_id'] =  $masterplan_plot['masterplan_id'];
                $masterplanplot_data = MasterPlanPlot::insert($ms_plot);
            }
        }

        if ($masterplanplot_data) {
            return redirect()->back()->withFlashSuccess("মাস্টারপ্লান প্লট সফলভাবে তথ্য সংশোধন করা হয়েছে");
        } else {
            return redirect()->back()->withFlashWarning("মাস্টারপ্লান প্লট তথ্য সংশোধন হইনি");
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
        $masterplan_plot = MasterPlanPlot::find($id)->delete();
        if ($masterplan_plot) {
            return response(['msg' => 'মাস্টারপ্লান প্লট সফলভাবে মুছেফেলা হয়েছে']);
        }
    }

    public function masterplanMoujaValidation()
    {
        return request()->validate([
            'masterplan_plot.*.plot_number' => 'required|string',
            'masterplan_plot.*.plot_length' => 'nullable|numeric',
            'masterplan_plot.*.plot_width' => 'nullable|numeric',
            'masterplan_plot.*.total_sft' => 'required',
            'masterplan_plot.*.plot_size' => 'nullable',
            'masterplan_plot.*.plot_comments' => 'nullable',
            'masterplan_plot.*.masterplanplot_id' => '',
            'masterplan_id' => 'required',
        ]);
    }
}
