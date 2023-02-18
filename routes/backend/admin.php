<?php

use App\Http\Controllers\Backend\AcquisitionController;
use App\Http\Controllers\Backend\AgencyLicenseController;
use App\Http\Controllers\Backend\DistrictController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\UpazillaController;
use App\Http\Controllers\Backend\StationController;
use App\Http\Controllers\Backend\MoujaController;

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\LedgerController;
use App\Http\Controllers\Backend\AgricultureController;
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Backend\DesignationController;

use App\Http\Controllers\Backend\AgricultureLicenseFeeCollectionController;
use App\Http\Controllers\Backend\CommercialFeeCollectionController;
use App\Http\Controllers\Backend\AgencyLicenseFeeCollectionController;
use App\Http\Controllers\Backend\CommercialLicenseController;
use App\Http\Controllers\Backend\CommercialTenderController;
use App\Http\Controllers\Backend\MasterPlanController;
use App\Http\Controllers\Backend\MasterPlanPlotController;


use App\Http\Controllers\Backend\PlotController;
use App\Http\Controllers\Backend\PondController;
use App\Http\Controllers\Backend\PondLicenseFeeController;
use App\Http\Controllers\Backend\TenderController;
use App\Http\Controllers\Backend\CaseDateController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\Backend\InventoryController;
use App\Http\Controllers\Backend\InvoiceGenerateController;
use App\Http\Controllers\Backend\LicenseFeeController;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);

Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Dashboard'), route('admin.dashboard'));
    });

Route::resource('district', DistrictController::class);
Route::resource('upazilla', UpazillaController::class);
Route::resource('station', StationController::class);
Route::resource('mouja', MoujaController::class);
Route::resource('site_settings', SettingController::class);

Route::resource('ledger', LedgerController::class);

Route::get('/ledger-search', [LedgerController::class, 'search'])->name('ledger.search-result');

Route::post('/fetch/kachari', [LedgerController::class, 'fetchKachari'])->name('ledger.fetch-kachari');
Route::post('/fetch/district', [LedgerController::class, 'fetchDistrict'])->name('ledger.fetch-district');
Route::post('/fetch/upazila', [LedgerController::class, 'fetchUpazila'])->name('ledger.fetch-upazila');
Route::post('/fetch/station', [LedgerController::class, 'fetchStation'])->name('ledger.fetch-station');
Route::post('/fetch/mouja', [LedgerController::class, 'fetchMouja'])->name('ledger.fetch-mouja');
Route::post('/fetch/record', [LedgerController::class, 'fetchRecord'])->name('ledger.fetch-record');
Route::post('/fetch/ledger', [LedgerController::class, 'fetchLedger'])->name('ledger.fetch-ledger');
Route::post('/fetch/plot', [LedgerController::class, 'fetchPlot'])->name('ledger.fetch-plot');
Route::post('/fetch/masterplan', [LedgerController::class, 'fetchMasterPlan'])->name('ledger.fetch-masterplan');
Route::post('/fetch/masterplanplot', [LedgerController::class, 'fetchMasterPlanPlot'])->name('ledger.fetch-masterplan-plot');

Route::post('/land/type', [LedgerController::class, 'fetchLandType'])->name('ledger.land-type');
Route::post('/new-ledger', [LedgerController::class, 'store'])->name('ledger.store');

Route::post('/new-plot', [LedgerController::class, 'newplot'])->name('plot.store');
Route::post('/new-acquisition', [LedgerController::class, 'acquisition'])->name('acquisition.store');

Route::resource('plot', PlotController::class);
Route::resource('acquisition', AcquisitionController::class);
Route::resource('site_settings', SettingController::class);

/******************License Fee Controller**************/
Route::resource('all_license_fees', LicenseFeeController::class);
Route::get('all_license_due_fees', [LicenseFeeController::class, 'allLicenseDueFees'])->name('all.license.due');
Route::get('find-license', [LicenseFeeController::class, 'findLicense'])->name('find.license');
/******************License Fee Controller**************/


/******************License PDF**************/

/******************License PDF End**************/

/******************Agriculture license**************/
Route::resource('agriculture', AgricultureController::class);
// Route::post('/new-agriculture', [AgricultureController::class, 'newAgriculture'])->name('agriculture.store');
Route::post('/new-owner', [AgricultureController::class, 'newOwner'])->name('owner.store');
Route::post('/new-fee', [AgricultureController::class, 'newFee'])->name('fee.store');
Route::post('/new-area', [AgricultureController::class, 'newArea'])->name('area.store');
Route::post('/new-location', [AgricultureController::class, 'newLocation'])->name('location.store');
Route::post('/new-acceptance', [AgricultureController::class, 'newAcceptance'])->name('acceptance.store');
Route::get('/license/mouja/delete/{id}', [AgricultureController::class, 'licenseMoujaDelete'])->name('license_mouja.delete');
Route::post('/license/owner/delete/{id}', [AgricultureController::class, 'licenseOwnerDelete'])->name('license_owner.delete');
Route::post('/license/owner/delete/{id}', [AgricultureController::class, 'licenseOwnerDelete'])->name('license_owner.delete');
Route::post('/agriculture-license/status/', [AgricultureController::class, 'licenseStatus'])->name('agri_license.status');


/******************Agriculture license Fee Collection**************/
Route::resource('agri-license-fees', AgricultureLicenseFeeCollectionController::class);
Route::delete('agri-license-fees/{id}', [AgricultureLicenseFeeCollectionController::class, 'destroy']);
Route::get('license-fee-details', [AgricultureLicenseFeeCollectionController::class, 'fetchFeeDetails'])->name('agriculture.license.fee.details');
Route::get('license-fee-calculator', [AgricultureLicenseFeeCollectionController::class, 'fetchFeeCalculator'])->name('agriculture.license.fee.calculator');
Route::get('agriculture-license-form/{id}', [AgricultureLicenseFeeCollectionController::class, 'feeCollectForm'])->name('agriculture.license.fees.form');

