<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Backend\AgriBalam;
use App\Models\Backend\CommercialBalam;
use App\Models\Backend\PondBalam;
use App\Models\Backend\AgencyBalam;


class InvoiceGenerateController extends Controller
{
    public function clintCopy()
    {
        $data = $this->invoiceInformation();
        $license_details = $data['license_details'];
        $license_owner = $data['license_owner'];
        return view('backend.content.invoice.client_copy', compact('license_details', 'license_owner'));
    }

    public function invoiceInformation()
    {
        $license_type = request('type', null);
        $license_no = request('id', null);
        $license_details = null;

        if ($license_type === "agriculture") {
            $license_details = AgriBalam::with('dd', 'agriLicense')->where('license_no', $license_no)->first();
            if (!$license_details) {
                return redirect()->back()->withFlasDanger("এই লাইসেন্স এর ফি করা হইনি");
            }
            $license_owner = $license_details->agriLicense->agriOwner;
            $license_details['license_type'] = "কৃষি";
            $license_details['license'] = $license_details->agriLicense;
            $license_details['license_mouja'] = license_moujas($license_details->agriLicense->agriMoujas);
            $license_details['license_dd_info'] = dd_info($license_details->dd);
            $license_details['generate_url'] = url('invoice/single/agriculture/' . $license_details->license_no);
        } elseif ($license_type === "commercial") {
            $license_details = CommercialBalam::with('dd', 'commercialLicense')->where('license_no', $license_no)->first();
            if (!$license_details) {
                return redirect()->back()->withFlasDanger("এই লাইসেন্স এর ফি করা হইনি");
            }
            $license_owner =  $license_details->commercialLicense->commercialOwner;
            $license_details['license_type'] = "বাণিজ্যিক";
            $license_details['license'] = $license_details->commercialLicense;
            $license_details['license_mouja'] = commercial_license_moujas($license_details->commercialLicense->commercialMoujas);
            $license_details['license_dd_info'] = dd_info($license_details->dd);
            $license_details['generate_url'] = url('invoice/single/commercial/' . $license_details->license_no);
        } elseif ($license_type === "agency") {
            // dd($license_no);
            $license_details = AgencyBalam::with('dd', 'agencyLicense')->where('license_no', $license_no)->first();
            //dd($license_details);
            if (!$license_details) {
                return redirect()->back()->withFlasDanger("এই লাইসেন্স এর ফি করা হইনি");
            }
            $license_owner =  $license_details->agencyLicense->agencyOwner;
            $license_details['license_type'] = "সংস্থা";
            $license_details['license'] = $license_details->agencyLicense;
            $license_details['license_mouja'] = agency_license_moujas($license_details->agencyLicense->agencyMoujas);
            //dd($license_details['license_mouja']);
            $license_details['license_dd_info'] = dd_info($license_details->dd);
            $license_details['generate_url'] = url('invoice/single/agency/' . $license_details->license_no);
            //dd( $license_details['generate_url']);
        } else {
            $license_details = PondBalam::with('dd', 'pondOwner', 'pondLicense')->where('license_no', $license_no)->first();
            if (!$license_details) {
                return redirect()->back()->withFlasDanger("এই লাইসেন্স এর ফি করা হইনি");
            }
            $license_owner =  $license_details->pondLicense->pondOwner;
            $license_details['license_type'] = "জলাশয়";
            $license_details['license'] = $license_details->pondLicense;
            $license_details['license_mouja'] = license_moujas($license_details->pondMoujas->mouja);
            $license_details['license_dd_info'] = dd_info($license_details->dd);
            $license_details['generate_url'] = url('invoice/single/pond/' . $license_details->license_no);
        }

        return ['license_details' => $license_details, 'license_owner' => $license_owner];
    }
}
