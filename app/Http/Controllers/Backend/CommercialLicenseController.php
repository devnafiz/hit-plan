<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\CommercialBalam;
use App\Models\Backend\CommercialDdInfo;
use App\Models\Backend\CommercialLicense;
use App\Models\Backend\CommercialLicenseMouja;
use App\Models\Backend\CommercialLicenseOwner;
use App\Models\Backend\CommercialMouja;
use App\Models\Backend\CommercialOwner;
use App\Models\Backend\Record;
use App\Models\Backend\Section;
use App\Models\Backend\Division;
use App\Models\Backend\LandType;
use App\Models\Backend\District;
use App\Models\Backend\Kachari;
use App\Models\Backend\LicenseIds;
use App\Models\Backend\MasterPlan;
use App\Models\Backend\MasterPlanPlot;
use App\Models\Backend\Mouja;
use App\Models\Backend\Station;
use App\Models\Backend\Upazila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Json;
use Auth;

class CommercialLicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(CommercialLicense::doesntHave('commercialMoujas')->delete());

        $division = Division::pluck('division_name', 'division_id');
        $district = District::pluck('district_name', 'district_id');
        $kachari = Kachari::pluck('kachari_name', 'kachari_id');
        $upazila = Upazila::pluck('upazila_name', 'upazila_id');
        $station = Station::pluck('station_name', 'station_id');

        $division_id = request('division_id', "");
        $kachari_id = request('kachari_id', "");
        $district_id = request('district_id', "");
        $upazila_id = request('upazila_id', "");
        $station_id = request('station_id', "");
        $mouja_id = request('mouja_id', "");
        $license_no = request('license_no', "");
        $balam = CommercialBalam::with('commercialOwner');
        $searchResult = CommercialLicense::with('commercialOwner', 'balam');

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
        }

        return view('backend.content.commercial.index', compact('searchResult', 'division', 'district', 'kachari', 'upazila', 'station', 'balam'));
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
            $data['masterplans'] = MasterPlan::get(['id', 'masterplan_no']);
            return view('backend.content.commercial.create', $data, $data1)->with($data2);
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
        $masterplan_data = $this->masterplanValidation();
        $license_owner = $this->licenseOwnerValidation();
        $masterplan_moujas = $this->masterplanMoujaValidation();
        $lastPayment = $this->lastPayment();

        try {
            $transaction_id = DB::transaction(
                function () use ($request, $license_owner, $masterplan_data, $masterplan_moujas, $lastPayment) {
                    if (!empty($request->file('land_map_certificate'))) {
                        $documents = uniqid() . '.' . $request->land_map_certificate->getClientOriginalExtension();
                        $request->land_map_certificate->move(public_path('uploads/commercial/'), $documents);
                        $masterplan_data['land_map_certificate'] = $documents;
                    }

                    $commerciaLicense = new CommercialLicense;
                    $commercial_id = $commerciaLicense->insertGetId($masterplan_data);
                    $serialNum = $commerciaLicense->count();
                    $generate_id = null;

                    if ($commercial_id) {
                        $division_id = $masterplan_data['division_id'];
                        $license_type = 2;
                        $div_license = $division_id . $license_type;

                        $generate_id = generate_number($serialNum, 6, $div_license);
                        $commerciaLicense->update(['generated_id' => $generate_id]);
                    }

                    // Owner photo uploading if exists
                    foreach ($license_owner['owner'] as $owner) {
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

                        unset($owner['nameOption'], $owner['full_name'], $owner['capture'], $owner['license_id']);
                        // Creating owners and also inserting the owners id to join table with license

                        // dd($owner);
                        $ownerCreator = CommercialOwner::insertGetId($owner);

                        CommercialLicenseOwner::create([
                            'license_id' => $commercial_id,
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
                            'license_type' => 'commercial',
                            'from_date' =>  $from_date,
                            'to_date' => $to_date,
                        ];
                        $balam_id = CommercialBalam::insertGetId($data);

                        $DDdata = [
                            'balam_commercial_id' => $balam_id,
                            'j1' => $generate_id . rand(0, 5),
                            'j1_date' => date('Y-m-d'),
                        ];
                        CommercialDdInfo::insert($DDdata);
                    }

                    // Multiple moujas creating with license id
                    foreach ($masterplan_moujas['mouja'] as $mouja) {
                        unset($mouja['license_id'], $mouja['masterPlanMouja']);
                        $mouja['plot_id'] = json_encode($mouja['plot_id']);
                        $mouja['license_id'] = $commercial_id;
                        CommercialLicenseMouja::create($mouja);
                    }

                    return $generate_id;
                }
            );

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
                ->withFlashSuccess('নতুন বাণিজ্যিক লাইসেন্স সফলভাবে যুক্ত করা হয়েছে');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withFlashDanger('বাণিজ্যিক লাইসেন্সটি সংযুক্ত হইনি');
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
        $license = CommercialLicense::with('commercialMoujas', 'record', 'division', 'district', 'kachari', 'station', 'upazila')->find($id);
        $license_owner = $license->commercialOwner;
        $license_balam = CommercialBalam::with('dd')->where('license_no', $license->generated_id)->get();
        $license_balam_dd = CommercialDdInfo::get();
        return view('backend.content.commercial.license_information', compact('license', 'license_owner', 'license_balam', 'license_balam_dd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $division = Division::pluck('division_name', 'division_id');
        $kachari = Kachari::pluck('kachari_name', 'kachari_id');
        $district = District::pluck('district_name', 'district_id');
        $upazila = Upazila::pluck('upazila_name', 'upazila_id');
        $station = Station::pluck('station_name', 'station_id');

        $section = Section::pluck('section_name', 'section_id');
        $sections = Section::get(['section_id', 'section_name']);

        $land_types = LandType::get(['land_type_id', 'land_type']);
        $land_type = LandType::pluck('land_type', 'land_type_id');
        $record = Record::get(['id', 'record_name']);

        $result = CommercialLicense::with('commercialOwner', 'record', 'commercialMoujas')->find($id);
        $masterplan = MasterPlan::where('station_id', $result->station_id)->pluck('masterplan_no', 'id');
        $licenseMoujas = CommercialLicenseMouja::where('license_id', $id)->get();
        $plots = MasterPlanPlot::get();

        $lastPayment = CommercialBalam::where('license_no', $result->generated_id)->orderBy('id', 'desc')->first();

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
        return view('backend.content.commercial.edit', compact('record', 'division', 'land_type', 'result', 'kachari', 'district', 'upazila', 'station', 'masterplan', 'licenseMoujas', 'plots', 'last_payment_date'));
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
        $masterplan_data = $this->masterplanValidation();
        $license_owner = $this->licenseOwnerValidation();
        $masterplan_moujas = $this->masterplanMoujaValidation();
        $lastPayment = $this->lastPayment();

        // generate license 6 digit id with division and landtype id
        if (!empty($request->file('land_map_certificate'))) {
            $documents = uniqid() . '.' . $request->land_map_certificate->getClientOriginalExtension();
            $request->land_map_certificate->move(public_path('uploads/commercial/'), $documents);
            $masterplan_data['land_map_certificate'] = $documents;
        }

        $commercial_id = CommercialLicense::where('id', $id)->first();
        $commercial_id->update($masterplan_data);
        $generate_id = $commercial_id->generated_id;


        if ($commercial_id) {
            // Owner photo uploading if exists
            foreach ($license_owner['owner'] as $key => $owner) {
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
                    CommercialOwner::where('id', $owner['id'])->update($owner);
                } else {
                    unset($owner['id']);
                    $newOwner = CommercialOwner::create($owner);
                    // Creating owners and also inserting the owners id to join table with license
                    CommercialLicenseOwner::create([
                        'license_id' => $id,
                        'owner_id' => $newOwner->id
                    ]);
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
                    CommercialBalam::where('id', $request->balam_id)->update($data);
                } else {
                    $data = [
                        'owner_id' => $license_owner['owner'][0]['id'],
                        'license_no' => $generate_id,
                        'license_type' => 'commercial',
                        'from_date' => $from_date,
                        'to_date' => $to_date,
                    ];
                    CommercialBalam::create($data);
                }
            }
            // Multiple moujas creating with license id
            foreach ($masterplan_moujas['mouja'] as $mouja) {
                $mouja['plot_id'] = array_key_exists('plot_id', $mouja) ? json_encode($mouja['plot_id']) : [];
                if (array_key_exists('masterPlanMouja', $mouja)) {
                    $mouja_id = $mouja['masterPlanMouja'];
                    unset($mouja['masterPlanMouja']);
                    CommercialLicenseMouja::findOrFail($mouja_id)->update($mouja);
                } else {
                    $mouja['license_id'] = $id;
                    CommercialLicenseMouja::insert($mouja);
                }
            }

            return redirect()
                ->back()
                ->withFlashSuccess('বাণিজ্যিক লাইসেন্স সফলভাবে সংশোধন করা হয়েছে');
        } else {
            return redirect()
                ->back()
                ->withFlashDanger('বাণিজ্যিক লাইসেন্স সংশোধন হইনি');
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
        $getBalam = CommercialLicense::find($id);
        if (!$getBalam) {
            return response(["msg" => "Invalid Delete Request!", 'icon' => "error"]);
        }
        $getBalam->delete();
        return response(["msg" => "Commercial License Deleted", 'icon' => "success"]);
    }

    public function licenseMoujaDelete($id)
    {
        $getBalam = CommercialMouja::find($id)->delete();
        if (!$getBalam) {
            return response(["msg" => "Invalid Delete Request!", 'icon' => "error"]);
        } else {
            return response(["msg" => "Commercial Mouja Deleted", 'icon' => "success"]);
        }
    }

    public function licenseOwnerDelete($id)
    {
        $delete_owner = CommercialOwner::find($id);
        if ($delete_owner) {
            if (file_exists(asset('uploads/owners/' . $delete_owner->photo))) {
                unlink(asset('uploads/owners/' . $delete_owner->photo));
            }
            $delete_owner->delete();
            return response(['msg' => 'Owner removed']);
        }
    }

    public function licenseOwnerValidation()
    {
        return request()->validate([
            'owner.*.id' => 'nullable|string',
            'owner.*.name' => 'required|string',
            'owner.*.nameOption' => 'required|string',
            'owner.*.full_name' => 'required|string',
            'owner.*.nid' => 'nullable|string| max:20',
            'owner.*.phone' => 'required|string| max:20',
            'owner.*.address' => 'nullable|string',
            'owner.*.photo' => 'nullable',
            'owner.*.capture' => 'nullable',
        ]);
    }

    public function licenseStatus()
    {
        $license = request('id', null);
        if ($license) {
            CommercialLicense::findOrFail($license)->update(['status' => "approved"]);
            return response(["message" => "This License approved successfully"]);
        }
        return response(["message" => "Something went wrong"]);
    }

    public function masterplanValidation()
    {
        return request()->validate([
            'demand_notice_number' => 'nullable|string',
            'demand_notice_date' => 'nullable|date',
            'division_id' => 'required|numeric',
            'kachari_id' => 'required|numeric',
            'district_id' => 'required|numeric',
            'upazila_id' => 'required|numeric',
            'station_id' => 'required|numeric',

            'land_map_number' => 'nullable|numeric',
            'land_map_date' => 'nullable|date',
            'land_map_north' => 'nullable|string',
            'land_map_east' => 'nullable|string',
            'land_map_south' => 'nullable|string',
            'land_map_west' => 'nullable|string',
            'land_map_kilo' => 'nullable|string',
            'land_map_certificate' => 'nullable|file',
            'user_id' => 'nullable|numeric|max:255',
        ]);
    }

    public function masterplanMoujaValidation()
    {
        return request()->validate([
            'mouja.*.license_id' => 'nullable|numeric',
            'mouja.*.masterplan_id' => 'nullable|numeric',
            'mouja.*.plot_id' => 'nullable',
            'mouja.*.plot_length' => 'nullable',
            'mouja.*.plot_width' => 'nullable',
            'mouja.*.property_amount' => 'nullable',
            'mouja.*.leased_area' => 'nullable|numeric',
            'mouja.*.masterPlanMouja' => 'nullable|numeric',
        ]);
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
