<?php

namespace App\Http\Controllers;

use App\Models\Backend\CaseDetails;
use Illuminate\Http\Request;
use App\Models\Backend\District;
use App\Models\Backend\Division;
use App\Models\Backend\Kachari;
use App\Models\Backend\LandType;
use App\Models\Backend\Mouja;
use App\Models\Backend\plot;
use App\Models\Backend\Record;
use App\Models\Backend\Station;
use App\Models\Backend\Upazila;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use App\Models\Backend\CaseDate;
use App\Models\Backend\CaseDistrict;
use App\Models\Backend\CaseInfo;

class CaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
      
        $casedetails = CaseInfo::with('caseDate','disMoujas')->orderByDesc('id')->paginate(20);
        //dd($casedetails);
        
        return view('backend.content.case.index', compact('casedetails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['division'] = Division::get(['division_name', 'division_id']);
        $data['kachari'] = Kachari::get(['kachari_name', 'kachari_id']);
        $data['districts'] = District::get(['district_name', 'district_id']);
        $data['upazila'] = Upazila::get(['upazila_name', 'upazila_id']);
        $data['record'] = Record::get(['id', 'record_name']);
        $data['station'] = Station::get(['station_id', 'station_name']);
        $data['mouja'] = Mouja::get(['mouja_id', 'mouja_name']);
        $data['land_type'] = LandType::get(['land_type_id', 'land_type']);
        return view('backend.content.case.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $case_info_data = $this->caseInfoValidation();
       // dd($case_info_data);
        $case_district_data = $this->caseDistrictValidation();
          //dd($case_district_data);
        $case_date_data = $this->caseDateValidation();

        try{
            DB::transaction(function () use ($request, $case_info_data, $case_district_data, $case_date_data){

               // dd($case_info_data);
             
                 // Uploading case file if exists.

                 if ($request != null && !empty($request->file('case_doc'))) {
                    $case_doc = uniqid() . '.' . $request->case_doc->getClientOriginalExtension();
                    $request->case_doc->move(public_path('uploads/case/'), $case_doc);
                    $case_info_data['case_doc'] = $case_doc;
                }
                //dd($case_info_data);
                $Case_id = CaseInfo::insertGetId($case_info_data);
                //dd($Case_id);

                //case  date  insert 
                if($case_date_data){
                    $short_order = $case_date_data['short_order'];
                    //dd($short_order);
                    $case_next_date = $case_date_data['case_next_date']; 

                    $data = [
                       
                        'case_id' => $Case_id,
                        'short_order' => $short_order,
                        'case_next_date' => $case_next_date,
                    ];
                    CaseDate::create($data);


                }
                //dd($case_district_data['mouja']);
                foreach ($case_district_data['mouja'] as $mouja) {
                    //dd($mouja['division']['division_id']);
                    if (array_key_exists('plot_id', $mouja) &&  $mouja['plot_id']) {
                        $mouja['plot_id'] = json_encode($mouja['plot_id']);
                    } else {
                        $mouja['plot_id'] = json_encode([]);
                    }
                    $mouja['case_id'] = $Case_id;
                    CaseDistrict::create($mouja);
                }





            });
            return redirect()
            ->back()
            ->withFlashSuccess('নতুন মামলা সফলভাবে যুক্ত করা হয়েছে');


        }catch(\Throwable $th){

            return redirect()->back()->withFlashDanger('মামলাটি সংযুক্ত হইনি');
        }

        /*unset($request['_token']);*/
        $caseupload = CaseDetails::insert($case_info_data);

        if ($caseupload) {
            return redirect()->back()->withFlashSuccess("মামলার তথ্য সফলভাবে যুক্ত করা হয়েছে");
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
        
        $casedetails = CaseInfo::with('moujaDetails', 'divisionDetails', 'districtDetails', 'kachariDetails', 'stationDetails', 'upazilaDetails')->findOrFail($id);
        //dd($casedetails);
        $caseDate = CaseDate::where('case_id',$id)->orderByDesc('id')->get();
        $caseDistrict = CaseDistrict::with('moujaDetails', 'divisionDetails', 'districtDetails', 'kachariDetails', 'stationDetails', 'upazilaDetails')->where('case_id',$id)->get();
        return view('backend.content.case.case_information', compact('casedetails','caseDate','caseDistrict'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $data['division'] = Division::get(['division_name', 'division_id']);
        $data['kachari'] = Kachari::get(['kachari_name', 'kachari_id']);
        $data['districts'] = District::get(['district_name', 'district_id']);
        $data['upazila'] = Upazila::get(['upazila_name', 'upazila_id']);
        $data['record'] = Record::get(['id', 'record_name']);
        $data['station'] = Station::get(['station_id', 'station_name']);
        $data['mouja'] = Mouja::get(['mouja_id', 'mouja_name']);
        $data['land_type'] = LandType::get(['land_type_id', 'land_type']);
        $data['casedetails'] = CaseInfo::with('moujaDetails', 'divisionDetails', 'districtDetails', 'kachariDetails', 'stationDetails', 'upazilaDetails')->findOrFail($id);

        //$caseInfo= CaseDistrict::where('case_id',$id)->first();
        $caseInfos= CaseDistrict::where('case_id',$id)->orderBy('id','DESC')->get();
        //dd($caseInfos);
        
       
     

        $data['records'] = Record::pluck('record_name', 'id');
        $data['lastCaseDate']= CaseDate::where('case_id', $id)->orderBy('id','desc')->first();  

        //dd($caseInfo);
        foreach($caseInfos as $caseInfo){
           
            $caseInfo =CaseDistrict::where('id',$caseInfo->id)->first();
       
        if(!empty($caseInfo->division_id)){
          
        
       
        $data['kacharis'] = Kachari::where('division_id', $caseInfo->division_id)->get(['kachari_name', 'kachari_id']);
        $data['districtes'] = District::where('division_id', $caseInfo->division_id)->get(['district_name', 'district_id']);
       // dd($caseInfo->kachari_id,$caseInfo->district_id);
        //$data['upazilas'] = Upazila::where('district_id', $caseInfo->district_id)->get(['upazila_name', 'upazila_id']);
       
       // $data['stations'] = Station::where('district_id', $caseInfo->district_id)->get(['station_name', 'station_id']);   
       
     
        
        $data['moujas'] = Mouja::where('station_id', $caseInfo->station_id)->where('division_id', $caseInfo->division_id)->with('ledger')->get(['mouja_id', 'mouja_name']);
       
         //dd($data['moujas']);
         $ledgers = [];
       
         $plots = [];
 
         if (!empty( $data['moujas'])) {
            //dd($data['moujas']);
             foreach ($data['moujas'] as $mouja) {
                 $ledgers[] =  $mouja->ledger;
                
             }
         }
         //dd($ledgers);
         $data['plots'] = plot::get();
         $data['ledgers'] =$ledgers;
        }
    }  
  

        $data['disMoujas'] = CaseDistrict::where('case_id', $id)->get();
       //dd($data['disMoujas']);
        $data['casedis']= CaseDistrict::where('case_id',$id)->first();
        //dd( $data['ledgers']);
        return view('backend.content.case.edit', $data);
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
        $case_info_data = $this->caseInfoValidation();
        //dd($case_info_data);
        $caseDistrict_data = $this->caseDistrictValidation();
        //dd($caseDistrict_data);
        $case_date_data = $this->caseDateValidation();

        if (!empty($request->file('case_doc'))) {
            $case_doc = uniqid() . '.' . $request->case_doc->getClientOriginalExtension();
            $request->case_doc->move(public_path('uploads/case/'), $case_doc);
            $case_info_data['case_doc'] = $case_doc;
        }

        $case_info= CaseInfo::where('id', $id)->first();
        $case_info->update($case_info_data);

        if (count($caseDistrict_data['mouja']) > 0) {
            CaseDistrict::where('case_id', $id)->delete();
            foreach ($caseDistrict_data['mouja'] as $mouja) {
                //dd($mouja);
                $mouja['case_id'] = $id;
                if (array_key_exists('plot_id', $mouja)) {
                    $mouja['plot_id'] = json_encode($mouja['plot_id']);
                } else {
                    $mouja['plot_id'] = json_encode([]);
                }
                CaseDistrict::create($mouja);
            }
        }
        return redirect()
            ->back()
            ->withFlashSuccess('মামলার তথ্য সফলভাবে সংশোধন করা হয়েছে');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $caseinfo = CaseInfo::find($id);
        if (!$caseinfo) {
            return response(["msg" => "Invalid Delete Request!", 'icon' => "error"]);
        }

        CaseInfo::destroy($caseinfo->id);
        return response(["msg" => "মামলার তথ্য সফলভাবে মুছে ফেলা হয়েছে", 'icon' => "success"]);
    }
    //delete divion in   edit

    public function divisionDelete($id){

        $delete_case_division= CaseDistrict::find($id);
        if ($delete_case_division) {
          
            $delete_case_division->delete();
            return response(['msg' => 'Division remove']);
        }
    }

    public function caseInfoValidation()
    {
        $case_info_data = request()->validate([
            'case_no' => 'required|string',
            'court_name' => 'required|string',
            'accuser_name' => 'required|string',
            'accuser_address' => 'nullable|string',
            'accuser_phone' => 'nullable|string| max:14',
            'defendant_name' => 'required|string',
            'defendant_address' => 'nullable|string',
            'defendant_phone' => 'nullable|string',
            'appeal_case_no' => 'nullable|numeric',
            'appeal_court_name' => 'nullable|string',
            'appeal_short_order' => 'nullable|string',
            'appeal_mamla_next_date' => 'nullable|string',
            'comments' => 'nullable|string',
            'sfref' => 'nullable|string',
            'sfdate' => 'nullable|string',
            'sfrefno' => 'nullable|string',
            'sffromdate' => 'nullable|string',
            'case_summary' => 'nullable|string',
            'case_doc' => 'nullable|file',
            'user_id' => 'nullable|numeric|max:255',
            
        ]);

        return $case_info_data;
    }

    public function caseDistrictValidation()
    {
         $case_district_data=request()->validate([
            'mouja.*.division_id' => 'nullable|numeric',
            'mouja.*.kachari_id' => 'nullable|numeric',
            'mouja.*.district_id' => 'nullable|numeric',
            'mouja.*.upazila_id' => 'nullable|numeric',
            'mouja.*.station_id' => 'nullable|numeric',
            'mouja.*.mouja_id' => 'nullable|numeric',
            'mouja.*.record_name' => 'nullable|numeric',
            'mouja.*.ledger_id' => 'nullable|numeric',
            'mouja.*.plot_id' => 'nullable',
            'mouja.*.property_amount' => 'nullable',
        
         ]);

         return $case_district_data;


    }

    public function caseDateValidation()
    {
         $case_date_data=request()->validate([
            'short_order' => 'nullable|string',
            'case_next_date' => 'nullable|string',
    
         ]);

         return $case_date_data;


    }
}
