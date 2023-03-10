<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\CommercialLicense;
use App\Models\Backend\CommercialBalam;
use App\Models\Backend\CommercialDdInfo;
use App\Models\Backend\CommercialMouja;
use App\Models\Backend\CommercialVatTax;
use App\Models\Backend\CommercialLicenseOwner;
use App\Models\Backend\Station;
use Illuminate\Http\Request;
use Auth;

class CommercialFeeCollectionController extends Controller
{
    public function index()
    {
        return view('backend.content.commercial_fee_collection.index');
    }

    public function feeCollectForm(Request $request, $id)
    {
        $permission = Auth::user()->permissions;
        if (isset($permission[0]['name'])) {
            $permission_kachari = $permission[0]['name'];
        } else {
            $permission_kachari = 0;
        }

        $license = CommercialLicense::with('commercialMoujas', 'record', 'division', 'district', 'kachari', 'station', 'upazila')->find($id);
        if (Auth::user()->can('Administrator') || $license->kachari_id == $permission_kachari) {
            $license_owner = $license->commercialOwner;
            $license_balam = CommercialBalam::with('dd')->where('license_no', $license->generated_id)->get();
            return view('backend.content.commercial_fee_collection.fee_collect_form', compact('license', 'license_balam', 'license_owner'));
        } else {

            return redirect()->back()->withFlashDanger('Permission denied');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.content.commercial_fee_collection.create');
    }

    public function fetchFeeCalculator(Request $request)
    {
        // $licenseFeeData = $this->licenseFeeFetchCalculatorDataValidation($request);
        $licenseFeeData = $this->licenseFeeCollectionDate();

        if ($licenseFeeData) {
            $from_date = $licenseFeeData['from_date']['license_fee_from_yy'] . '-' . $licenseFeeData['from_date']['license_fee_from_mm'] . '-' . $licenseFeeData['from_date']['license_fee_from_dd'];
            $to_date = $licenseFeeData['to_date']['license_fee_to_yy'] . '-' . $licenseFeeData['to_date']['license_fee_to_mm'] . '-' . $licenseFeeData['to_date']['license_fee_to_dd'];
        }

        $getLicense = CommercialLicense::where('generated_id', $licenseFeeData['license_number'])->first();
        if (empty($getLicense)) {
            return response(['message' => '???????????????????????? ????????????????????? ???????????? ??????', 'status' => 'error']);
        }

        $licenseBalam = CommercialBalam::where('license_no', $licenseFeeData['license_number'])->orderBy('id', 'desc')->first();
        if (date("Y", strtotime(date("Y-m-d", strtotime($licenseBalam->to_date)) . " + " . 1 . " year")) < date('Y', strtotime($from_date))) {
            return response(['message' => '???????????????????????? ?????? ' . date('F j, Y,', strtotime($licenseBalam->to_date)) . ' ????????????????????? ???????????? ?????????????????? ????????????????????? ??????????????? ??????????????? ????????????', 'status' => 'warning']);
        }

        if (date("Y", strtotime(($licenseBalam->to_date))) > date('Y', strtotime($from_date))) {
            return response(['message' => '???????????????????????? ?????? ' . date('F j, Y,', strtotime($licenseBalam->to_date)) . ' ????????????????????? ???????????? ?????????????????? ????????????????????? ????????? ??????????????? ????????????', 'status' => 'warning']);
        }

        $getLicenseMoujas = CommercialMouja::where('license_id', $getLicense->id)->sum('leased_area');
        if (empty($getLicenseMoujas)) {
            return response(['message' => '?????????????????? ???????????? ?????????????????? ???????????? ??????????????? ???????????????', 'status' => 'error']);
        }

        $station_rate = Station::where('station_id', $getLicense->station_id)->pluck('fee_rate')->first();
        if (empty($station_rate)) {
            return response(['message' => '?????????????????? ?????? ????????? ?????????????????? ???????????? ??????????????? ???????????????', 'status' => 'error']);
        }

        $actualFeeData = 0;
        $feeDescriptionData = [];
        $yearDiff = date('y', strtotime($to_date)) - date('y', strtotime($from_date));
        $total_late_fee = 0;
        $actualFeeData = 0;

        for ($i = 0; $i < $yearDiff; $i++) {
            if ($to_date > $from_date) {
                $actualFeeData += $getLicenseMoujas * $station_rate;
                $newFromDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($from_date)) . " + " . $i . " year"));
                $newToDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($from_date)) . " + " . ($i + 1) . " year"));
                $late_fee = ($getLicenseMoujas * $station_rate * 10) / 100;

                if (date("Y", strtotime($newToDate)) > date('Y')) {
                    $late_fee = 0;
                }

                $total_late_fee += $late_fee;
                $feeDescriptionData[] = [
                    'from' => date('Y', strtotime($newFromDate)),
                    'to' => date('Y', strtotime($newToDate)),
                    'amount' => $getLicenseMoujas * $station_rate,
                    'late_fee' => round($late_fee),
                ];
            }
        }

        $totalAmount = $actualFeeData;
        $getTaxAmount = CommercialVatTax::orderBy('id', 'DESC')->first();

        if (!empty($getTaxAmount)) {
            $vatAmount = ($totalAmount * $getTaxAmount->vat) / 100;
            $taxAmount = ($totalAmount * $getTaxAmount->tax) / 100;
        } else {
            $vatAmount = 0;
            $taxAmount = 0;
        }

        $ownerLicense = CommercialLicenseOwner::where('license_id', $getLicense->id)->first();
        $ownerLicense = $ownerLicense->owner;
        $data = [
            'total' => $totalAmount,
            'land_amount' => $getLicenseMoujas,
            'vat' => $vatAmount,
            'tax' => $taxAmount,
            'license_fines' => $total_late_fee,
            'owner_info' => $ownerLicense,
            'description_data' => $feeDescriptionData,
            'station_rate' => $station_rate,
        ];
        return json_encode(['message' => 'Data Found', 'status' => 'success', 'data' => $data]);
    }

    public function licenseFeeFetchCalculatorDataValidation($request)
    {
        $data = $request->validate([
            'license_number' => 'required|numeric|digits_between:1,11',
            'from.from_year' => 'required|numeric',
            'from.from_month' => 'required|numeric',
            'from.from_day' => 'required|numeric',

            'to.to_year' => 'required|numeric',
            'to.to_month' => 'required|numeric',
            'to.to_day' => 'required|numeric',
        ]);

        return $data;
    }

    public function fetchFeeDetails(Request $request)
    {
        $licenseFeeData = $this->licenseFeeFetchDataValidation($request);
        $license = CommercialLicense::with('record', 'commercialOwner', 'commercialMoujas', 'division', 'district', 'kachari', 'station', 'upazila')
            ->where('generated_id', $licenseFeeData['license_number'])
            ->first();

        if (empty($license)) {
            return json_encode(['message' => 'Invalid License Number', 'status' => 'error']);
        }
        $commercial_mojas = commercial_license_moujas($license->commercialMoujas);

        $data = [
            'license' => $license,
            'license_owner' => $license->commercialOwner,
            'formatted_data' => [
                'commercial_mojas' => $commercial_mojas,
                'land_total_qty' => $license->commercialMoujas->sum('property_amount'),
                'land_leased_qty' => $license->commercialMoujas->sum('leased_area'),
                'demand_notice_date' => date('F j, Y', strtotime($license->demand_notice_date)) ?? 'N/A',
                'map_date' => date('F j, Y', strtotime($license->land_map_date)) ?? 'N/A',
                'license_copy' => $license->land_map_certificate ? asset($license->land_map_certificate) : '',
            ],
        ];

        return json_encode(['message' => 'Data Found', 'status' => 'success', 'data' => $data]);
    }

    public function licenseFeeFetchDataValidation($request)
    {
        $data = $request->validate([
            'license_number' => 'required|numeric|digits_between:1,11',
        ]);

        return $data;
    }

    public function licenseFeeCollectionDataValidation($request)
    {
        $data = $request->validate([
            'license_number' => 'required|numeric|digits_between:1,11',
            'license_owner_id' => 'required|numeric|digits_between:1,11',
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
            'license_fee_dd' => 'array',
        ]);
        return $data;
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

    public function store(Request $request)
    {
        $licenseFeeData = $this->licenseFeeCollectionDataValidation($request);
        $fee_collection_date = $this->licenseFeeCollectionDate();

        if ($fee_collection_date) {
            $from_date = $fee_collection_date['from_date']['license_fee_from_yy'] . '-' . $fee_collection_date['from_date']['license_fee_from_mm'] . '-' . $fee_collection_date['from_date']['license_fee_from_dd'];
            $to_date = $fee_collection_date['to_date']['license_fee_to_yy'] . '-' . $fee_collection_date['to_date']['license_fee_to_mm'] . '-' . $fee_collection_date['to_date']['license_fee_to_dd'];
        }

        $data = [
            'owner_id' => $licenseFeeData['license_owner_id'],
            'license_no' => $licenseFeeData['license_number'],
            'from_date' => date('Y-m-d h:i:s', strtotime($from_date)),
            'to_date' => date('Y-m-d h:i:s', strtotime($to_date)),
            'license_type' => 'commercial',
            'license_fee' => $licenseFeeData['license_fee'],
            'vat' => $licenseFeeData['license_vat'],
            'tax' => $licenseFeeData['license_tax'],
            'fine' => $licenseFeeData['license_fines'],
            'security' => $licenseFeeData['license_security'],
            'plan_fee' => $licenseFeeData['license_plan_fee'],
            'application_fee' => $licenseFeeData['license_application_fee'],
            'mutation_fee' => $licenseFeeData['license_renew_fee'],
            'naming' => $licenseFeeData['license_naming_fee'],
            'total_fee' => $licenseFeeData['license_total_amount'],
            'user_id' => $licenseFeeData['user_id'],
        ];


        $licenseDataStore = CommercialBalam::create($data);

        if (!$licenseDataStore) {
            return redirect()
                ->back()
                ->with('error', 'Error occured! Please try again.');
        }

        $ddInfo = new CommercialDdInfo;
        $count = count(array_unique(array_column($ddInfo->select('j1')->get()->toArray(), 'j1'))) + 1;

        foreach ($licenseFeeData['license_fee_dd']['dd_no'] as $key => $val) {
            $ddData = [
                'balam_commercial_id' => $licenseDataStore->id,
                'dd_no' => !empty($val) ? intval($val) : null,
                'dd_vat' => !empty($licenseFeeData['license_fee_dd']['vat_no'][$key]) ? intval($licenseFeeData['license_fee_dd']['vat_no'][$key]) : null,
                'dd_tax' => !empty($licenseFeeData['license_fee_dd']['tax_no'][$key]) ? $licenseFeeData['license_fee_dd']['tax_no'][$key] : null,
                'bank_name' => !empty($licenseFeeData['license_fee_dd']['bank_name'][$key]) ? $licenseFeeData['license_fee_dd']['bank_name'][$key] : null,
                'dd_date' => !empty($licenseFeeData['license_fee_dd']['dd_date'][$key]) ? $licenseFeeData['license_fee_dd']['dd_date'][$key] : null,
                'total' => !empty($licenseFeeData['license_fee_dd']['total_amount'][$key]) ? $licenseFeeData['license_fee_dd']['total_amount'][$key] : null,
                'j1_date' => now(),
            ];
            $ddData['j1'] = "C" . $count;
            $ddInfo->create($ddData);
        }

        if ($licenseFeeData['user_phone']) {
            $txt = $licenseFeeData['license_number'] . " ?????? ?????????????????????????????? " . date('F j, Y', strtotime($from_date)) . " ????????? " . date('F j, Y', strtotime($from_date)) . " ???????????????????????? ???????????????????????? ?????? ??????????????? ?????????????????? ???????????????????????? ??????????????????";
            send_ware_SMS($txt, $licenseFeeData['user_phone']);
        }

        return redirect()
            ->back()
            ->with('success', '???????????????????????? ?????? ??????????????? ???????????????????????? ???????????????');
    }

    public function show($id)
    {
        $balam = CommercialBalam::find($id);
        $license = CommercialLicense::with('commercialMoujas', 'record', 'division', 'district', 'kachari', 'station', 'upazila')->where('generated_id', $balam->license_no)->first();
        $license_owner = $license->commercialOwner;
        return view('backend.content.commercial_fee_collection.show', compact('license', 'balam', 'license_owner'));
    }

    public function edit($id)
    {
        $balam = CommercialBalam::with('commercialOwner')->findOrFail($id);
        $license = CommercialLicense::where('generated_id', $balam->license_no)->with('commercialOwner', 'commercialMoujas')->first();

        $last_payment_date = [];
        if ($balam) {
            $last_payment_date['balam_id'] = $balam->id;
            if ($balam->from_date) {
                $last_payment_date['from_date']['year'] = date('Y', strtotime($balam->from_date));
                $last_payment_date['from_date']['month'] = date('m', strtotime($balam->from_date));
                $last_payment_date['from_date']['day'] = date('d', strtotime($balam->from_date));
            }
            if ($balam->to_date) {
                $last_payment_date['to_date']['year'] = date('Y', strtotime($balam->to_date));
                $last_payment_date['to_date']['month'] = date('m', strtotime($balam->to_date));
                $last_payment_date['to_date']['day'] = date('d', strtotime($balam->to_date));
            }
        }
        // dd($balam->from_date);
        return view('backend.content.commercial_fee_collection.edit', compact('balam', 'id', 'license', 'last_payment_date'));
    }

    public function update($id, Request $request)
    {
        $licenseFeeData = $this->licenseFeeCollectionDataValidation($request);
        $fee_collection_date = $this->licenseFeeCollectionDate();

        $licenseDataStore = CommercialBalam::findOrFail($id);
        $licenseDataStore->owner_id = $licenseFeeData['license_owner_id'];
        $licenseDataStore->license_fee = $licenseFeeData['license_fee'];
        $licenseDataStore->vat = $licenseFeeData['license_vat'];
        $licenseDataStore->tax = $licenseFeeData['license_tax'];
        $licenseDataStore->fine = $licenseFeeData['license_fines'];
        $licenseDataStore->security = $licenseFeeData['license_security'];
        $licenseDataStore->plan_fee = $licenseFeeData['license_plan_fee'];
        $licenseDataStore->application_fee = $licenseFeeData['license_application_fee'];
        $licenseDataStore->mutation_fee = $licenseFeeData['license_renew_fee'];
        $licenseDataStore->naming = $licenseFeeData['license_naming_fee'];
        $licenseDataStore->total_fee = intval($licenseFeeData['license_fee'] + $licenseFeeData['license_vat'] + $licenseFeeData['license_tax'] + $licenseFeeData['license_fines'] + $licenseFeeData['license_security'] + $licenseFeeData['license_plan_fee'] + $licenseFeeData['license_application_fee'] + $licenseFeeData['license_renew_fee'] + $licenseFeeData['license_naming_fee']);

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
                CommercialDdInfo::destroy($dd->id);
            }
            // dd($licenseFeeData['license_fee_dd']);
            // Inserting updated DD Infos
            foreach ($licenseFeeData['license_fee_dd']['dd_no'] as $key => $val) {
                $ddData = [
                    'balam_commercial_id' => $licenseDataStore->id,
                    'dd_no' => !empty($val) ? intval($val) : '',
                    'dd_vat' => !empty($licenseFeeData['license_fee_dd']['vat_no'][$key]) ? intval($licenseFeeData['license_fee_dd']['vat_no'][$key]) : null,
                    'dd_tax' => !empty($licenseFeeData['license_fee_dd']['tax_no'][$key]) ? $licenseFeeData['license_fee_dd']['tax_no'][$key] : null,
                    'bank_name' => !empty($licenseFeeData['license_fee_dd']['bank_name'][$key]) ? $licenseFeeData['license_fee_dd']['bank_name'][$key] : null,
                    'dd_date' => !empty($licenseFeeData['license_fee_dd']['dd_date'][$key]) ? $licenseFeeData['license_fee_dd']['dd_date'][$key] : null,
                    'total' => !empty($licenseFeeData['license_fee_dd']['total'][$key]) ? $licenseFeeData['license_fee_dd']['total'][$key] : null,
                    'j1_date'               => now()
                ];
                $ddData['j1'] = "C" . $licenseFeeData['license_number'] . rand(0, 5);
                CommercialDdInfo::create($ddData);
            }
        }

        return redirect()
            ->back()
            ->with('success', 'Successfully Updated License Data!');
    }

    public function destroy($id)
    {
        $getBalam = CommercialBalam::find($id);
        if (!$getBalam) {
            return response(['msg' => 'Invalid Delete Request!', 'icon' => 'error']);
        }

        foreach ($getBalam->dd as $dd) {
            CommercialDdInfo::destroy($dd->id);
        }

        CommercialBalam::destroy($getBalam->id);
        return response(['msg' => 'Balam License Fee Collection Deleted', 'icon' => 'success']);
    }
}
