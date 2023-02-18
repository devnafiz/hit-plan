<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Backend\ComTenderRate;
use App\Models\Backend\MasterPlanPlot;
use App\Models\Backend\Tender;
use App\Models\Backend\TenderPlot;

class TenderApplyController extends Controller
{
    public function applyingForm($id)
    {
        session()->put('stepper', 'step-one');
        $tender = Tender::where('id', $id)->with('stationDetails', 'tenderPlotDetails', 'masterplanDetails')->first();
        $tender_rate = ComTenderRate::select('com_rate')->where('station_id', $tender->station_id)->first();
        return view('frontend.pages.tender-apply-form', compact('tender', 'tender_rate'));
    }

    public function plotLengthWidth(Request $request)
    {
        $masterplanPlot = TenderPlot::where('id', $request->id)->get(['id', 'plot_length', 'plot_width', 'total_sft'])->first();
        return response($masterplanPlot);
    }

    public function stepperForm()
    {
        session()->put('stepper', 'step-one');
        $applicat_data = $this->applicantDataValidation();
        unset($applicat_data['terms_and_conditions']);
        session()->put('tender_applicant', $applicat_data);
        return redirect()->back();
    }

    public function invoice()
    {
        return view('admin.pages.report.invoice-large');
    }

    public function store(Request $request)
    {
    }

    public function applicantDataValidation()
    {
        request()->validate([
            'applicant_name' => 'required|string',
            'flexRadioDefault' => 'required|string',
            'applicant_gadiant' => 'required|string',
            'age' => 'required|numeric',
            'profession' => 'required|string',
            'applicant_phone' => 'required|string',

            'present_village' => 'required|string',
            'present_post' => 'required|string',
            'present_thana' => 'required|string',
            'present_district' => 'required|string',
            'permanent_village' => 'required|string',
            'permanent_post' => 'required|string',
            'permanent_thana' => 'required|string',
            'permanent_district' => 'required|string',

            'tender_id' => 'required|string',
            'station' => 'required|string',
            'masterplan_no' => 'required|string',
            'plot_id' => 'required|string',
            'per_acore_amount' => 'required|string',
            'payorder_no' => 'required|string',
            'terms_and_conditions' => 'required',
            'application_date' => 'required|date',

        ]);
    }
}