/******************Agriculture Balam**************/
Route::get('agriculture-balam', [AgricultureController::class, 'show'])->name('agriculture-balam.create');

/******************Agriculture Fee**************/
Route::get('agriculture-fee', [AgricultureLicenseFeeCollectionController::class, 'create'])->name('agriculture-fee.create');

/******************Commercial license**************/
Route::resource('commercial', CommercialLicenseController::class);
Route::get('/license/owner/delete/{id}', [CommercialLicenseController::class, 'licenseOwnerDelete'])->name('license_owner.delete');
Route::post('/commercial/mouja/delete/{id}', [CommercialLicenseController::class, 'licenseMoujaDelete'])->name('commercial_mouja.delete');
Route::post('/commercial-license/status/', [CommercialLicenseController::class, 'licenseStatus'])->name('commercial_license.status');

/******************Agency license**************/
Route::resource('agency', AgencyLicenseController::class);
Route::post('agency/division/delete/{id}', [AgencyLicenseController::class, 'divisionDelete'])->name('agency.division.delete');

/******************Agency license Fee Collection**************/
Route::resource('agency-license-fees', AgencyLicenseFeeCollectionController::class);
Route::get('agency-license-form/{id}', [AgencyLicenseFeeCollectionController::class, 'feeCollectForm'])->name('agency.license.fees.form');
Route::delete('agency-license-fees/{id}', [AgencyLicenseFeeCollectionController::class, 'destroy'])->name('agency.license.fees.destroy');
Route::get('agency-license-details', [AgencyLicenseFeeCollectionController::class, 'fetchFeeDetails'])->name('agency.license.fee.details');
Route::get('agency-fee-calculator', [AgencyLicenseFeeCollectionController::class, 'fetchFeeCalculator'])->name('agency.license.fee.calculator');


/****************** Commercial Fee**************/
Route::resource('commercial-fees', CommercialFeeCollectionController::class);
Route::get('commercial-license-form/{id}', [CommercialFeeCollectionController::class, 'feeCollectForm'])->name('commercial.license.fees.form');
Route::delete('commercial-license-fees/{id}', [CommercialFeeCollectionController::class, 'destroy'])->name('commercial.license.fees.destroy');
Route::get('commercial-fee-details', [CommercialFeeCollectionController::class, 'fetchFeeDetails'])->name('commercial.license.fee.details');
Route::get('commercial-fee-calculator', [CommercialFeeCollectionController::class, 'fetchFeeCalculator'])->name('commercial.license.fee.calculator');


/******************Master Plan**************/
Route::resource('masterplan', MasterPlanController::class);
Route::delete('masterplan/mouja/{id}', [MasterPlanController::class, 'moujaRemove'])->name('masterplan.mouja.destroy');

/******************Master Plan plot**************/
Route::resource('masterplan-plot', MasterPlanPlotController::class);
Route::get('masterplan-plot/create/{id}', [MasterPlanPlotController::class, 'masterPlanPlotCreate'])->name('masterplan.plot.create');


/****************** Pond License **************/
Route::resource('pond-license', PondController::class);
Route::post('/license/owner/delete/{id}', [PondController::class, 'licenseOwnerDelete'])->name('license_owner.delete');
Route::post('/license/mouja/delete/{id}', [PondController::class, 'licenseMoujaDelete'])->name('pond_mouja.delete');


/****************** Pond License Fee**************/
Route::resource('pond-license-fees', PondLicenseFeeController::class);
Route::delete('pond-license-fees/{id}', [PondLicenseFeeController::class, 'destroy'])->name('pond.license.fees.destroy');
Route::get('pond-fee-details', [PondLicenseFeeController::class, 'fetchFeeDetails'])->name('pond.license.fee.details');
Route::post('/license/owner/delete/{id}', [PondController::class, 'licenseOwnerDelete'])->name('license_owner.delete');
Route::get('pond-fee-calculator', [PondLicenseFeeController::class, 'fetchFeeCalculator'])->name('pond.license.fee.calculator');
Route::get('pond-license-form/{id}', [PondLicenseFeeController::class, 'feeCollectForm'])->name('pond.license.fees.form');


/******************Commercial tender**************/
Route::resource('commercial-tender', CommercialTenderController::class);
Route::post('tender-plot-length', [CommercialTenderController::class, 'plotLengthWidth'])->name('tender.plot');
Route::post('/commercial-tender/create/{slug}', [CommercialTenderController::class, 'stepper'])->name('commercial-tender.stepper');

/****************** case**************/
Route::resource('case', CaseController::class);
Route::resource('case-date', CaseDateController::class);

Route::post('case/division/delete/{id}', [CaseController::class, 'divisionDelete'])->name('case.division.delete');
Route::get('case-date/create/{id}', [CaseDateController::class, 'dateCreate'])->name('case-date.create');

Route::get('case-date/create/{id}', [CaseDateController::class, 'dateCreate'])->name('case-date.create');


/***************** Inventory**************/
Route::resource('inventory', InventoryController::class);

/***************** Invoice generate**************/
Route::get('/invoice/{type}/{id}', [InvoiceGenerateController::class, 'show'])->name('invoice.show');
Route::get('invoice/single/{type}/{id}', [InvoiceGenerateController::class, 'clintCopy'])->name('invoice.client.copy');

/********************** Ekpay Payment api**/
Route::resource('payment', PaymentController::class);

/************* Designation ************/
Route::resource('designation', DesignationController::class);
