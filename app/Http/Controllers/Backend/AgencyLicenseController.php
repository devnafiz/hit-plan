<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Backend\Division;
use App\Models\Backend\District;
use App\Models\Backend\Kachari;
use App\Models\Backend\Upazila;
use App\Models\Backend\Station;
use App\Models\Backend\LandType;
use App\Models\Backend\Mouja;
use App\Models\Backend\plot;
use App\Models\Backend\Record;
use App\Models\Backend\Section;
use App\Models\Backend\LicenseIds;
use Illuminate\Support\Facades\DB;
use App\Models\Backend\AgencyLicense;
use App\Models\Backend\AgencyOwner;
use App\Models\Backend\AgencyLicenseOwner;
use App\Models\Backend\AgencyBalam;
use App\Models\Backend\AgencyDDInfo;
use App\Models\Backend\AgencyMouja;
use Auth;


class AgencyLicenseController extends Controller
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
        //dd($station);    
        $division_id = request('division_id', "");
        $kachari_id = request('kachari_id', "");
        $district_id = request('district_id', "");
        $upazila_id = request('upazila_id', "");
        $station_id = request('station_id', "");
        $mouja_id = request('mouja_id', "");
        $license_no = request('license_no', "");
        $balam = AgencyBalam::with('agencyOwner');



        $searchResult = AgencyLicense::with('agencyOwner', 'balam', 'agencyMoujas');


        if (
            $division_id || $kachari_id || $district_id || $upazila_id || $station_id || $license_no
        ) {
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

            if ($license_no) {
                $searchResult = $searchResult->where('generated_id', $license_no);
            }

            $searchResult = $searchResult->orderByDesc('id')->paginate(20);
        } else {
            $searchResult = $searchResult->orderByDesc('id')->paginate(20);
            //dd($searchResult);
        }
        return view('backend.content.agency_license.index', compact('searchResult', 'division', 'district', 'kachari', 'upazila', 'station', 'balam'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->can('agriculture create')) {
            $data['division'] = Division::get(['division_name', 'division_id']);
            $data['record'] = Record::get(['id', 'record_name']);
            $data['section'] = Section::get(['section_id', 'section_name']);
            $data['land_type'] = LandType::get(['land_type_id', 'land_type']);

            return view('backend.content.agency_license.create', $data);
        } else {

            return redirect()->back()->withFlashDanger('Permission denied');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $license_owner = $this->licenseOwnerValidation();
        //dd($license_owner);
        $license_information = $this->licenseInformationValidation();

        $license_mouja_data = $this->AgencyDistrictValidation();
        //dd($license_mouja_data);
        $lastPayment = $this->lastPayment();


        try {

            $transaction_id = DB::transaction(function () use ($request, $license_owner, $license_information, $license_mouja_data, $lastPayment) {
                // Uploading noksha file if exists.
                if ($request != null && !empty($request->file('land_map_certificate'))) {
                    $land_map_certificate = uniqid() . '.' . $request->land_map_certificate->getClientOriginalExtension();
                    $request->land_map_certificate->move(public_path('uploads/agency/'), $land_map_certificate);
                    $license_information['land_map_certificate'] = $land_map_certificate;
                }
                $agencyLicense = new AgencyLicense();
                //$agency_id = AgencyLicense::insertGetId($license_information);
                $agency_id = $agencyLicense->insertGetId($license_information);
                $serialNum = $agencyLicense->count();

                $agencyLicense = new AgencyLicense;
                $agency_id = $agencyLicense->insertGetId($license_information);
                $serialNum = $agencyLicense->count();

                $generate_id = null;
                if ($agency_id) {
                    $division_id = $license_mouja_data['mouja']['0']['division_id'];
                    $license_type = 4;
                    $div_license = $division_id . $license_type;
                    $generate_id = generate_number($serialNum, 6, $div_license);
                    //AgencyLicense::find($agency_id)->update(['generated_id' => $generate_id]);
                    $agencyLicense->find($agency_id)->update(['generated_id' => $generate_id]);
                }

                $ownerCreator = "";
                //dd($license_owner['owner']);

                if ($license_owner['owner']['0']) {
                    $ownerCreator = AgencyOwner::insertGetId($license_owner['owner']['0']);
                    //dd($ownerCreator);

                    $data = [
                        'license_id' => $agency_id,
                        'owner_id' => $ownerCreator,
                    ];

                    AgencyLicenseOwner::create($data);
                }

                // Creating owners and also inserting the owners id to join table with license
                if (
                    $lastPayment['from_date']['license_fee_from_yy'] && $lastPayment['from_date']['license_fee_from_mm'] && $lastPayment['from_date']['license_fee_from_dd'] &&
                    $lastPayment['to_date']['license_fee_to_yy'] && $lastPayment['to_date']['license_fee_to_mm'] && $lastPayment['to_date']['license_fee_to_dd']
                ) {
                    $from_date = $lastPayment['from_date']['license_fee_from_yy'] . '-' . $lastPayment['from_date']['license_fee_from_mm'] . '-' . $lastPayment['from_date']['license_fee_from_dd'];
                    $to_date = $lastPayment['to_date']['license_fee_to_yy'] . '-' . $lastPayment['to_date']['license_fee_to_mm'] . '-' . $lastPayment['to_date']['license_fee_to_dd'];
                    $data = [
                        'owner_id' => $ownerCreator,
                        'license_no' => $generate_id,
                        'license_type' => 'agency',
                        'from_date' =>  $from_date,
                        'to_date' => $to_date,
                    ];

                    $balam_id = AgencyBalam::insertGetId($data);
                    $DDdata = [
                        'balam_agency_id' => $balam_id,
                        'j1' => $generate_id . rand(0, 5),
                        'j1_date' => date('Y-m-d'),
                    ];
                    //dd($DDdata);
                    AgencyDDInfo::insert($DDdata);
                }
                //dd($license_mouja_data['mouja']);


                // Multiple moujas creating with license id
                foreach ($license_mouja_data['mouja'] as $mouja) {
                    // dd($mouja);
                    if (array_key_exists('plot_id', $mouja) &&  $mouja['plot_id']) {
                        $mouja['plot_id'] = json_encode($mouja['plot_id']);
                    } else {
                        $mouja['plot_id'] = json_encode([]);
                    }
                    $mouja['license_id'] = $agency_id;
                    AgencyMouja::create($mouja);
                }

                return $generate_id;
            });
            //dd($transaction_id);
            if ($transaction_id) {
                $phone = $license_owner['owner'][0]['phone'];
                if (get_setting('mim_sms_message')) {
                    $txt = get_setting('mim_sms_message') . ":" . $transaction_id . "\r\n" . "বাংলাদেশ রেলওয়ে";
                } else {
                    $txt = "আপনার নামীয় রেলভূমির অস্থায়ী লাইসেন্সটি REMS এ এন্ট্রি হয়েছে। বাংলাদেশ রেলওয়ে, লাইসেন্স নং:" . $transaction_id;
                }

                if ($phone) {
                    send_ware_SMS($txt, $phone);
                }
            }

            return redirect()
                ->back()
                ->withFlashSuccess(' সংস্থা লাইসেন্স সফলভাবে যুক্ত করা হয়েছে');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withFlashDanger('সংস্থা  লাইসেন্সটি সংযুক্ত হইনি');
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
        //dd($id);
        $license = AgencyLicense::with('record', 'agencyMoujas', 'division', 'district', 'kachari', 'station', 'upazila')->find($id);

        $license_owner = $license->agencyOwner;
        //dd($license_owner);
        $license_balam = AgencyBalam::with('dd')->where('license_no', $license->generated_id)->get();

        $license_balam_dd = AgencyDDInfo::get();
        // dd($license_balam_dd);
        return view('backend.content.agency_license.license_information', compact('license', 'license_owner', 'license_balam', 'license_balam_dd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //dd($id);
        $division = Division::get(['division_name', 'division_id']);
        $kachari = Kachari::pluck('kachari_name', 'kachari_id');
        $district = District::pluck('district_name', 'district_id');
        //$upazila = Upazila::pluck('upazila_name', 'upazila_id');
        $upazila = Upazila::get(['upazila_name', 'upazila_id']);
        //dd($upazila);
        $station = Station::pluck('station_name', 'station_id');
        $stations = Station::get(['station_name', 'station_id']);
        $mouja = Mouja::get(['mouja_id', 'mouja_name']);

        $section = Section::pluck('section_name', 'section_id');
        $sections = Section::get(['section_id', 'section_name']);

        $land_types = LandType::get(['land_type_id', 'land_type']);
        $land_type = LandType::pluck('land_type', 'land_type_id');



        $mouja = Mouja::get(['mouja_id', 'mouja_name']);


        $license = AgencyLicense::with('agencyOwner', 'record', 'agencyMoujas')->findOrFail($id);
        //dd($license);
        $lastPayment = AgencyBalam::where('license_no', $license->generated_id)->orderBy('id', 'desc')->first();
        $last_payment_date = [];
        if ($lastPayment) {
            $last_payment_date['balam_id'] = $lastPayment->id;
            if ($lastPayment->from_date) {
                $last_payment_date['from_date']['year'] = date('Y', strtotime($lastPayment->from_date));
                $last_payment_date['from_date']['month'] = date('m', strtotime($lastPayment->from_date));
                $last_payment_date['from_date']['day'] = date('d', strtotime($lastPayment->from_date));
            }
            if ($lastPayment->to_date) {
                $last_payment_date['to_date']['year'] = date('Y', strtotime($lastPayment->to_date));
                $last_payment_date['to_date']['month'] = date('m', strtotime($lastPayment->to_date));
                $last_payment_date['to_date']['day'] = date('d', strtotime($lastPayment->to_date));
            }
        }


        $agencyMoujas = AgencyMouja::where('license_id', $id)->get();
        //dd($agencyMoujas);

        $records = Record::pluck('record_name', 'id');



        foreach ($agencyMoujas as $agencyMouja) {

            $agencyMouja = AgencyMouja::where('id', $agencyMouja->id)->first();

            if (!empty($agencyMouja->division_id)) {

                $kacharis = Kachari::where('division_id', $agencyMouja->division_id)->get(['kachari_name', 'kachari_id']);
                $districtes = District::where('division_id', $agencyMouja->division_id)->get(['district_name', 'district_id']);
                $upazilas = Upazila::where('district_id', $agencyMouja->district_id)->get(['upazila_name', 'upazila_id']);
                $moujas = Mouja::where('station_id', $agencyMouja->station_id)->where('division_id', $agencyMouja->division_id)->with('ledger')->get(['mouja_id', 'mouja_name']);
                //dd($moujas);


            }


            $licenseMoujas = AgencyMouja::where('license_id', $id)->get();
        }

        $ledgers = [];

        $plots = [];

        if (!empty($moujas)) {
            //dd($data['moujas']);
            foreach ($moujas as $mouja) {
                $ledgers[] =  $mouja->ledger;
            }
        }
        //dd($ledgers);
        $plots = plot::get();
        $ledgers = $ledgers;
        return view('backend.content.agency_license.edit', compact('plots', 'ledgers', 'moujas', 'records', 'division', 'land_type', 'license', 'kachari', 'district', 'upazila', 'station', 'licenseMoujas', 'last_payment_date', 'agencyMoujas', 'kacharis', 'districtes', 'upazilas', 'stations', 'mouja'));
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
        $license_owner_data = $this->licenseOwnerValidation();
        //dd($license_owner_data);

        $license_information = $this->licenseInformationValidation();
        $license_mouja_data = $this->AgencyDistrictValidation();
        $lastPayment = $this->lastPayment();
        //dd($lastPayment);

        if (!empty($request->file('land_map_certificate'))) {
            $documents = uniqid() . '.' . $request->land_map_certificate->getClientOriginalExtension();
            $request->land_map_certificate->move(public_path('uploads/agency/'), $documents);
            $licenseDetails['land_map_certificate'] = $documents;
        }

        $agency_license = AgencyLicense::where('id', $id)->first();
        $agency_license->update($license_information);

        if ($license_owner_data['owner']) {
            $generate_id = $agency_license->generated_id;
            foreach ($license_owner_data['owner'] as $key => $owner) {

                //dd($owner['id']);
                if (!empty($owner['id'])) {
                    AgencyOwner::where('id', $owner['id'])->update($owner);
                } else {
                    unset($owner['id']);
                    $newOwner = AgencyOwner::create($owner);
                    // Creating owners and also inserting the owners id to join table with license
                    AgencyLicenseOwner::create([
                        'license_id' => $id,
                        'owner_id' => $newOwner->id
                    ]);
                }
            }
        }

        if (
            $lastPayment['from_date']['license_fee_from_yy'] && $lastPayment['from_date']['license_fee_from_mm'] && $lastPayment['from_date']['license_fee_from_dd'] &&
            $lastPayment['to_date']['license_fee_to_yy'] && $lastPayment['to_date']['license_fee_to_mm'] && $lastPayment['to_date']['license_fee_to_dd']
        ) {
            $from_date = $lastPayment['from_date']['license_fee_from_yy'] . '-' . $lastPayment['from_date']['license_fee_from_mm'] . '-' . $lastPayment['from_date']['license_fee_from_dd'];
            $to_date = $lastPayment['to_date']['license_fee_to_yy'] . '-' . $lastPayment['to_date']['license_fee_to_mm'] . '-' . $lastPayment['to_date']['license_fee_to_dd'];

            $data = [
                'from_date' => date('Y-m-d h:i:s', strtotime($from_date)),
                'to_date' => date('Y-m-d h:i:s', strtotime($to_date)),
            ];
            if ($request->balam_id) {
                AgencyBalam::where('id', $request->balam_id)->update($data);
            } else {
                $data = [
                    'owner_id' => $license_owner_data['owner'][0]['id'],
                    'license_no' => $generate_id,
                    'license_type' => 'agency',
                    'from_date' => $from_date,
                    'to_date' => $to_date,
                ];
                AgencyBalam::create($data);
            }
        }
        // Multiple moujas creating with license id
        // mouja update

        if ($license_mouja_data && count($license_mouja_data['mouja']) > 0) {
            AgencyMouja::where('license_id', $id)->delete();
            foreach ($license_mouja_data['mouja'] as $mouja) {
                $mouja['license_id'] = $id;
                if (array_key_exists('plot_id', $mouja)) {
                    $mouja['plot_id'] = json_encode($mouja['plot_id']);
                } else {
                    $mouja['plot_id'] = json_encode([]);
                }
                AgencyMouja::create($mouja);
            }
        }
        return redirect()
            ->back()
            ->withFlashSuccess(' সংস্থা লাইসেন্স সফলভাবে সংশোধন করা হয়েছে');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getBalam = AgencyLicense::find($id);
        if (!$getBalam) {
            return response(["msg" => "Invalid Delete Request!", 'icon' => "error"]);
        }
        $getBalam->delete();
        return response(["msg" => "Agency License Deleted", 'icon' => "success"]);
    }
    //  agency division delete
    public  function  divisionDelete(Request $request, $id)
    {

        $delete_agency_division = AgencyMouja::find($id);
        if ($delete_agency_division) {

            $delete_agency_division->delete();
            return response(['msg' => 'Division remove']);
        }
    }

    public function licenseOwnerValidation()
    {
        $license_owner_data = request()->validate([
            'owner.*.id' => 'nullable|string',
            'owner.*.name' => 'required|string',
            'owner.*.agency_position' => 'nullable|string',
            'owner.*.phone' => 'nullable|string| max:15',
            'owner.*.address' => 'nullable|string',

        ]);

        return $license_owner_data;
    }

    public function AgencyDistrictValidation()
    {
        $agency_district_data = request()->validate([
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

        return $agency_district_data;
    }

    public function licenseInformationValidation()
    {
        $license_data = request()->validate([
            'demand_notice_number' => 'nullable|string',
            'design_and_date' => 'nullable|string',
            'others' => 'nullable|string',
            'land_map_certificate' => 'nullable|file',
            'user_id' => 'nullable|numeric|max:255',
        ]);
        return $license_data;
    }
    public function lastPayment()
    {
        return request()->validate([
            'from_date.license_fee_from_dd' => 'nullable',
            'from_date.license_fee_from_mm' => 'nullable',
            'from_date.license_fee_from_yy' => 'nullable',
            'to_date.license_fee_to_dd' => 'nullable',
            'to_date.license_fee_to_mm' => 'nullable',
            'to_date.license_fee_to_yy' => 'nullable',
        ]);
    }
}
