<?php

use App\Http\Controllers\Frontend\CommercialTenderController;
use App\Http\Controllers\Frontend\TermsController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\TenderApplyController;
use App\Http\Controllers\InvoiceGenerateController;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */

Route::get('/', [HomeController::class, 'index'])
    ->name('index')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('frontend.index'));
    });

Route::get('terms', [TermsController::class, 'index'])
    ->name('pages.terms')
    ->breadcrumbs(function (Trail $trail) {
        $trail->parent('frontend.index')
            ->push(__('Terms & Conditions'), route('frontend.pages.terms'));
    });

Route::get('/tender-details/{id}', [PageController::class, 'tenderDetails'])->name("tender.details");
Route::post('tender-plot-length', [TenderApplyController::class, 'plotLengthWidth'])->name('tender.plot');
Route::post('tender-applied', [TenderApplyController::class, 'store'])->name('tender.applied');
Route::post('/tender-application/stepper', [TenderApplyController::class, 'stepperForm'])->name('tender-applied.stepper');
Route::get('commercial-tender-invoice', [TenderApplyController::class, 'invoice'])->name('tender.invoice');

Route::get('tender/applying-form/{id}', [TenderApplyController::class, 'applyingForm'])->name("tender.applying-form");
Route::resource('commercial-tender', CommercialTenderController::class);
Route::get('invoice/single/{type}/{id}', [InvoiceGenerateController::class, 'clintCopy'])->name('invoice.client.copy');
