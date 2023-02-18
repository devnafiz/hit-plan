@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('লাইসেন্স ফি সংশোধন'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('কৃষি লাইসেন্স ফি সংশোধন')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header class="btn btn-sm btn-tool btn-info" icon="fas fa-backspace" :href="route('admin.agriculture.show', $balam->agriLicense->id)" :text="__('Back to License page')" />
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
        {{ html()->form('PUT', route('admin.agri-license-fees.update', $id))->id('ownerForm')->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}
        <input type="hidden" id="license_fee_route" value="{{ route('admin.agriculture.license.fee.details') }}" />
        <input type="hidden" id="license_fee_calculator" value="{{ route('admin.agriculture.license.fee.calculator') }}" />
        <input type="hidden" id="license_owner_id" name="license_owner_id" value="{{ $balam->owner_id }}" />
        <input type="hidden" id="license_number" class="form-control" maxlength="11" name="license_number" placeholder="লাইসেন্স নং" value="{{ $balam->license_no }}" />

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
                                        <div class="col-md-6 col-sm-12">
                                            @foreach ($balam->agriLicense->agriOwner as $owner)
                                            <h5>লাইসেন্সীর তথ্য</h5>
                                            <div class="mb-3">
                                                <table class="table table-striped table-bordered">
                                                    <tr>
                                                        <th>লাইসেন্সীর ছবি</th>
                                                        <td><img src="{{ $owner->photo ? asset('uploads/owners/' . $owner->photo) : asset('images/no-file.png') }}" alt="img" style="max-width: 80px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>লাইসেন্স নং</th>
                                                        <td class="text-bold">
                                                            {{ $balam->generated_id ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>লাইসেন্সর ধরন</th>
                                                        <td class="text-bold">জলাশয় লাইসেন্স</td>
                                                    </tr>
                                                    <tr>
                                                        <th>লাইসেন্সীর নাম</th>
                                                        <td>{{ $owner->name ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        @if ($owner->father_name)
                                                        <th>পিতার নাম</th>
                                                        <td>{{ $owner->father_name ?? 'N/A' }}</td>
                                                        @endif
                                                        @if ($owner->husband_name)
                                                        <th>স্বামীর নাম</th>
                                                        <td>{{ $owner->husband_name ?? 'N/A' }}</td>
                                                        @endif

                                                    </tr>
                                                    <tr>
                                                        <th>জাতীয় পরিচয়পত্র নং</th>
                                                        <td>{{ $owner->nid ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>মোবাইল নং</th>
                                                        <td>{{ $owner->phone ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>ঠিকানা</th>
                                                        <td>{{ $owner->address ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>কাচারী</th>
                                                        <td>{{ $balam->agriLicense->kachari->kachari_name ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>জেলা</th>
                                                        <td>{{ $balam->agriLicense->district->district_name ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>উপজেলা</th>
                                                        <td>{{ $balam->agriLicense->upazila->upazila_name ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>স্টেশন</th>
                                                        <td>
                                                            {{ $balam->agriLicense->station->station_name ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <h5>লাইসেন্স ফি’র তথ্য</h5>
                                            <div class="table-responsive-sm table-striped">
                                                <table class="table table-striped table-bordered">
                                                    <tr>
                                                        <th>জমির তফসিল</th>
                                                        <td>
                                                            <?php $license_moujas = license_moujas($balam->agriLicense->agriMoujas); ?>
                                                            <strong>মৌজা:
                                                            </strong>{{ $license_moujas['moujas'] ?? 'N/A' }}
                                                            <strong>খতিয়ান নং:
                                                            </strong>{{ $license_moujas['ledgers'] ?? 'N/A' }}
                                                            <strong>রেকর্ড:
                                                            </strong>{{ $license_moujas['records'] ?? 'N/A' }}
                                                            <strong>দাগ:
                                                            </strong>{{ $license_moujas['plots'] ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>জমির পরিমাণ</th>
                                                        <td>{{ $license_moujas['property_amount'] . ' একর' ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>লাইসেন্সকৃত জমির পরিমান</th>
                                                        <td>{{ $license_moujas['leased_area'] . ' বর্গফুট' ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>ডিমান্ড নোটিশ নং</th>
                                                        <td>{{ $balam->agriLicense->demand_notice_number ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>ডিমান্ড নোটিশের তারিখ</th>
                                                        <td>{{ date('F j, Y', strtotime($balam->agriLicense->demand_notice_date)) ?? 'N/A' }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>নকশা নং</th>
                                                        <td>{{ $balam->agriLicense->land_map_number ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>নকশার তারিখ</th>
                                                        <td>{{ $balam->agriLicense->land_map_date ? date('F j, Y', strtotime($balam->agriLicense->land_map_date)) : 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>চৌহদ্দি উত্তর</th>
                                                        <td>{{ $balam->agriLicense->land_map_north ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>পূর্ব</th>
                                                        <td>{{ $balam->agriLicense->land_map_east ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>দক্ষিণ</th>
                                                        <td>{{ $balam->agriLicense->land_map_south ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>কি.মি.</th>
                                                        <td>{{ $balam->agriLicense->land_map_kilo ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>পশ্চিম</th>
                                                        <td>{{ $balam->agriLicense->land_map_west ?? 'N/A' }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>লাইসেন্স অনুমোদনের কপি</th>
                                                        <td>
                                                            @if ($balam->agriLicense->land_map_certificate &&
                                                            file_exists(public_path($balam->agriLicense->land_map_certificate)))
                                                            <a href="{{ $balam->agriLicense->land_map_certificate }}" download>Download</a>
                                                            @else
                                                            <h6><span class="badge badge-danger">no file</span></h6>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
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
                                    <input type="hidden" name="balam_id" value="{{ $balam_id }}">
                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                <label for="demand_notice_number">হতে:</label>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="hidden" id="type" value="1">
                                                <select class="form-control" name="from_date[license_fee_from_dd]" id="license_fee_from_dd">
                                                    <option value="">তারিখ</option>
                                                    @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}" @if ($last_from_day==$i) selected @endif>
                                                        {{ bangla_number($i) }}
                                                        </option>
                                                        @endfor
                                                </select>
                                            </div>
                                            @if ($errors->has('license_fee_from_dd'))
                                            <p class="text-danger">
                                                <small>{{ $errors->first('license_fee_from_dd') }}</small>
                                            </p>
                                            @endif
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="hidden" id="type" value="1">
                                                <select class="form-control" name="from_date[license_fee_from_mm]" id="license_fee_from_mm">
                                                    <option value="">মাস</option>
                                                    @foreach ($bn_months as $key => $month)
                                                    <option value="{{ $key + 1 }}" @if ($last_from_month==$key + 1) selected @endif>
                                                        {{ $month }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->has('license_fee_from_mm'))
                                            <p class="text-danger">
                                                <small>{{ $errors->first('license_fee_from_mm') }}</small>
                                            </p>
                                            @endif
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="hidden" id="type" value="1">
                                                <select class="form-control" name="from_date[license_fee_from_yy]" id="license_fee_from_yy">
                                                    <option value="">বঙ্গাব্দ</option>
                                                    @for ($i = date('Y', strtotime('+5 years')); $i >= 1893; $i--)
                                                    <option value="{{ $i - 593 }}" @if ($last_from_year==$i - 593) selected @endif>
                                                        {{ bangla_number($i - 593) }}
                                                    </option>
                                                    @endfor
                                                </select>
                                            </div>
                                            @if ($errors->has('license_fee_from_yy'))
                                            <p class="text-danger">
                                                <small>{{ $errors->first('license_fee_from_yy') }}</small>
                                            </p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                <label for="demand_notice_date">পর্যন্ত:</label>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select class="form-control" name="to_date[license_fee_to_dd]" id="license_fee_to_dd">
                                                    <option value="">তারিখ</option>
                                                    @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}" @if ($last_to_day==$i) selected @endif>
                                                        {{ bangla_number($i) }}
                                                        </option>
                                                        @endfor
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select class="form-control" name="to_date[license_fee_to_mm]" id="license_fee_to_mm">
                                                    <option value="">মাস</option>
                                                    @foreach ($bn_months as $key => $month)
                                                    <option value="{{ $key + 1 }}" @if ($last_to_month==$key + 1) selected @endif>
                                                        {{ $month }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select class="form-control" name="to_date[license_fee_to_yy]" id="license_fee_to">
                                                    <option value="">বঙ্গাব্দ</option>
                                                    @for ($i = date('Y', strtotime('+5 years')); $i >= 1893; $i--)
                                                    <option value="{{ $i - 593 }}" @if ($last_to_year==$i - 593) selected @endif>
                                                        {{ bangla_number($i - 593) }}
                                                    </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-3">
                                            <label class="btn btn-sm btn-outline-primary float-right date-submit">Submit</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5>হিসাবের উদাহরণ</h5>

                                    @php
                                    $total = $balam->agriLicense->agriMoujas->sum('leased_area');
                                    @endphp
                                    <p id="license_fee_calculated_data">
                                        জমির পরিমান: {{ $total }} বর্গফুট
                                        <br>
                                        মোট: {{ number_format($balam->license_fee, 2) }}/-
                                        <br>
                                        ভ্যাট: {{ number_format($balam->vat, 2) }}/-
                                        <br>
                                        ট্যাক্স: {{ number_format($balam->tax, 2) }}/-
                                        <br>
                                        জরিমানা: {{ number_format($balam->fine) }}/-
                                        <br><br>
                                        মোট ফি: {{ number_format($balam->total_fee, 2) }}/-
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12 mt-4 mb-3 card">
                            <div class="row card-body">
                                <div class="col-md-12">
                                    <h5>বিভিন্ন ফি’র তথ্য</h5>
                                    <table class="license_details_table_2">
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <label for="license_fee">লাইসেন্স ফি</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="form-control license_fee-calculator" name="license_fee" maxlength="11" id="license_fee" placeholder="লাইসেন্স ফি" value="{{ $balam->license_fee ?? '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_vat">ভ্যাট</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="form-control license_fee-calculator" name="license_vat" data-key="license_vat" id="license_vat" placeholder="ভ্যাট" maxlength="11" value="{{ $balam->vat ?? '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_tax">উৎসে কর</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="form-control license_fee-calculator" name="license_tax" data-key="license_tax" maxlength="11" id="license_tax" placeholder="উৎসে কর" value="{{ $balam->tax ?? '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_fines">জরিমানা</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="license_fee-calculator form-control" data-key="fines" name="license_fines" id="license_fines" placeholder="জরিমানা" maxlength="11" value="{{ $balam->fine ?? '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_security">লাইসেন্সের সিকিউরিটি</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="license_fee-calculator form-control" data-key="security" name="license_security" maxlength="11" id="license_security" placeholder="লাইসেন্সের সিকিউরিটি" value="{{ $balam->security ?? '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_plan_fee">লাইসেন্সের প্ল্যান ফি</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="license_fee-calculator form-control" data-key="plan_fee" name="license_plan_fee" id="license_plan_fee" placeholder="লাইসেন্সের প্ল্যান ফি" maxlength="11" value="{{ $balam->plan_fee ?? '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_application_fee">লাইসেন্সের আবেদন ফি</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="license_fee-calculator form-control" data-key="application_fee" name="license_application_fee" maxlength="11" id="license_application_fee" placeholder="লাইসেন্সের আবেদন ফি" value="{{ $balam->application_fee ?? '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_renew_fee">লাইসেন্সের নবায়ন ফি</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="license_fee-calculator form-control" data-key="renew_fee" name="license_renew_fee" id="license_renew_fee" placeholder="লাইসেন্সের নবায়ন ফি" maxlength="11" value="{{ $balam->mutation_fee ?? '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_naming_fee">লাইসেন্সের নামজারী ফি</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="license_fee-calculator form-control" data-key="naming_fee" name="license_naming_fee" id="license_naming_fee" placeholder="লাইসেন্সের নামজারী ফি" maxlength="11" value="{{ $balam->naming ?? '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_total_amount"><strong>মোট</strong></label>
                                                </th>
                                                <td>
                                                    <input type="text" class="form-control" id="license_total_amount" name="license_total_amount" placeholder="মোট" maxlength="11" value="{{ $balam->total_fee ?? '' }}" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 mt-4 mb-3 card">
                            <div class="row card-body">
                                <div class="col-md-12">
                                    <h5>‘এ চালান’ সংক্রান্ত তথ্য</h5>
                                    <div id="dd_form_repeater">
                                        @forelse ($balam->dd as $key => $dd)
                                        <hr class="remove_{{ $key }}">
                                        <table class="dd_repeater_item license_details_table_2 remove_{{ $key }}" data-key="{{ $key }}">
                                            <tbody>
                                                @if (count($balam->dd) - 1 == $key)
                                                <tr>
                                                    <th colspan="2">
                                                        <button type="button" class="repeater-button-dd repeater_adding_button" title="Add New DD Form" data-key="{{ $key }}">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </th>
                                                </tr>
                                                @else
                                                <tr>
                                                    <th colspan="2">
                                                        <button type="button" class="repeater-button-dd repeater_deleting_button" title="Remove New DD Form" data-key="{{ $key }}">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </th>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <th><label for="license_fee_ddn_no_{{ $key }}">লাইসেন্স
                                                            ফি'র ‘এ চালান’ নং</label>
                                                    </th>
                                                    <td>
                                                        <input type="text" class="form-control" id="license_fee_ddn_no_{{ $key }}" placeholder="লাইসেন্স ফি'র ‘এ চালান’ নং" name="license_fee_dd[dd_no][{{ $key }}]" maxlength="11" value="{{ $dd->dd_no ?? '' }}" />
                                                    </td>
                                                    <input type="hidden" name="dd_id_{{ $key }}" value="{{ $dd->id }}">
                                                </tr>
                                                <tr>
                                                    <th><label for="license_vat_dd_no_{{ $key }}">ভাটের
                                                            ‘এ চালান’ নং</label></th>
                                                    <td>
                                                        <input type="text" class="form-control" id="license_vat_dd_no_{{ $key }}" placeholder="ভাটের ‘এ চালান’ নং" name="license_fee_dd[vat_no][{{ $key }}]" maxlength="11" value="{{ $dd->dd_vat ?? '' }}" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><label for="license_tax_dd_no_{{ $key }}">ট্যাক্সের
                                                            ডিডি নং</label></th>
                                                    <td>
                                                        <input type="text" class="form-control" id="license_tax_dd_no_{{ $key }}" placeholder="ট্যাক্সের ডিডি নং" name="license_fee_dd[tax_no][{{ $key }}]" value="{{ $dd->dd_tax ?? '' }}" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><label for="license_bank_name_{{ $key }}">ব্যাংক
                                                            ও শাখার নাম </label></th>
                                                    <td>
                                                        <input type="text" class="form-control" name="license_fee_dd[bank_name][{{ $key }}]" id="license_bank_name_{{ $key }}" placeholder="ব্যাংক ও শাখার নাম " value="{{ $dd->bank_name ?? '' }}" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><label for="license_dd_date_{{ $key }}">‘এ চালান’
                                                            এর তারিখ </label></th>
                                                    <td>
                                                        <input type="date" class="form-control" name="license_fee_dd[dd_date][{{ $key }}]" id="license_dd_date_{{ $key }}" format="mm/dd/yyyy" placeholder="‘এ চালান’ এর তারিখ " value="{{ $dd->dd_date ? date('Y-m-d', strtotime($dd->dd_date)) : '' }}" />
                                                    </td>
                                                </tr>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @if ($key == 0)
                                        <table class="license_details_table_2">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 48%; padding-left:160px;">
                                                        <label for="license_dd_total_amount_{{ $key }}">টাকার
                                                            পরিমাণ</label></th>
                                                    <td style="width: 52%;">
                                                        <input type="number" class="form-control" name="license_fee_dd[total][{{ $key }}]" value="{{ $dd->total }}" id="license_dd_total_amount_{{ $key }}" placeholder="টাকার পরিমাণ" />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @endif
                                        @empty
                                        <table class="dd_repeater_item license_details_table_2" data-key="0">
                                            <tbody>
                                                <tr>
                                                    <th colspan="2">
                                                        <button type="button" class="repeater-button-dd repeater_adding_button" title="Add New DD Form">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th><label for="license_fee_ddn_no_0">লাইসেন্স ফি'র ‘এ চালান’
                                                            নং</label>
                                                    </th>
                                                    <td>
                                                        <input type="text" class="form-control" id="license_fee_ddn_no_0" placeholder="লাইসেন্স ফি'র ‘এ চালান’ নং" name="license_fee_dd[dd_no][0]" maxlength="20" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><label for="license_vat_dd_no_0">ভাটের ‘এ চালান’ নং</label>
                                                    </th>
                                                    <td>
                                                        <input type="text" class="form-control" id="license_vat_dd_no_0" placeholder="ভাটের ‘এ চালান’ নং" name="license_fee_dd[vat_no][0]" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><label for="license_tax_dd_no_0">ট্যাক্সের ডিডি নং</label>
                                                    </th>
                                                    <td>
                                                        <input type="text" class="form-control" id="license_tax_dd_no_0" placeholder="ট্যাক্সের ডিডি নং" name="license_fee_dd[tax_no][0]" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><label for="license_bank_name_0">ব্যাংক ও শাখার নাম
                                                        </label>
                                                    </th>
                                                    <td>
                                                        <input type="text" class="form-control" name="license_fee_dd[bank_name][0]" id="license_bank_name_0" placeholder="ব্যাংক ও শাখার নাম " />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><label for="license_dd_date_0">‘এ চালান’ এর তারিখ </label>
                                                    </th>
                                                    <td>
                                                        <input type="date" class="form-control" name="license_fee_dd[dd_date][0]" id="license_dd_date_0" format="mm/dd/yyyy" placeholder="‘এ চালান’ এর তারিখ " />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="license_details_table_2">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 48%; padding-left:160px;">
                                                        <label for="license_dd_total_amount_0">টাকার পরিমাণ</label>
                                                        </th>
                                                    <td style="width: 52%;">
                                                        <input type="number" class="form-control" name="license_fee_dd[total][0]" id="license_dd_total_amount_0" placeholder="টাকার পরিমাণ" />
                                                    </td>
                                                </tr>
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