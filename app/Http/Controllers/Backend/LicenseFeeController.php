<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\AgencyBalam;
use App\Models\Backend\AgencyDDInfo;
use App\Models\Backend\AgencyLicense;
use App\Models\Backend\AgriBalam;
use App\Models\Backend\AgricultureLicense;
use App\Models\Backend\AgriDDInfo;
use App\Models\Backend\CommercialBalam;
use App\Models\Backend\CommercialDdInfo;
use App\Models\Backend\CommercialLicense;
use App\Models\Backend\District;
use App\Models\Backend\Division;
use App\Models\Backend\Kachari;
use App\Models\Backend\PondBalam;
use App\Models\Backend\PondDDInfo;
use App\Models\Backend\PondLicense;
use App\Models\Backend\Station;
use App\Models\Backend\Upazila;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Artisan;

class LicenseFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Artisan::call('cache:clear');
        $license_station = request('station_id', null);
        $monthFrom = request('month-from', null);
        $monthTo = request('month-to', null);
        $license_type = request('license_type', null);
        $license_no = request('license_no', null);
        $searchResult = [];
        $dd_information = [];
        $station_name = [];

        // return redirect()->back()->withFlashDander('দুঃখিত! অনুগ্রহপূর্বক দপ্ততর বাছাই করুন.');
        // return redirect()->back()->withFlashDander('দুঃখিত! অনুগ্রহপূর্বক লাইসেন্সের ধরন বাছাই করুন.');
        // return redirect()->back()->withFlashDander('দুঃখিত! লাইসেন্স নম্বরটি খুজে পাওয়া যায় নাই.');
        // if (!$license_type) {
        //     return redirect()->back()->withFlashDander('দুঃখিত! অনুগ্রহপূর্বক লাইসেন্সের ধরন বাছাই করুন.');
        // }

        $station = Station::pluck('station_name', 'station_id');
        if ($license_station || $license_type) {
            if (!$license_type) {
                return redirect()->back()->withFlashDanger('দুঃখিত! অনুগ্রহপূর্বক লাইসেন্সের ধরন বাছাই করুন.');
            }
            if ($license_type == "agriculture") {
                $searchResult = AgriBalam::select('agri_balam.*')
                    ->join('agriculture_licenses', 'agri_balam.license_no', '=', 'agriculture_licenses.generated_id');
                $dd_information = AgriDDInfo::get();
            }

            if ($license_type == "commercial") {
                $searchResult = CommercialBalam::select('commercial_balam.*')
                    ->join('commercial_license', 'commercial_balam.license_no', '=', 'commercial_license.generated_id');
                $dd_information = CommercialDdInfo::get();
            }
            if ($license_type == "pond") {
                $searchResult = PondBalam::orderByDesc('id');
                $searchResult = PondBalam::select('pond_balam.*')
                    ->join('pond_licenses', 'pond_balam.license_no', '=', 'pond_licenses.generated_id');
                $dd_information = PondDDInfo::get();
            }
            if ($license_type == "agency") {
                $searchResult = AgencyBalam::orderByDesc('id');
                $searchResult = AgencyBalam::select('agency_balam.*')
                    ->join('agency_license', 'agency_balam.license_no', '=', 'agency_license.generated_id');
                $dd_information = AgencyDDInfo::get();
            }

            if ($license_station) {
                $searchResult = $searchResult->where('station_id', $license_station);
                $station_name =  Station::where('station_id', $license_station)->pluck('station_name');
            }

            if ($monthFrom || $monthTo) {
                $searchResult = $searchResult->whereBetween('created_at', [$monthFrom, $monthTo]);
            }
            if ($license_no) {
                $searchResult = $searchResult->where('generated_id', $license_no);
            }

            $searchResult = $searchResult->orderBy('id', 'desc')->paginate(20);
        } else {
            // return redirect()->back()->withFlashDander('দুঃখিত!');
        }

        return view('backend.content.all_license_fees_collection.index', compact('searchResult', 'station', 'dd_information', 'station_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.content.all_license_fees_collection.create');
    }


    public function findLicense()
    {
        $license = [];
        $license_owner = [];
        $license_balam = [];
        $license_balam_dd = null;
        $license_number = request('license_number', null);
        $id = request('license_number', null);
        $result = substr($id, 1, 1);
        $bn_months = array("বৈশাখ", "জ্যৈষ্ঠ", "আষাঢ়", "শ্রাবণ", "ভাদ্র", "আশ্বিন", "কার্তিক", "অগ্রহায়ণ", "পৌষ", "মাঘ", "ফাল্গুন", "চৈত্র");

        // dd($result);
        if ($result == 1) {
            $license = AgricultureLicense::with('record', 'agriMoujas', 'division', 'district', 'kachari', 'station', 'upazila')->where('generated_id', $license_number)->first();
            if ($license) {
                $license_owner = $license->agriOwner;
                $license_balam = AgriBalam::with('dd')->where('license_no', $license->generated_id)->get();
                $license_balam_dd = AgriDDInfo::get();
                return view('backend.content.agri_fee_collection.fee_collect_form', compact('license', 'license_owner', 'license_balam', 'license_balam_dd', 'bn_months'));
            }
            return redirect()->back()->withFlashDanger("এই লাইসেন্স নম্বর দিয়ে কোন তথ্য খুজে পাওয়া যাইনি");
        }
        if ($result == 2) {
            $license = CommercialLicense::with('commercialMoujas', 'record', 'division', 'district', 'kachari', 'station', 'upazila')->where('generated_id', $license_number)->first();
            if ($license) {
                $license_owner = $license->commercialOwner;
                $license_balam = CommercialBalam::with('dd')->where('license_no', $license->generated_id)->get();
                $license_balam_dd = CommercialDdInfo::get();
                return view('backend.content.commercial_fee_collection.fee_collect_form', compact('license', 'license_owner', 'license_balam', 'license_balam_dd'));
            }
            return redirect()->back()->withFlashDanger("এই লাইসেন্স নম্বর দিয়ে কোন তথ্য খুজে পাওয়া যাইনি");
        }
        if ($result == 3) {
            $license = PondLicense::with('record', 'pondMoujas', 'division', 'district', 'kachari', 'station', 'upazila')->where('generated_id', $license_number)->first();
            if ($license) {
                $license_owner = $license->pondOwner;
                $license_balam = PondBalam::with('dd')->where('license_no', $license->generated_id)->get();
                $license_balam_dd = PondDDInfo::get();
                return view('backend.content.pond_fee_collection.fee_collect_form', compact('license', 'license_owner', 'license_balam', 'license_balam_dd', 'bn_months'));
            }
            return redirect()->back()->withFlashDanger("এই লাইসেন্স নম্বর দিয়ে কোন তথ্য খুজে পাওয়া যাইনি");
        }
        if ($result == 4) {
            $license = AgencyLicense::with('record', 'agencyMoujas', 'division', 'district', 'kachari', 'station', 'upazila')->where('generated_id', $license_number)->first();
            if ($license) {
                $license_owner = $license->agencyOwner;
                $license_balam = AgencyBalam::with('dd')->where('license_no', $license->generated_id)->get();
                $license_balam_dd = AgencyDDInfo::get();
                return view('backend.content.agency_fee_collection.fee_collect_form', compact('license', 'license_owner', 'license_balam', 'license_balam_dd'));
            }
            return redirect()->back()->withFlashDanger("এই লাইসেন্স নম্বর দিয়ে কোন তথ্য খুজে পাওয়া যাইনি");
        } else {
            dd("coming soon !");
        }
    }


    public function allLicenseDueFees()
    {
        $license_station = request('station_id', null);
        $monthFrom = request('month-from', null);
        $monthTo = request('month-to', null);
        $license_type = request('license_type', null);
        $license_no = request('license_no', null);
        $division_id = request('division_id', "");
        $kachari_id = request('kachari_id', "");
        $district_id = request('district_id', "");
        $upazila_id = request('upazila_id', "");
        $station_id = request('station_id', "");

        $searchResult = [];
        $dd_information = [];
        $station_name = [];
        $division = Division::pluck('division_name', 'division_id');
        $station = Station::pluck('station_name', 'station_id');
        $kachari = Kachari::pluck('kachari_name', 'kachari_id');
        $district = District::pluck('district_name', 'district_id');
        $upazila = Upazila::pluck('upazila_name', 'upazila_id');


        // if (!$license_type) {
        //     return redirect()->back()->withFlashDander('দুঃখিত! অনুগ্রহপূর্বক লাইসেন্সের ধরন বাছাই করুন.');
        // }
        if ($license_type) {
            if (!$license_type) {
                return redirect()->back()->withFlashDanger('দুঃখিত! অনুগ্রহপূর্বক লাইসেন্সের ধরন বাছাই করুন.');
            }
            if ($license_type == "agriculture") {
                $searchResult = AgriBalam::select('agri_balam.*')
                    ->join('agriculture_licenses', 'agri_balam.license_no', '=', 'agriculture_licenses.generated_id')
                    ->where('agri_balam.to_date', '<', now())->orderByDesc('id');
                // $searchResult['license_type'] = $license_type;
                $dd_information = AgriDDInfo::get();
            }
            if ($license_type == "commercial") {
                $searchResult = CommercialBalam::select('commercial_balam.*')
                    ->join('commercial_license', 'commercial_balam.license_no', '=', 'commercial_license.generated_id')
                    ->where('commercial_balam.to_date', '<', now())->orderByDesc('id');
                $dd_information = CommercialDdInfo::get();
            }
            if ($license_type == "pond") {
                $searchResult = PondBalam::select('pond_balam.*')
                    ->join('pond_licenses', 'pond_balam.license_no', '=', 'pond_licenses.generated_id')
                    ->where('pond_balam.to_date', '<', now())->orderByDesc('id');
                $dd_information = PondDDInfo::get();
            }
            if ($license_type == "agency") {
                $searchResult = AgencyBalam::select('agency_balam.*')
                    ->join('agency_license', 'agency_balam.license_no', '=', 'agency_license.generated_id')
                    ->where('agency_balam.to_date', '<', now())->orderByDesc('id');
                $dd_information = AgencyDDInfo::get();
            }

            if ($license_station) {
                if ($license_type != "agency") {
                    $searchResult = $searchResult->where('station_id', $license_station);
                }
                $station_name =  Station::where('station_id', $license_station)->pluck('station_name');
            }
            if ($monthTo) {
                $searchResult = $searchResult->where('to_date', '<=', $monthTo);
            }

            if ($license_no) {
                $searchResult = $searchResult->where('generated_id', $license_no);
            }

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

            $searchResult = $searchResult->orderBy('id', 'desc')->paginate(20);
        } else {
            // return back()->withFlashDander('দুঃখিত! অনুগ্রহপূর্বক লাইসেন্সের ধরন বাছাই করুন.');
        }

        return view('backend.content.all_license_fees_collection.licenses_due', compact('searchResult', 'station', 'dd_information', 'station_name', 'division', 'kachari', 'district', 'upazila'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    public function getLicenseFees()
    {
    }
}
