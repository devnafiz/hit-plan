<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\AgricultureLicense;
use App\Models\Backend\AgriDDInfo;
use App\Models\Backend\AgriMouja;
use App\Models\Backend\AgriLicenseOwner;
use App\Models\Backend\ArgiLicenseFee;
use App\Models\Backend\AgriVatTax;
use App\Models\Backend\AgriBalam;
use EasyBanglaDate\Types\BnDateTime;
use Illuminate\Http\Request;
use App\Domains\Auth\Models\Role;
use Auth;
use App\Domains\Auth\Models\Permission;

class AgricultureLicenseFeeCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.content.agri_fee_collection.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['bn_months'] = array("বৈশাখ", "জ্যৈষ্ঠ", "আষাঢ়", "শ্রাবণ", "ভাদ্র", "আশ্বিন", "কার্তিক", "অগ্রহায়ণ", "পৌষ", "মাঘ", "ফাল্গুন", "চৈত্র");
        return view('backend.content.agri_fee_collection.create', compact('bn_months'));
    }

    public function fetchFeeCalculator(Request $request)
    {
        $licenseFeeData = $this->licenseFeeCollectionDate();

        if ($licenseFeeData) {
            $from_date = $licenseFeeData['from_date']['license_fee_from_yy'] . '-' . $licenseFeeData['from_date']['license_fee_from_mm'] . '-' . $licenseFeeData['from_date']['license_fee_from_dd'];
            $to_date = $licenseFeeData['to_date']['license_fee_to_yy'] . '-' . $licenseFeeData['to_date']['license_fee_to_mm'] . '-' . $licenseFeeData['to_date']['license_fee_to_dd'];
        }

        $banglaDate = new BnDateTime();

        $licenseBalam = AgriBalam::where('license_no', $licenseFeeData['license_number'])->orderBy('id', 'desc')->first();

        if ($licenseBalam) {
            $year = $licenseBalam ? date('Y', strtotime($licenseBalam->to_date)) : null;
            $month = date('m', strtotime($licenseBalam->to_date));
            $day = date('d', strtotime($licenseBalam->to_date));

            $lastToDate = $banglaDate->setDate($year, $month, $day)->format('jS F Y');

            if (date("Y", strtotime(date("Y-m-d", strtotime($licenseBalam->to_date)) . " + " . 1 . " year")) < date('Y', strtotime($from_date))) {
                return response(['message' => 'লাইসেন্স ফি ' . $lastToDate . ' পর্যন্ত আদায় হয়েছে। পরবর্তী বছর বাছাই করুন', 'status' => 'warning']);
            }

            if (date("Y", strtotime(($licenseBalam->to_date))) > date('Y', strtotime($from_date))) {
                return response(['message' => 'লাইসেন্স ফি ' . $lastToDate . ' পর্যন্ত আদায় হয়েছে। পরবর্তী বছর বাছাই করুন', 'status' => 'warning']);
            }
        }

        $getLicense = AgricultureLicense::where('generated_id', $licenseFeeData['license_number'])->first();
        if (empty($getLicense)) {
            return json_encode(['message' => "লাইসেন্স নম্বরটি সঠিক নয়", "status" => "error"]);
        }

        $getLicenseMoujas = AgriMouja::where('license_id', $getLicense->id)->sum('leased_area');

        if ($getLicenseMoujas == 0) {
            return json_encode(['message' => "লীজকৃত জমির পরিমাণ খুজে পাওয়া যাইনি", "status" => "error"]);
        }

        $getFees = ArgiLicenseFee::where('type', 'agriculture')
            ->where('activation_year_from', '<=', date('Y-m-d', strtotime($from_date)))
            ->where('activation_year_to', '>=', date('Y-m-d', strtotime($to_date)))
            ->where('status', 'true')
            ->sum('fee');

        if (empty($getFees)) {
            return response(['message' => 'লাইসেন্স ফি খুজে পাওয়া যাইনি', 'status' => 'error']);
        }

        $actualFeeData = 0;
        $feeDescriptionData = [];
        $date1 = date_create($to_date);
        $date2 = date_create($from_date);
        $interval = date_diff($date1, $date2);

        $yearDiff = $interval->y + 1;
        $total_late_fee = 0;
        $actualFeeData = 0;
        $banglaDate = new BnDateTime();

        for ($i = 0; $i < $yearDiff; $i++) {
            if ($to_date > $from_date) {
                $actualFeeData += $getLicenseMoujas *  $getFees;
                $newFromDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($from_date)) . " + " . $i . " year"));
                $newToDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($from_date)) . " + " . ($i + 1) . " year"));
                $late_fee = 0;

                if ($banglaDate->enFormat('Y') >= date("Y", strtotime($newToDate))) {
                    $late_fee = ($getLicenseMoujas *  $getFees * 10) / 100;
                }

                // dump(date("Y", strtotime($newToDate)));

                $total_late_fee += $late_fee;
                $feeDescriptionData[] = [
                    'from' => date('Y', strtotime($newFromDate)),
                    'to' => date('Y', strtotime($newFromDate)),
                    'amount' => $getLicenseMoujas *  $getFees,
                    'late_fee' => round($late_fee),
                ];
            }
        }

        $totalAmount = $actualFeeData;
        $getTaxAmount = AgriVatTax::orderBy('id', 'DESC')->first();

        if (!empty($getTaxAmount)) {
            $vatAmount = ($totalAmount * $getTaxAmount->vat) / 100;
            $taxAmount = ($totalAmount * $getTaxAmount->tax) / 100;
        } else {
            $vatAmount = 0;
            $taxAmount = 0;
        }

        $ownerLicense = AgriLicenseOwner::where('license_id', $getLicense->id)->first();
        $ownerLicense = $ownerLicense->owner;
        $data = [
            'total' => $totalAmount,
            'land_amount' => $getLicenseMoujas,
            'vat' => $vatAmount,
            'tax' => $taxAmount,
            'license_fines' => $total_late_fee,
            'owner_info' => $ownerLicense,
            'description_data' => $feeDescriptionData,
            'station_rate' => null,
        ];
        return json_encode(["message" => "Data Found", "status" => "success", "data" => $data]);
    }

    public function licenseFeeFetchCalculatorDataValidation($request)
    {
        $data = $request->validate([
            'license_number' => 'required|numeric|digits_between:1,11',
            'from' => 'required|numeric',
            'to' => 'required|numeric'
        ]);

        return $data;
    }

    public function fetchFeeDetails(Request $request)
    {
        $licenseFeeData = $this->licenseFeeFetchDataValidation($request);
        $license = AgricultureLicense::with('record', 'agriOwner', 'agriMoujas', 'division', 'district', 'kachari', 'station', 'upazila')
            ->where('generated_id', $licenseFeeData['license_number'])->first();
        if (empty($license)) {
            return json_encode(['message' => "Invalid License Number", "status" => "error"]);
        }

        $license_balam = AgriBalam::with('dd')->where('license_no', $license->generated_id)->get();
        $agri_mojas = license_moujas($license->agriMoujas);
        $data = [
            'license' => $license,
            'license_balam' => $license_balam,
            'license_owner' => $license->agriOwner,
            'formatted_data' => [
                'agri_mojas' => $agri_mojas,
                'land_total_qty' => $license->agriMoujas->sum('property_amount'),
                'total_lease_area' => $license->agriMoujas->sum('leased_area'),
                'demand_notice_date' => date('F j, Y', strtotime($license->demand_notice_date)) ?? 'N/A',
                'map_date' => date('F j, Y', strtotime($license->land_map_date)) ?? 'N/A',
                'license_copy' => ($license->land_map_certificate ? asset($license->land_map_certificate) : '')
            ]
        ];

        return json_encode(["message" => "Data Found", "status" => "success", "data" => $data]);
    }

    public function licenseFeeFetchDataValidation($request)
    {
        $data = $request->validate([
            'license_number' => 'required|numeric|digits_between:1,11'
        ]);

        return $data;
    }

    public function licenseFeeCollectionDataValidation($request)
    {
        $data = $request->validate([
            'license_number' => 'required|numeric|digits_between:1,11',
            'license_owner_id'  => 'required|numeric|digits_between:1,11',
            'license_fee' => 'required|numeric',

            'license_vat' => 'nullable|numeric',
            'license_tax' => 'nullable|numeric',
            'license_fines' => 'nullable|numeric',
            'license_security' => 'nullable|numeric',
            'license_plan_fee' => 'nullable|numeric',
            'license_application_fee' => 'nullable',
            'license_renew_fee' => 'nullable|numeric',
            'license_naming_fee' => 'nullable|numeric',

            'license_total_amount' => 'required|numeric',
            'user_id' => 'nullable|numeric',
            'user_phone' => 'nullable|numeric',
            'license_fee_dd' => 'array'
        ]);
        return $data;
    }

    public function store(Request $request)
    {
        $licenseFeeData = $this->licenseFeeCollectionDataValidation($request);
        $fee_collection_date = $this->licenseFeeCollectionDate();

        if ($fee_collection_date) {
            $from_date = $fee_collection_date['from_date']['license_fee_from_yy'] . '-' . $fee_collection_date['from_date']['license_fee_from_mm'] . '-' . $fee_collection_date['from_date']['license_fee_from_dd'];
            $to_date = $fee_collection_date['to_date']['license_fee_to_yy'] . '-' . $fee_collection_date['to_date']['license_fee_to_mm'] . '-' . $fee_collection_date['to_date']['license_fee_to_dd'];
        }
        $data = [
            'owner_id'          => $licenseFeeData['license_owner_id'],
            'license_no'        => $licenseFeeData['license_number'],
            'from_date' => date('Y-m-d h:i:s', strtotime($from_date)),
            'to_date' => date('Y-m-d h:i:s', strtotime($to_date)),
            'license_type'      => 'agriculture',
            'license_fee'       => $licenseFeeData['license_fee'],
            'vat'               => $licenseFeeData['license_vat'],
            'tax'               => $licenseFeeData['license_tax'],
            'fine'              => $licenseFeeData['license_fines'],
            'security'          => $licenseFeeData['license_security'],
            'plan_fee'          => $licenseFeeData['license_plan_fee'],
            'application_fee'   => $licenseFeeData['license_application_fee'],
            'mutation_fee'      => $licenseFeeData['license_renew_fee'],
            'naming'            => $licenseFeeData['license_naming_fee'],
            'total_fee'         => $licenseFeeData['license_total_amount'],
            'user_id'           => $licenseFeeData['user_id'],
        ];

        $licenseDataStore = AgriBalam::create($data);
        if (!$licenseDataStore) {
            return redirect()->back()->with('error', 'Error occured! Please try again.');
        }
        $ddInfo = new AgriDDInfo;
        $count = count(array_unique(array_column($ddInfo->select('j1')->get()->toArray(), 'j1'))) + 1;
        foreach ($licenseFeeData['license_fee_dd']['dd_no'] as $key => $val) {
            $ddData = [
                'balam_agriculture_id'  => $licenseDataStore->id,
                'dd_no'                 => (!empty($val)) ? $val : '',
                'dd_vat'                => (!empty($licenseFeeData['license_fee_dd']['vat_no'][$key])) ? intval($licenseFeeData['license_fee_dd']['vat_no'][$key]) : null,
                'dd_tax'                => (!empty($licenseFeeData['license_fee_dd']['tax_no'][$key])) ? $licenseFeeData['license_fee_dd']['tax_no'][$key] : null,
                'bank_name'             => (!empty($licenseFeeData['license_fee_dd']['bank_name'][$key])) ? $licenseFeeData['license_fee_dd']['bank_name'][$key] : null,
                'dd_date'               => (!empty($licenseFeeData['license_fee_dd']['dd_date'][$key])) ? $licenseFeeData['license_fee_dd']['dd_date'][$key] : null,
                'total' => !empty($licenseFeeData['license_fee_dd']['total_amount'][$key]) ? $licenseFeeData['license_fee_dd']['total_amount'][$key] : null,
                'j1_date'               => now(),
            ];

            $ddData['j1'] = "A" . $count;
            $ddInfo->create($ddData);
        }

        if ($licenseFeeData['user_phone']) {
            $txt = $licenseFeeData['license_number'] . " নং লাইসেন্সের " . date_en_to_bn($from_date) . " হতে" . date_en_to_bn($to_date) . " সময়কালের লাইসেন্স ফি গৃহীত হয়েছে। বাংলাদেশ রেলওয়ে";
            send_ware_SMS($txt, $licenseFeeData['user_phone']);
        }

        return redirect()->back()->with('success', 'Successfully Saved License Data!');
    }

    public function feeCollectForm(Request $request, $id)
    {

        $permission = Auth::user()->permissions;
        if (isset($permission[0]['name'])) {
            $permission_kachari = $permission[0]['name'];
        } else {
            $permission_kachari = 0;
        }

        $license = AgricultureLicense::with('agriMoujas', 'record', 'division', 'district', 'kachari', 'station', 'upazila')->find($id);
        if (Auth::user()->can('Administrator') || $license->kachari_id == $permission_kachari) {
            $license_owner = $license->agriOwner;
            $license_balam = AgriBalam::with('dd')->where('license_no', $license->generated_id)->get();
            $bn_months = array("বৈশাখ", "জ্যৈষ্ঠ", "আষাঢ়", "শ্রাবণ", "ভাদ্র", "আশ্বিন", "কার্তিক", "অগ্রহায়ণ", "পৌষ", "মাঘ", "ফাল্গুন", "চৈত্র");
            return view('backend.content.agri_fee_collection.fee_collect_form', compact('license', 'license_balam', 'license_owner', 'bn_months'));
        } else {
            return redirect()->back()->withFlashDanger('Permission denied');
        }

            $license = AgricultureLicense::with('agriMoujas', 'record', 'division', 'district', 'kachari', 'station', 'upazila')->find($id);
            if ($permission[0]['name'] == $license->kachari_id) {

                $license = AgricultureLicense::with('agriMoujas', 'record', 'division', 'district', 'kachari', 'station', 'upazila')->find($id);
                $license_owner = $license->agriOwner;
                $license_balam = AgriBalam::with('dd')->where('license_no', $license->generated_id)->get();
                $bn_months = array("বৈশাখ", "জ্যৈষ্ঠ", "আষাঢ়", "শ্রাবণ", "ভাদ্র", "আশ্বিন", "কার্তিক", "অগ্রহায়ণ", "পৌষ", "মাঘ", "ফাল্গুন", "চৈত্র");

                return view('backend.content.agri_fee_collection.fee_collect_form', compact('license', 'license_balam', 'license_owner', 'bn_months'));
            } else {
                return redirect()->back()->withFlashDanger('Permission denied');
            }
            return redirect()->back()->withFlashDanger('Permission denied');
    }

    public function show($id)
    {
        $balam = AgriBalam::findOrFail($id);
        return view('backend.content.agri_fee_collection.show', compact('balam', 'id'));
    }

    public function edit($id)
    {
        $balam = AgriBalam::findOrFail($id);
        $bn_months = array("বৈশাখ", "জ্যৈষ্ঠ", "আষাঢ়", "শ্রাবণ", "ভাদ্র", "আশ্বিন", "কার্তিক", "অগ্রহায়ণ", "পৌষ", "মাঘ", "ফাল্গুন", "চৈত্র");

        $lastPayment = $balam->latest()->first();
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
        return view('backend.content.agri_fee_collection.edit', compact('balam', 'id', 'last_payment_date', 'bn_months'));
    }

    public function update($id, Request $request)
    {
        $licenseFeeData = $this->licenseFeeCollectionDataValidation($request);
        $fee_collection_date = $this->licenseFeeCollectionDate();

        $licenseDataStore = AgriBalam::findOrFail($id);
        $licenseDataStore->owner_id         = $licenseFeeData['license_owner_id'];
        $licenseDataStore->license_fee      = $licenseFeeData['license_fee'];
        $licenseDataStore->vat              = $licenseFeeData['license_vat'];
        $licenseDataStore->tax              = $licenseFeeData['license_tax'];
        $licenseDataStore->fine             = $licenseFeeData['license_fines'];
        $licenseDataStore->security         = $licenseFeeData['license_security'];
        $licenseDataStore->plan_fee         = $licenseFeeData['license_plan_fee'];
        $licenseDataStore->application_fee  = $licenseFeeData['license_application_fee'];
        $licenseDataStore->mutation_fee     = $licenseFeeData['license_renew_fee'];
        $licenseDataStore->naming           = $licenseFeeData['license_naming_fee'];

        $licenseDataStore->total_fee        = intval(($licenseFeeData['license_fee']
            + $licenseFeeData['license_vat']
            + $licenseFeeData['license_tax']
            + $licenseFeeData['license_fines']
            + $licenseFeeData['license_security']
            + $licenseFeeData['license_plan_fee']
            + $licenseFeeData['license_application_fee']
            + $licenseFeeData['license_renew_fee']
            + $licenseFeeData['license_naming_fee']
        ));

        if ($fee_collection_date) {
            $from_date = $fee_collection_date['from_date']['license_fee_from_yy'] . '-' . $fee_collection_date['from_date']['license_fee_from_mm'] . '-' . $fee_collection_date['from_date']['license_fee_from_dd'];
            $to_date = $fee_collection_date['to_date']['license_fee_to_yy'] . '-' . $fee_collection_date['to_date']['license_fee_to_mm'] . '-' . $fee_collection_date['to_date']['license_fee_to_dd'];
            $licenseDataStore->from_date = date('Y-m-d h:i:s', strtotime($from_date));
            $licenseDataStore->to_date = date('Y-m-d h:i:s', strtotime($to_date));
        }


        $licenseDataStore->save();

        if (!empty($licenseFeeData['license_fee_dd'])) {
            // Deleting Existing DD Infos
            foreach ($licenseDataStore->dd as $dd) {
                AgriDDInfo::destroy($dd->id);
            }

            // Inserting updated DD Infos
            foreach ($licenseFeeData['license_fee_dd']['dd_no'] as $key => $val) {
                $ddData = [
                    'balam_agriculture_id'  => $licenseDataStore->id,
                    'dd_no'                 => (!empty($val)) ? intval($val) : '',
                    'dd_vat'                => (!empty($licenseFeeData['license_fee_dd']['vat_no'][$key])) ? intval($licenseFeeData['license_fee_dd']['vat_no'][$key]) : null,
                    'dd_tax'                => (!empty($licenseFeeData['license_fee_dd']['tax_no'][$key])) ? $licenseFeeData['license_fee_dd']['tax_no'][$key] : null,
                    'bank_name'             => (!empty($licenseFeeData['license_fee_dd']['bank_name'][$key])) ? $licenseFeeData['license_fee_dd']['bank_name'][$key] : null,
                    'dd_date'               => (!empty($licenseFeeData['license_fee_dd']['dd_date'][$key])) ? $licenseFeeData['license_fee_dd']['dd_date'][$key] : null,
                    'total'                 => !empty($licenseFeeData['license_fee_dd']['total'][$key]) ? $licenseFeeData['license_fee_dd']['total'][$key] : null,
                    'j1_date'               => now()
                ];
                $ddData['j1'] = $licenseFeeData['license_number'] . rand(0, 5);
                AgriDDInfo::create($ddData);
            }
        }

        return redirect()->back()->with('success', 'Successfully Updated License Data!');
    }

    public function destroy($id)
    {
        $getBalam = AgriBalam::find($id);
        if (!$getBalam) {
            return response(["msg" => "Invalid Delete Request!", 'icon' => "error"]);
        }

        foreach ($getBalam->dd as $dd) {
            AgriDDInfo::destroy($dd->id);
        }

        AgriBalam::destroy($getBalam->id);
        return response(["msg" => "Balam License Fee Collection Deleted", 'icon' => "success"]);
    }

    public function licenseFeeCollectionDate()
    {
        return request()->validate([
            'license_number' => 'required|numeric|digits_between:1,11',
            'from_date.license_fee_from_dd' => 'required',
            'from_date.license_fee_from_mm' => 'required',
            'from_date.license_fee_from_yy' => 'required',
            'to_date.license_fee_to_dd' => 'required',
            'to_date.license_fee_to_mm' => 'required',
            'to_date.license_fee_to_yy' => 'required',
        ]);
    }
}
