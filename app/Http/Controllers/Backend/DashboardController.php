<?php

namespace App\Http\Controllers\Backend;

use App\Models\Backend\AgriBalam;
use App\Models\Backend\AgricultureLicense;
use App\Models\Backend\CaseDetails;
use App\Models\Backend\CommercialLicense;
use App\Models\Backend\AgencyLicense;
use App\Models\Backend\InventoryDetails;
use App\Models\Backend\Kachari;
use App\Models\Backend\ledger;
use App\Models\Backend\MasterPlan;
use App\Models\Backend\Mouja;
use App\Models\Backend\plot;
use App\Models\Backend\PondLicense;
use App\Models\Backend\Record;
use App\Models\Backend\Section;
use App\Models\Backend\Station;
use App\Models\Backend\Tender;
use PhpParser\Node\Stmt\Case_;
use Illuminate\Support\Facades\DB;
use App\Models\Backend\CommercialBalam;
use App\Models\Backend\PondBalam;
use App\Models\Backend\AgencyBalam;
use App\Models\Backend\AgriMouja;


/**
 * Class DashboardController.
 */
class DashboardController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $agriTotal = 0;
        $agiLicense = AgricultureLicense::withSum('balam', 'total_fee')->get();
        foreach ($agiLicense as $agriVal) {
            $agriTotal += $agriVal->balam_sum_total_fee;
        }

        $data['agri_license_total'] = $agriTotal;
        $data['agri_license'] = $agiLicense->count();
        $commTotal = 0;
        $commLicense = CommercialLicense::withSum('balam', 'total_fee')->get();
        foreach ($commLicense as $comVal) {
            $commTotal += $comVal->balam_sum_total_fee;
        }
        $data['commercial_license_total'] = $commTotal;
        $data['commercial_license'] = $commLicense->count();

        $pondTotal = 0;
        $pondLicense = PondLicense::withSum('balam', 'total_fee')->get();
        foreach ($pondLicense as $pondVal) {
            $pondTotal += $pondVal->balam_sum_total_fee;
        }
        $data['pound_license_total'] = $pondTotal;
        $data['pound_license'] = $pondLicense->count();

        $agencyTotal = 0;
        $agencyLicense = AgencyLicense::withSum('balam', 'total_fee')->get();

        foreach ($agencyLicense as $agencyVal) {
            $agencyTotal += $agencyVal->balam_sum_total_fee;
        }
        $data['agency_license_total'] = $agencyTotal;
        $data['agency_license'] = $agencyLicense->count();
        //dd($data['agency_license_total']);

        /***************new dashboard *********/
        $data['cs_ledger_data'] = ledger::with('plotamount')->withSum('plotamount', 'land_amount')->where('record_name', '1')->get()->sum('plotamount_sum_land_amount');
        $data['sa_ledger_data'] = ledger::with('plotamount')->withSum('plotamount', 'land_amount')->where('record_name', '2')->get()->sum('plotamount_sum_land_amount');
        $data['rs_ledger_data'] = ledger::with('plotamount')->withSum('plotamount', 'land_amount')->where('record_name', '3')->get()->sum('plotamount_sum_land_amount');

        // dd($data['cs_ledger_data']);
        $data['cs_ledger'] = ledger::with('plotamount')->withSum('plotamount', 'land_amount')->where('record_name', '1')->count();
        $data['sa_ledger'] = ledger::with('plotamount')->withSum('plotamount', 'land_amount')->where('record_name', '2')->count();
        $data['rs_ledger'] = ledger::with('plotamount')->withSum('plotamount', 'land_amount')->where('record_name', '3')->count();
        //dd($data['rs_ledger']);
        $data['financial_year'] = DB::table('financial_year')->where('status', 1)->first();

        $monthFrom = $data['financial_year']->from_date;
        $monthTo = $data['financial_year']->to_date;


        $data['agriBalam_total'] = AgriBalam::select('agri_balam.*')->whereBetween('created_at', [$monthFrom, $monthTo])->get()->sum('total_fee');
        $data['comBalam_total'] = CommercialBalam::select('commercial_balam.*')->whereBetween('created_at', [$monthFrom, $monthTo])->get()->sum('total_fee');
        $data['pondBalam_total'] = PondBalam::select('pond_balam.*')->whereBetween('created_at', [$monthFrom, $monthTo])->get()->sum('total_fee');
        $data['agencyBalam_total'] = AgencyBalam::select('agency_balam.*')->whereBetween('created_at', [$monthFrom, $monthTo])->get()->sum('total_fee');
        $data['total_amount_fyear'] =  $data['agriBalam_total'] + $data['comBalam_total'] + $data['pondBalam_total'] + $data['agencyBalam_total'];

        /************leased area**** */
        $agrileased = 0;
        $searchResult = AgricultureLicense::with('balam', 'agriMoujas')->get();
        foreach ($searchResult  as $val) {
            $license_moujas = license_moujas($val->agriMoujas);
            $agrileased += english_number($license_moujas['leased_area']);
        }

        $data['agri_leased'] = $agrileased;
        $commercaileased = 0;
        $commercailsearchResult = CommercialLicense::with('balam', 'commercialMoujas')->get();

        foreach ($commercailsearchResult  as $val) {
            $commercial_license_moujas = commercial_license_moujas($val->commercialMoujas);
            $commercaileased += english_number($commercial_license_moujas['leased_area']);
        }

        $data['commercial_leased'] = $commercaileased;
        //dd($data['commercial_leased']);

        /********Operator************ */ 
        $data['ledger_one'] = ledger::where('user_id','7')->count();
        $data['kishi_one'] = AgricultureLicense::where('user_id','7')->count();
        $data['commer_one'] = CommercialLicense::where('user_id','7')->count();
        $data['pond_one'] = PondLicense::where('user_id','7')->count();
       
        $pondleased = 0;
        $pondsearchResult = PondLicense::with('balam', 'pondMoujas')->get();
        foreach ($pondsearchResult  as $val) {
            $license_moujas1 = license_moujas($val->pondMoujas);
            $pondleased += english_number($license_moujas1['leased_area']);
        }

        $data['pond_leased'] = $pondleased;

        $agencyleased = 0;
        $agencysearchResult = AgencyLicense::with('balam', 'agencyMoujas')->get();
        $data['ledger_Two'] = ledger::where('user_id','8')->count();
        $data['kishi_two'] = AgricultureLicense::where('user_id','8')->count();
        $data['commer_two'] = CommercialLicense::where('user_id','8')->count();
        $data['pond_two'] = PondLicense::where('user_id','8')->count();

        /********Operator************ */
        foreach ($agencysearchResult  as $val) {
            $agency_moujas = agency_license_moujas($val->agencyMoujas);
            $agencyleased += english_number($agency_moujas['property_amount']);
        }

        $data['agency_leased'] = $agencyleased;

        /***************new dashboard *********/
        $data['ledger'] = ledger::count();
        $data['station'] = Station::select('station_name')->distinct()->pluck('station_name')->count();
        $data['section'] = Section::count();
        $data['record'] = Record::count();
        $data['kachari'] = Kachari::count();
        $data['mouja'] = Mouja::count();
        $data['plot'] = plot::count();
        $data['masterplan'] = MasterPlan::count();
        $data['inventory'] = InventoryDetails::count();
        $data['case'] = CaseDetails::count();
        $data['commercial_tender'] = Tender::count();
        $data['pond_tender'] = Tender::count();
        return view('backend.dashboard', compact('data'));
    }
}
