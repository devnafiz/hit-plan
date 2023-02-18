<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Models\Backend\Record;
use App\Models\Backend\Section;
use App\Models\Backend\Division;
use App\Models\Backend\LandType;
use App\Http\Controllers\Controller;
use App\Models\Backend\AgriBalam;
use App\Models\Backend\AgricultureLicense;
use App\Models\Backend\AgriDDInfo;
use App\Models\Backend\AgriLicenseOwner;
use App\Models\Backend\District;
use App\Models\Backend\Kachari;
use App\Models\Backend\AgriMouja;
use App\Models\Backend\AgriOwner;
use App\Models\Backend\Mouja;
use App\Models\Backend\plot;
use App\Models\Backend\Station;
use App\Models\Backend\Upazila;
use Illuminate\Support\Facades\DB;
use Auth;
use PDF;

class AgricultureController extends Controller
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

        $division_id = request('division_id', null);
        $kachari_id = request('kachari_id', null);
        $district_id = request('district_id', null);
        $upazila_id = request('upazila_id', null);
        $station_id = request('station_id', null);
        $mouja_id = request('mouja_id', null);
        $license_no = request('license_no', null);
        $download = request('download', null);
        $balam = AgriBalam::with('agriOwner');

        $srchResult = AgricultureLicense::with('agriOwner', 'balam', 'agriMoujas');
        $searchResult = [];
        if (
            $division_id || $kachari_id || $district_id || $upazila_id || $station_id || $license_no || $download
        ) {
            if ($division_id) {
                $searchResult = $srchResult->where('division_id', $division_id);
            }

            if ($kachari_id) {
                $searchResult = $srchResult->where('kachari_id', $kachari_id);
            }

            if ($district_id) {
                $searchResult = $srchResult->where('district_id', $district_id);
            }

            if ($upazila_id) {
                $searchResult = $srchResult->where('upazila_id', $upazila_id);
            }

            if ($station_id) {
                $searchResult = $srchResult->where('station_id', $station_id);
            }

            if ($license_no) {
                $searchResult = $srchResult->where('generated_id', $license_no);
            }
        }

        $searchResult = $srchResult->orderByDesc('id')->paginate(20);


        if ($download) {
            $mpdf = PDF::loadView('backend.content.agriculture.includes.allLicensePDF', ['searchResult' => $searchResult]);
            return $mpdf->stream('Agri.pdf');
        }

        return view('backend.content.agriculture.index', compact('searchResult', 'division', 'district', 'kachari', 'upazila', 'station', 'balam'));
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
            $data1['record'] = Record::get(['id', 'record_name']);
            $data2['section'] = Section::get(['section_id', 'section_name']);
            $data['land_type'] = LandType::get(['land_type_id', 'land_type']);
            $data['bn_months'] = array("বৈশাখ", "জ্যৈষ্ঠ", "আষাঢ়", "শ্রাবণ", "ভাদ্র", "আশ্বিন", "কার্তিক", "অগ্রহায়ণ", "পৌষ", "মাঘ", "ফাল্গুন", "চৈত্র");
            return view('backend.content.agriculture.create', $data, $data1)->with($data2);
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
        $license_owner_data = $this->licenseOwnerValidation();
        $license_information = $this->licenseInformationValidation();
        //dd($license_information);
        $license_mouja_data = $this->licenseMoujaValidation();
        $lastPayment = $this->lastPayment();

        try {
            $transaction_id = DB::transaction(function () use ($request, $license_owner_data, $license_information, $license_mouja_data, $lastPayment) {
                // Uploading noksha file if exists.
                if ($request != null && !empty($request->file('land_map_certificate'))) {
                    $land_map_certificate = uniqid() . '.' . $request->land_map_certificate->getClientOriginalExtension();
                    $request->land_map_certificate->move(public_path('uploads/agriculture/'), $land_map_certificate);
                    $license_information['land_map_certificate'] = $land_map_certificate;
                }
                $agriLicense = new AgricultureLicense;
                $agri_id = $agriLicense->insertGetId($license_information);
                $serialNum = $agriLicense->count();
                $generate_id = null;

                if ($agri_id) {
                    // generate license 6 digit id with division and landtype id
                    $division_id = $license_information['division_id'];
                    $license_type = 1;
                    $div_license = $division_id . $license_type;
                    $generate_id = generate_number($serialNum, 6, $div_license);
                    $agriLicense->find($agri_id)->update(['generated_id' => $generate_id]);
                }

                $ownerCreator = null;
                foreach ($license_owner_data['owner'] as $owner) {
                    // Owner photo uploading if exists
                    if (!empty($owner['photo'])) {
                        $owner_photo = $owner['photo'];
                        $owner_photo_name = $generate_id . '-' . $owner['name'] . '-' . $owner_photo->getClientOriginalName();
                        $owner['photo'] = store_picture($owner_photo, 'uploads/owners', $owner_photo_name);
                    }

                    if (!empty($owner['capture'])) {
                        $owner_photo = $owner['capture'];

                        $folderPath = public_path('uploads/owners/');
                        $image_parts = explode(';base64,', $owner_photo);

                        foreach ($image_parts as $key => $image) {
                            $image_base64 = base64_decode($image);
                        }

                        $fileName = uniqid() . '.png';
                        $file = $folderPath . $fileName;
                        file_put_contents($file, $image_base64);
                        $owner['photo'] = $fileName;
                    }

                    if ($owner['nameOption'] == 'fatherName') {
                        $owner['father_name'] = $owner['full_name'];
                    }

                    if ($owner['nameOption'] == 'husbandName') {
                        $owner['husband_name'] = $owner['full_name'];
                    }

                    unset($owner['nameOption'], $owner['full_name'], $owner['capture']);
                    // Creating owners and also inserting the owners id to join table with license

                    // dd($owner);
                    $ownerCreator = AgriOwner::insertGetId($owner);
                    AgriLicenseOwner::create([
                        'license_id' => $agri_id,
                        'owner_id' => $ownerCreator,
                    ]);
                }

                if (
                    $lastPayment['from_date']['license_fee_from_yy'] && $lastPayment['from_date']['license_fee_from_mm'] && $lastPayment['from_date']['license_fee_from_dd'] &&
                    $lastPayment['to_date']['license_fee_to_yy'] && $lastPayment['to_date']['license_fee_to_mm'] && $lastPayment['to_date']['license_fee_to_dd']
                ) {
                    $from_date = $lastPayment['from_date']['license_fee_from_yy'] . '-' . $lastPayment['from_date']['license_fee_from_mm'] . '-' . $lastPayment['from_date']['license_fee_from_dd'];
                    $to_date = $lastPayment['to_date']['license_fee_to_yy'] . '-' . $lastPayment['to_date']['license_fee_to_mm'] . '-' . $lastPayment['to_date']['license_fee_to_dd'];
                    $data = [
                        'owner_id' => $ownerCreator,
                        'license_no' => $generate_id,
                        'license_type' => 'agriculture',
                        'from_date' => $from_date,
                        'to_date' => $to_date,
                    ];
                    AgriBalam::create($data);
                }

                // Multiple moujas creating with license id
                foreach ($license_mouja_data['mouja'] as $mouja) {
                    if (array_key_exists('plot_id', $mouja) &&  $mouja['plot_id']) {
                        $mouja['plot_id'] = json_encode($mouja['plot_id']);
                    } else {
                        $mouja['plot_id'] = json_encode([]);
                    }
                    $mouja['license_id'] = $agri_id;
                    AgriMouja::create($mouja);
                }

                return $generate_id;
            });

            if ($transaction_id) {
                $phone = $license_owner_data['owner'][0]['phone'];
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
                ->withFlashSuccess('নতুন কৃষি লাইসেন্স সফলভাবে যুক্ত করা হয়েছে');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withFlashDanger('কৃষি লাইসেন্সটি সংযুক্ত হইনি');
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
        $license = AgricultureLicense::with('record', 'agriMoujas', 'division', 'district', 'kachari', 'station', 'upazila')->find($id);
        $license_owner = $license->agriOwner;
        $license_balam = AgriBalam::with('dd')->where('license_no', $license->generated_id)->get();
        $license_balam_dd = AgriDDInfo::get();
        return view('backend.content.agriculture.license_information', compact('license', 'license_owner', 'license_balam', 'license_balam_dd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $license = AgricultureLicense::with('agriOwner', 'record', 'agriMoujas')->findOrFail($id);
        $division = Division::pluck('division_name', 'division_id');
        $kachari = Kachari::pluck('kachari_name', 'kachari_id');
        $district = District::pluck('district_name', 'district_id');
        $upazila = Upazila::pluck('upazila_name', 'upazila_id');
        $station = Station::pluck('station_name', 'station_id');

        $section = Section::pluck('section_name', 'section_id');
        $sections = Section::get(['section_id', 'section_name']);

        $land_types = LandType::get(['land_type_id', 'land_type']);
        $land_type = LandType::pluck('land_type', 'land_type_id');
        $records = Record::pluck('record_name', 'id');
        $bn_months = array("বৈশাখ", "জ্যৈষ্ঠ", "আষাঢ়", "শ্রাবণ", "ভাদ্র", "আশ্বিন", "কার্তিক", "অগ্রহায়ণ", "পৌষ", "মাঘ", "ফাল্গুন", "চৈত্র");

        $lastPayment = AgriBalam::where('license_no', $license->generated_id)->latest()->first();

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

        $Allmoujas = AgriMouja::where('license_id', $license->id)
            ->with('ledger')
            ->get();

        $moujas = Mouja::where('station_id', $license->station_id)->get();
        $ledgers = [];

        if (!empty($Allmoujas)) {
            foreach ($Allmoujas as $mouja) {
                $ledgers[] =  $mouja->ledger;
            }
        }

        $plots = plot::get();
        $licenseMoujas = AgriMouja::where('license_id', $id)->get();

        return view('backend.content.agriculture.edit', compact('plots', 'ledgers', 'moujas', 'records', 'division', 'land_type', 'license', 'kachari', 'district', 'upazila', 'station', 'licenseMoujas', 'last_payment_date', 'bn_months'));
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
        $license_owner_data = $this->licenseOwnerEditValidation();
        $licenseDetails = $this->licenseInformationValidation();
        $moujaDetails = $this->licenseMoujaValidation();
        $lastPayment = $this->lastPayment();

        if (!empty($request->file('land_map_certificate'))) {
            $documents = uniqid() . '.' . $request->land_map_certificate->getClientOriginalExtension();
            $request->land_map_certificate->move(public_path('uploads/agriculture/'), $documents);
            $licenseDetails['land_map_certificate'] = $documents;
        }

        $agri_license = AgricultureLicense::where('id', $id)->first();
        $agri_license->update($licenseDetails);

        if ($moujaDetails && count($moujaDetails['mouja']) > 0) {
            AgriMouja::where('license_id', $id)->delete();
            foreach ($moujaDetails['mouja'] as $mouja) {
                $mouja['license_id'] = $id;
                if (array_key_exists('plot_id', $mouja)) {
                    $mouja['plot_id'] = json_encode($mouja['plot_id']);
                } else {
                    $mouja['plot_id'] = json_encode([]);
                }
                AgriMouja::create($mouja);
            }
        }

        if ($license_owner_data['owner']) {
            $generate_id = $agri_license->generated_id;
            foreach ($license_owner_data['owner'] as $owner) {
                if (!empty($owner['photo'])) {
                    $owner_photo = $owner['photo'];
                    $owner_photo_name = $generate_id . '-' . $owner['name'] . '-' . $owner_photo->getClientOriginalName();
                    $owner['photo'] = store_picture($owner_photo, 'uploads/owners', $owner_photo_name);
                }

                if (!empty($owner['capture'])) {
                    $owner_photo = $owner['capture'];

                    $folderPath = public_path('uploads/owners/');
                    $image_parts = explode(';base64,', $owner_photo);

                    foreach ($image_parts as $key => $image) {
                        $image_base64 = base64_decode($image);
                    }

                    $fileName = uniqid() . '.png';
                    $file = $folderPath . $fileName;
                    file_put_contents($file, $image_base64);
                    $owner['photo'] = $fileName;
                }

                if ($owner['nameOption'] == 'fatherName') {
                    $owner['father_name'] = $owner['full_name'];
                    $owner['husband_name'] = "";
                }

                if ($owner['nameOption'] == 'husbandName') {
                    $owner['husband_name'] = $owner['full_name'];
                    $owner['father_name'] = "";
                }

                unset($owner['nameOption'], $owner['full_name']);

                if (!empty($owner['id'])) {
                    AgriOwner::where('id', $owner['id'])->update($owner);
                } else {
                    unset($owner['id']);
                    $newOwner = AgriOwner::create($owner);
                    // Creating owners and also inserting the owners id to join table with license
                    AgriLicenseOwner::create([
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
                AgriBalam::where('id', $request->balam_id)->update($data);
            } else {
                $data = [
                    'owner_id' => $license_owner_data['owner'][0]['id'],
                    'license_no' => $generate_id,
                    'license_type' => 'agriculture',
                    'from_date' => $from_date,
                    'to_date' => $to_date,
                ];
                AgriBalam::insert($data);
            }
        }

        return redirect()
            ->back()
            ->withFlashSuccess('কৃষি লাইসেন্স সফলভাবে সংশোধন করা হয়েছে');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getBalam = AgricultureLicense::find($id);
        if (!$getBalam) {
            return response(["msg" => "Invalid Delete Request!", 'icon' => "error"]);
        }

        $getBalam->delete();
        return response(["msg" => "Agriculture License Deleted", 'icon' => "success"]);
    }

    public function licenseMoujaDelete($id)
    {
        $delete_mouja = AgriMouja::find($id)->delete();
        if ($delete_mouja) {
            return response(['msg' => 'Mouja removed']);
        }
    }

    public function licenseOwnerDelete($id)
    {
        $delete_owner = AgriOwner::find($id);
        if ($delete_owner) {
            if (file_exists(public_path('uploads/owners/' . $delete_owner->photo))) {
                unlink(public_path('uploads/owners/' . $delete_owner->photo));
            }
            $delete_owner->delete();
            return response(['msg' => 'Owner removed']);
        }
    }


    public function licenseStatus()
    {
        $status = request('status');
        $item_id = request('item_id');

        if (is_array($item_id)) {
            foreach ($item_id as $item) {
                AgricultureLicense::findOrFail($item)->update(['status' => $status]);
            }
            return redirect()->back()->withFlashSuccess("This License approved successfully");
        }
        return redirect()->back()->withFlashWarning("Status cant't be approved");
    }

    public function licenseOwnerValidation()
    {
        $license_owner_data = request()->validate([
            'owner.*.name' => 'nullable|string',
            'owner.*.nameOption' => 'nullable|string',
            'owner.*.full_name' => 'nullable|string',
            'owner.*.nid' => 'nullable|string| max:20',
            'owner.*.phone' => 'nullable|string| max:20',
            'owner.*.address' => 'nullable|string',
            'owner.*.photo' => 'nullable',
            'owner.*.capture' => 'nullable',
        ]);

        return $license_owner_data;
    }

    public function licenseOwnerEditValidation()
    {
        $license_owner_data = request()->validate([
            'owner.*.id' => 'required|numeric',
            'owner.*.name' => 'required|string',
            'owner.*.nameOption' => 'nullable|string',
            'owner.*.full_name' => 'nullable|string',
            'owner.*.nid' => 'nullable|string| max:20',
            'owner.*.phone' => 'nullable|string| max:15',
            'owner.*.address' => 'nullable|string',
            'owner.*.photo' => 'nullable',
            'owner.*.capture' => 'nullable',
        ]);

        return $license_owner_data;
    }

    public function licenseInformationValidation()
    {
        $license_data = request()->validate([
            'demand_notice_number' => 'nullable|string',
            'demand_notice_date' => 'nullable|date',
            'division_id' => 'required|numeric',
            'kachari_id' => 'required|numeric',
            'district_id' => 'required|numeric',
            'upazila_id' => 'required|numeric',
            'station_id' => 'required|numeric',

            'land_map_number' => 'nullable|string',
            'land_map_date' => 'nullable|date',
            'land_map_north' => 'nullable|string',
            'land_map_east' => 'nullable|string',
            'land_map_south' => 'nullable|string',
            'land_map_west' => 'nullable|string',
            'land_map_kilo' => 'nullable|string',
            'land_map_certificate' => 'nullable|file',
            'user_id' => 'nullable|numeric|max:255',
        ]);
        return $license_data;
    }

    public function licenseMoujaValidation()
    {
        return request()->validate([
            'mouja.*.mouja_id' => 'nullable|numeric',
            'mouja.*.record_name' => 'nullable|numeric',
            'mouja.*.ledger_id' => 'nullable|numeric',
            'mouja.*.plot_id' => 'nullable',
            'mouja.*.property_amount' => 'nullable',
            'mouja.*.leased_area' => 'nullable',
        ]);
    }

    public function lastPayment()
    {
        $validatedata = request()->validate([
            "from_date.license_fee_from_dd" => "nullable",
            "from_date.license_fee_from_mm" => "nullable",
            "from_date.license_fee_from_yy" => "nullable",

            "to_date.license_fee_to_dd" => "nullable",
            "to_date.license_fee_to_mm" => "nullable",
            "to_date.license_fee_to_yy" => "nullable",
        ]);

        return $validatedata;
    }
}
