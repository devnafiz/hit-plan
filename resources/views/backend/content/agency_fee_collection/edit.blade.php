@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('লাইসেন্স ফি আদায় ফরম'))

@php
$required = html()
    ->span(' *')
    ->class('text-danger');
@endphp

@section('content')

    <x-backend.card>
        <x-slot name="header">
            @lang('সংস্থা লাইসেন্স ফি আদায় ফরম')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :text="__('Cancel')" />
        </x-slot>

        <x-slot name="body">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif

            <div class="alert alert-danger my-js-alert">

            </div>
            {{ html()->form('PUT', route('admin.agency-license-fees.update', $id))->id('ownerForm')->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}
            <input type="hidden" id="license_fee_route" value="{{ route('admin.commercial.license.fee.details') }}" />
            <input type="hidden" id="license_fee_calculator" value="{{ route('admin.commercial.license.fee.calculator') }}" />
            <input type="hidden" id="license_owner_id" name="license_owner_id" value="{{ $balam->owner_id }}" />
            <input type="hidden" id="license_number" class="form-control" maxlength="11" name="license_number"
                placeholder="লাইসেন্স নং" value="{{ $balam->license_no }}" />

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="col-md-12 bg-light text-justify mb-3">
                        <label class="mt-1">লাইসেন্স সংক্রান্ত তথ্য</h6>
                    </div>
                    <div class="">
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <div class="card">
                                    <div class="card-body" id="license_owner_info">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                @foreach ($license->agencyOwner as $owner)
                                                    <h5>লাইসেন্সীর তথ্য</h5>
                                                    <div class="mb-3">
                                                        <table class="text-center table-striped license_details_table">
                                                            <tbody>
                                                                
                                                                <tr>
                                                                    <th>লাইসেন্সের নং</th>
                                                                    <td>{{ $balam->license_no }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <th>লাইসেন্সীর নাম</th>
                                                                    <td>{{ $owner->name ?? 'N/A' }}</td>
                                                                </tr>

                                                               

                                                                <tr>
                                                                    <th>মোবাইল নং</th>
                                                                    <td>{{ $owner->phone ?? 'N/A' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>ঠিকানা</th>
                                                                    <td>{{ $owner->address ?? 'N/A' }}</td>
                                                                </tr>
  
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endforeach
                                                <div class="table-responsive-sm">
                                                    <table class="table table-striped table-bordered">
                                                    <?php $license_moujas = agency_license_moujas($license->agencyMoujas); ?>
                                                        <tr>
                                                            <th>কাচারী</th>
                                                            <td>{{ $license_moujas['kacharis'] ?? 'N/A' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>জেলা</th>
                                                            <td>{{ $license_moujas['districts'] ?? 'N/A' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>উপজেলা</th>
                                                            <td>{{ $license_moujas['upazilas'] ?? 'N/A' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>স্টেশন</th>
                                                            <td>
                                                            {{ $license_moujas['stations'] ?? 'N/A' }} 
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>

                                            </div>
                                            <div class="col-md-8 col-sm-12 col-lg-8">
                                                    <div class="table-responsive-sm">
                                                        <table class="table table-striped table-bordered">
                                                            <tr>
                                                                <th>জমির তফসিল</th>
                                                                <?php $license_moujas = agency_license_moujas($license->agencyMoujas); ?>
                                                                <td>
                                                                    <strong>মৌজা: </strong>{{ $license_moujas['moujas'] ?? 'N/A' }},
                                                                    <strong>খতিয়ান নং: </strong>{{ $license_moujas['ledgers'] ?? 'N/A' }},
                                                                    <strong>রেকর্ড: </strong>{{ $license_moujas['records'] ?? 'N/A' }},
                                                                    
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>লীজকৃত জমির পরিমাণ</th>
                                                                <td>{{ $license_moujas['property_amount'] . ' বর্গফুট' ?? 'N/A' }}</td>
                                                            </tr>
                                                        
                                                            <tr>
                                                                <th>ডিমান্ড নোটিশ নং  এবং নোটিশের তারিখ</th>
                                                                <td>{{ $license->demand_notice_number ?? 'N/A' }}</td>
                                                            </tr>
                                                            

                                                            <tr>
                                                                <th>নকশা নং  এবং নকশার তারিখ</th>
                                                                <td>{{ $license->design_and_date ?? 'N/A' }}</td>
                                                            </tr>

                                                        

                                                            <tr>
                                                                <th>লাইসেন্স অনুমোদনের কপি</th>
                                                                <td>
                                                                    @if ($license->land_map_certificate &&
                                                                    file_exists(public_path('uploads/agency/' . $license->land_map_certificate)))
                                                                    <a href="{{ asset('uploads/agency/' . $license->land_map_certificate) }}" download>
                                                                        <span class="badge badge-primary">Download</span>
                                                                    </a>
                                                                    @else
                                                                    <h6><span class="badge badge-danger">no file</span></h6>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- table section -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @php
                            $last_from_day = null;
                            $last_from_month = null;
                            $last_from_year = null;
                            $last_to_day = null;
                            $last_to_month = null;
                            $last_to_year = null;
                            $balam_id = null;
                            
                            if ($last_payment_date) {
                                $balam_id = $last_payment_date['balam_id'];
                                if (array_key_exists('from_date', $last_payment_date) && $last_payment_date['from_date']) {
                                    $last_from_day = $last_payment_date['from_date']['day'] ?? null;
                                    $last_from_month = $last_payment_date['from_date']['month'] ?? null;
                                    $last_from_year = $last_payment_date['from_date']['year'] ?? null;
                                }
                                if (array_key_exists('to_date', $last_payment_date) && $last_payment_date['to_date']) {
                                    $last_to_day = $last_payment_date['to_date']['day'] ?? null;
                                    $last_to_month = $last_payment_date['to_date']['month'] ?? null;
                                    $last_to_year = $last_payment_date['to_date']['year'] ?? null;
                                }
                            }
                            
                        @endphp
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <div class="row">
                                                    <div class="col-md-2 text-right">
                                                        <div class="form-group">
                                                            <label for="demand_notice_number">হতে:</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <input type="hidden" id="type" value="1">
                                                        <select class="form-control" name="from_date[license_fee_from_dd]"
                                                            id="license_fee_from_dd">
                                                            <option value="">তারিখ</option>
                                                            @for ($i = 1; $i <= 31; $i++)
                                                                <option value="{{ $i }}"
                                                                    @if ($last_from_day == $i) selected @endif>
                                                                    {{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                        @if ($errors->has('license_fee_from_dd'))
                                                            <p class="text-danger">
                                                                <small>{{ $errors->first('license_fee_from_dd') }}</small>
                                                            </p>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-3">
                                                        <input type="hidden" id="type" value="1">
                                                        <select class="form-control" name="from_date[license_fee_from_mm]"
                                                            id="license_fee_from_mm">
                                                            <option value="">মাস</option>
                                                            @for ($i = 1; $i <= 12; $i++)
                                                                <option value="{{ $i }}"
                                                                    @if ($last_from_month == $i) selected @endif>
                                                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                                            @endfor
                                                        </select>
                                                        @if ($errors->has('license_fee_from_mm'))
                                                            <p class="text-danger">
                                                                <small>{{ $errors->first('license_fee_from_mm') }}</small>
                                                            </p>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-4">
                                                        <input type="hidden" id="type" value="1">
                                                        <select class="form-control" name="from_date[license_fee_from_yy]"
                                                            id="license_fee_from_yy">
                                                            <option value="">বঙ্গাব্দ</option>
                                                            @for ($i = date('Y'); $i >= 1893; $i--)
                                                                <option value="{{ $i }}"
                                                                    @if ($last_from_year == $i) selected @endif>
                                                                    {{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                        @if ($errors->has('license_fee_from_yy'))
                                                            <p class="text-danger">
                                                                <small>{{ $errors->first('license_fee_from_yy') }}</small>
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </tr>
                                            <tr>
                                                <div class="row">
                                                    <div class="col-md-2 text-right">
                                                        <div class="form-group">
                                                            <label for="demand_notice_date">পর্যন্ত:</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select class="form-control" name="to_date[license_fee_to_dd]"
                                                            id="license_fee_to_mm">
                                                            <option value="">তারিখ</option>
                                                            @for ($i = 1; $i <= 31; $i++)
                                                                <option value="{{ $i }}"
                                                                    @if ($last_to_day == $i) selected @endif>
                                                                    {{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                        @if ($errors->has('license_fee_to_mm'))
                                                            <p class="text-danger">
                                                                <small>{{ $errors->first('license_fee_to_mm') }}</small>
                                                            </p>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-3">
                                                        <select class="form-control" name="to_date[license_fee_to_mm]"
                                                            id="license_fee_to_mm">
                                                            <option value="">মাস</option>
                                                            @for ($i = 1; $i <= 12; $i++)
                                                                <option value="{{ $i }}"
                                                                    @if ($last_to_month == $i) selected @endif>
                                                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                                            @endfor
                                                        </select>
                                                        @if ($errors->has('license_fee_to_mm'))
                                                            <p class="text-danger">
                                                                <small>{{ $errors->first('license_fee_to_mm') }}</small>
                                                            </p>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-4">
                                                        <select class="form-control" name="to_date[license_fee_to_yy]"
                                                            id="license_fee_to_yy">
                                                            <option value="">বসর</option>
                                                            @for ($i = date('Y', strtotime('+5 years')); $i >= 1893; $i--)
                                                                <option value="{{ $i }}"
                                                                    @if ($last_to_year == $i) selected @endif>
                                                                    {{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                        @if ($errors->has('license_fee_to_yy'))
                                                            <p class="text-danger">
                                                                <small>{{ $errors->first('license_fee_to_yy') }}</small>
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mt-4 mb-3 card">
                                <div class="row card-body">
                                    <h5>বিভিন্ন ফি’র তথ্য</h5>
                                    <div class="col-md-12">
                                        <table class="license_details_table_2">
                                            <tbody>
                                                <tr>
                                                    <th>
                                                        <label for="license_fee">লাইসেন্স ফি</label>
                                                    </th>
                                                    <td>
                                                        <input type="text" class="form-control" name="license_fee"
                                                            maxlength="11" id="license_fee" placeholder="লাইসেন্স ফি"
                                                            value="{{ $balam->license_fee ?? '' }}" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        <label for="license_vat">ভ্যাট</label>
                                                    </th>
                                                    <td>
                                                        <input type="text" class="form-control" name="license_vat"
                                                            id="license_vat" placeholder="ভ্যাট" maxlength="11"
                                                            value="{{ $balam->vat ?? '' }}" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        <label for="license_tax">উৎসে কর</label>
                                                    </th>
                                                    <td>
                                                        <input type="text" class="form-control" name="license_tax"
                                                            maxlength="11" id="license_tax" placeholder="উৎসে কর"
                                                            value="{{ $balam->tax ?? '' }}" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        <label for="license_fines">জরিমানা</label>
                                                    </th>
                                                    <td>
                                                        <input type="text" class="agri-fee-calculator form-control"
                                                            data-key="fines" name="license_fines" id="license_fines"
                                                            placeholder="জরিমানা" maxlength="11"
                                                            value="{{ $balam->fine ?? '' }}" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        <label for="license_security">লাইসেন্সের সিকিউরিটি</label>
                                                    </th>
                                                    <td>
                                                        <input type="text" class="agri-fee-calculator form-control"
                                                            data-key="security" name="license_security" maxlength="11"
                                                            id="license_security" placeholder="লাইসেন্সের সিকিউরিটি"
                                                            value="{{ $balam->security ?? '' }}" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        <label for="license_plan_fee">লাইসেন্সের প্ল্যান ফি</label>
                                                    </th>
                                                    <td>
                                                        <input type="text" class="agri-fee-calculator form-control"
                                                            data-key="plan_fee" name="license_plan_fee"
                                                            id="license_plan_fee" placeholder="লাইসেন্সের প্ল্যান ফি"
                                                            maxlength="11" value="{{ $balam->plan_fee ?? '' }}" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        <label for="license_application_fee">লাইসেন্সের আবেদন ফি</label>
                                                    </th>
                                                    <td>
                                                        <input type="text" class="agri-fee-calculator form-control"
                                                            data-key="application_fee" name="license_application_fee"
                                                            maxlength="11" id="license_application_fee"
                                                            placeholder="লাইসেন্সের আবেদন ফি"
                                                            value="{{ $balam->application_fee ?? '' }}" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        <label for="license_renew_fee">লাইসেন্সের নবায়ন ফি</label>
                                                    </th>
                                                    <td>
                                                        <input type="text" class="agri-fee-calculator form-control"
                                                            data-key="renew_fee" name="license_renew_fee"
                                                            id="license_renew_fee" placeholder="লাইসেন্সের নবায়ন ফি"
                                                            maxlength="11" value="{{ $balam->mutation_fee ?? '' }}" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        <label for="license_naming_fee">লাইসেন্সের নামজারী ফি</label>
                                                    </th>
                                                    <td>
                                                        <input type="text" class="agri-fee-calculator form-control"
                                                            data-key="naming_fee" name="license_naming_fee"
                                                            id="license_naming_fee" placeholder="লাইসেন্সের নামজারী ফি"
                                                            maxlength="11" value="{{ $balam->naming ?? '' }}" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        <label for="license_total_amount"><strong>মোট</strong></label>
                                                    </th>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            id="license_total_amount" name="license_total_amount" 
                                                            placeholder="মোট" maxlength="11"
                                                            value="{{ $balam->total_fee ?? '' }}" />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6 col-sm-12 mt-4 mb-3 card">
                                <div class="row card-body">
                                    <h5>‘এ চালান’ সংক্রান্ত তথ্য</h5>
                                    <div class="col-md-12">
                                        <div id="dd_form_repeater">
                                            @forelse ($balam->dd as $key => $dd)
                                                <hr class="remove_{{ $key }}">
                                                <table
                                                    class="dd_repeater_item license_details_table_2 remove_{{ $key }}"
                                                    data-key="{{ $key }}">
                                                    <tbody>
                                                        @if (count($balam->dd) - 1 == $key)
                                                            <!-- <tr>
                                                                <th colspan="2">
                                                                    <button type="button"
                                                                        class="repeater-button-dd repeater_adding_button"
                                                                        title="Add New DD Form"
                                                                        data-key="{{ $key }}">
                                                                        <i class="fas fa-plus"></i>
                                                                    </button>
                                                                </th>
                                                            </tr> -->
                                                        @else
                                                            <tr>
                                                                <th colspan="2">
                                                                    <button type="button"
                                                                        class="repeater-button-dd repeater_deleting_button"
                                                                        title="Remove New DD Form"
                                                                        data-key="{{ $key }}">
                                                                        <i class="fas fa-minus"></i>
                                                                    </button>
                                                                </th>
                                                            </tr>
                                                        @endif
                                                        <tr>
                                                            <th><label
                                                                    for="license_fee_ddn_no_{{ $key }}">লাইসেন্স
                                                                    ফি'র ‘এ চালান’ নং</label>
                                                            </th>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    id="license_fee_ddn_no_{{ $key }}"
                                                                    placeholder="লাইসেন্স ফি'র ‘এ চালান’ নং"
                                                                    name="license_fee_dd[dd_no][{{ $key }}]"
                                                                    maxlength="11" value="{{ $dd->dd_no ?? '' }}" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th><label for="license_vat_dd_no_{{ $key }}">ভাটের
                                                                    ‘এ চালান’ নং</label></th>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    id="license_vat_dd_no_{{ $key }}"
                                                                    placeholder="ভাটের ‘এ চালান’ নং"
                                                                    name="license_fee_dd[vat_no][{{ $key }}]"
                                                                    maxlength="11" value="{{ $dd->dd_vat ?? '' }}" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th><label
                                                                    for="license_tax_dd_no_{{ $key }}">ট্যাক্সের
                                                                    ডিডি নং</label></th>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    id="license_tax_dd_no_{{ $key }}"
                                                                    placeholder="ট্যাক্সের ডিডি নং"
                                                                    name="license_fee_dd[tax_no][{{ $key }}]"
                                                                    value="{{ $dd->dd_tax ?? '' }}" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th><label for="license_bank_name_{{ $key }}">ব্যাংক
                                                                    ও শাখার নাম </label></th>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    name="license_fee_dd[bank_name][{{ $key }}]"
                                                                    id="license_bank_name_{{ $key }}"
                                                                    placeholder="ব্যাংক ও শাখার নাম "
                                                                    value="{{ $dd->bank_name ?? '' }}" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th><label for="license_dd_date_{{ $key }}">‘এ চালান’
                                                                    এর তারিখ </label></th>
                                                            <td>
                                                                <input type="date" class="form-control"
                                                                    name="license_fee_dd[dd_date][{{ $key }}]"
                                                                    id="license_dd_date_{{ $key }}"
                                                                    format="mm/dd/yyyy" placeholder="‘এ চালান’ এর তারিখ "
                                                                    value="{{ date('Y-m-d', strtotime($dd->dd_date)) ?? '' }}" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th><label
                                                                    for="license_dd_total_amount_{{ $key }}">মোট
                                                                    টাকা </label></th>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="license_fee_dd[total_amount][{{ $key }}]"
                                                                    id="license_dd_total_amount_{{ $key }}"
                                                                    placeholder="মোট টাকা"
                                                                    value="{{ $dd->total ?? '' }}" />
                                                            </td>
                                                        </tr>

                                                        <!-- <tr>
                                                            <th><label
                                                                    for="license_dd_j1_slip_date_{{ $key }}">ফি
                                                                    আদায়ের তারিখ</label>
                                                            </th>
                                                            <td>
                                                                <input type="date" class="form-control"
                                                                    name="license_fee_dd[j1_slip_date][{{ $key }}]"
                                                                    id="license_dd_j1_slip_date_{{ $key }}"
                                                                    placeholder="ফি আদায়ের তারিখ"
                                                                    value="{{ date('Y-m-d', strtotime($dd->j1_date)) ?? '' }}" />
                                                            </td>
                                                        </tr> -->
                                                    </tbody>
                                                </table>
                                            @empty
                                                <table class="dd_repeater_item license_details_table_2" data-key="0">
                                                    <tbody>
                                                        <tr>
                                                            <th colspan="2">
                                                                <button type="button"
                                                                    class="repeater-button-dd repeater_adding_button"
                                                                    title="Add New DD Form">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th><label for="license_fee_ddn_no_0">লাইসেন্স ফি'র ‘এ চালান’
                                                                    নং</label>
                                                            </th>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    id="license_fee_ddn_no_0"
                                                                    placeholder="লাইসেন্স ফি'র ‘এ চালান’ নং"
                                                                    name="license_fee_dd[dd_no][0]" maxlength="20" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th><label for="license_vat_dd_no_0">ভাটের ‘এ চালান’ নং</label>
                                                            </th>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    id="license_vat_dd_no_0"
                                                                    placeholder="ভাটের ‘এ চালান’ নং"
                                                                    name="license_fee_dd[vat_no][0]" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th><label for="license_tax_dd_no_0">ট্যাক্সের ডিডি নং</label>
                                                            </th>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    id="license_tax_dd_no_0"
                                                                    placeholder="ট্যাক্সের ডিডি নং"
                                                                    name="license_fee_dd[tax_no][0]" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th><label for="license_bank_name_0">ব্যাংক ও শাখার নাম
                                                                </label>
                                                            </th>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    name="license_fee_dd[bank_name][0]"
                                                                    id="license_bank_name_0"
                                                                    placeholder="ব্যাংক ও শাখার নাম " />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th><label for="license_dd_date_0">‘এ চালান’ এর তারিখ </label>
                                                            </th>
                                                            <td>
                                                                <input type="date" class="form-control"
                                                                    name="license_fee_dd[dd_date][0]"
                                                                    id="license_dd_date_0" format="mm/dd/yyyy"
                                                                    placeholder="‘এ চালান’ এর তারিখ " />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th><label for="license_dd_total_amount_0">মোট টাকা </label>
                                                            </th>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="license_fee_dd[total_amount][0]"
                                                                    id="license_dd_total_amount_0"
                                                                    placeholder="মোট টাকা" />
                                                            </td>
                                                        </tr>
                                                        <!-- <tr>
                                                            <th><label for="license_dd_j1_slip_date_0">ফি আদায়ের
                                                                    তারিখ</label>
                                                            </th>
                                                            <td>
                                                                <input type="date" class="form-control"
                                                                    name="license_fee_dd[j1_slip_date][0]"
                                                                    id="license_dd_j1_slip_date_0"
                                                                    placeholder="ফি আদায়ের তারিখ" />
                                                            </td>
                                                        </tr> -->
                                                    </tbody>
                                                </table>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-lg btn-dark float-right">পরিবর্তন করুন</button>
                </div>
            </div>

            {{ html()->form()->close() }}
        </x-slot>

    </x-backend.card>


@endsection

@push('after-styles')
    {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"> --}}
@endpush

@push('after-scripts')
    {{-- <script type="text/javascript">

    </script> --}}
@endpush
