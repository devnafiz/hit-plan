<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Division;
use App\Models\Backend\MasterPlanPlot;
use App\Models\Backend\Section;
use App\Models\Backend\Tender;
use App\Models\Backend\TenderPlot;
use App\Models\Backend\TenderPublish;
use Illuminate\Http\Request;

class CommercialTenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.content.commercial_tender.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // session()->remove('set_url');
        // dd(session()->get('set_url'));
        if (empty(session()->get('set_url'))) {
            session()->put('set_url', "step-one");
        }
        $division = Division::get(['division_name', 'division_id']);
        $section = Section::get(['section_id', 'section_name']);
        $masterplanPlot = MasterPlanPlot::get(['id', 'plot_number']);
        return view('backend.content.commercial_tender.create', compact('section', 'division', 'masterplanPlot'));
    }


    public function stepper(Request $request, $slug)
    {
        // dd($request->seturl);
        if ($request->seturl == "step-one") {
            $landDetails = $this->cmTenderValidation();
            $newsPublish = $this->tenderPublishValidation();
            $onlineDetails = $this->tenderPublishNewValidation();
            session()->put('land_details', $landDetails);
            session()->put('publish_newspaper', $newsPublish);
            session()->put('online_apply', $onlineDetails);
            session()->put('set_url', "step-two");
        }

        if ($request->seturl == "step-two") {
            $masterplanplot = $this->masterPlanValidation();
            session()->put('masterplan_plot', $masterplanplot);
            session()->put('set_url', "step-three");
        }
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = session()->get('land_details');
        $tenderCreate = null;

        if ($data) {
            $data['tender_type'] = "commercial";
            $data['tender_details'] = $request->details;
            $tenderCreate = Tender::insertGetId($data);
        }

        if ($tenderCreate) {
            $tenderPlots = session()->get('masterplan_plot');
            if ($tenderPlots) {
                foreach ($tenderPlots['masterplan_plot'] as $key => $value) {
                    $value['tender_id'] = $tenderCreate;
                    $value['masterplan_id'] = $data['masterplan_id'];
                    $value['schedule_no'] = $key + 1;
                    TenderPlot::insert($value);
                }
                session()->remove('masterplan_plot');
            }

            $publishNewsPaper = session()->get('publish_newspaper');
            if ($publishNewsPaper) {
                foreach ($publishNewsPaper['tender'] as $key => $value) {
                    $value['tender_id'] = $tenderCreate;
                    TenderPublish::insert($value);
                }
                session()->remove('publish_newspaper');
            }

            session()->remove('set_url');
            session()->remove('land_details');

            return redirect()
                ->back()
                ->withFlashSuccess('নতুন দরপত্র সফলভাবে যুক্ত করা হয়েছে');
        } else {
            return redirect()
                ->back()
                ->withFlashWarning('দরপত্র যুক্ত হইনি !');
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
        dd("Under Development");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd("Under Development");
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd("Under Development");
    }

    public function plotLengthWidth(Request $request)
    {
        $masterplanPlot = MasterPlanPlot::where('id', $request->id)->get(['id', 'plot_length', 'plot_width', 'total_sft'])->first();
        return response($masterplanPlot);
    }

    public function cmTenderValidation()
    {
        return request()->validate([
            'tender_no' => 'required',
            'division_id' => 'required|numeric|max:100',
            'district_id' => 'required|numeric|max:100',
            'kachari_id' => 'required|numeric|max:100',
            'upazila_id' => 'required|numeric|max:100',
            'station_id' => 'required|numeric|max:100',
            'masterplan_id' => 'required|numeric',
            'application_fee' => 'required|numeric',
            'tender_date' => 'nullable|date',
        ]);
    }

    public function tenderPublishValidation()
    {
        return request()->validate([
            'tender.*.tender_online_rcv_date' => 'required|date',
            'tender.*.tender_online_rcv_time' => 'nullable|date_format:H:i',
            'tender.*.tender_online_end_date' => 'required|date',
            'tender.*.tender_online_end_time' => 'nullable|date_format:H:i',
            'tender.*.tender_dd_rcv_date' => 'required|date',
            'tender.*.tender_dd_rcv_time' => 'nullable|date_format:H:i',
            'tender.*.tender_open_date' => 'required|date',
            'tender.*.tender_open_time' => 'nullable|date_format:H:i',
        ]);
    }

    public function tenderPublishNewValidation()
    {
        return request()->validate([
            'newspaper.*.published_newspaper_name' => 'nullable|string',
            'newspaper.*.published_newspaper_date' => 'nullable|date',
        ]);
    }

    public function masterPlanValidation()
    {
        return request()->validate([
            'masterplan_plot.*.plot_number' => 'required|string',
            'masterplan_plot.*.plot_length' => 'required|numeric',
            'masterplan_plot.*.plot_width' => 'required|numeric',
            'masterplan_plot.*.total_sft' => 'required',
            'masterplan_plot.*.plot_size' => 'required',
        ]);
    }
}
