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
        @lang(' নতুন কৃষি লাইসেন্স ফি আদায় ফরম')
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
        {{ html()->form('PUT', route('admin.commercial-fees.update', $id))->id('ownerForm')->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}
        <input type="hidden" id="license_fee_route" value="{{ route('admin.commercial.license.fee.details') }}" />
        <input type="hidden" id="license_fee_calculator" value="{{ route('admin.commercial.license.fee.calculator') }}" />
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
                                            @foreach ($license->commercialOwner as $owner)
                                            <h5>লাইসেন্সীর তথ্য</h5>
                                            <div class="mb-3">
                                                <table class="text-center table-striped license_details_table">
                                                    <tbody>
                                                        <tr>
                                                            <th>লাইসেন্সীর ছবি</th>
                                                            <td>
                                                                @if (file_exists(asset($balam->commercialOwner->photo)))
                                                                <img src="{{ asset('uploads/owners' . $balam->commercialOwner->photo) }}" alt="img" style="max-width: 80px;">
                                                                @else
                                                                <img src="{{ asset('images/no-file.png') }}" alt="img" style="max-width: 80px;">
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>লাইসেন্সের নং</th>
                                                            <td>{{ $balam->license_no }}</td>
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
                                                            <th>মোবাইল নং</th>
                                                            <td>{{ $owner->phone ?? 'N/A' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>ঠিকানা</th>
                                                            <td>{{ $owner->address ?? 'N/A' }}</td>
                                                        </tr>

                                                        <tr>
                                                            <th>জাতীয় পরিচয়পত্র নং</th>
                                                            <td>{{ $owner->nid }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>কাচারী নং</th>
                                                            <td>{{ $balam->commercialLicense->kachari->kachari_name }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>জেলা</th>
                                                            <td>{{ $balam->commercialLicense->district->district_name }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>উপজেলা</th>
                                                            <td>{{ $balam->commercialLicense->upazila->upazila_name }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>স্টেশন</th>
                                                            <td>{{ $balam->commercialLicense->station->station_name }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            @endforeach

                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <h5>লাইসেন্স ফি’র তথ্য</h5>
                                            <div class="table-responsive-sm table-striped">
                                                <table class="text-center license_details_table">
                                                    <tbody>
                                                        <tr>
                                                            <th>জমির তফসিল</th>
                                                            <td>
                                                                <?php $license_moujas = commercial_license_moujas($license->commercialMoujas); ?>
                                                                <strong>মৌজা:
                                                                </strong>{{ $license_moujas['moujas'] ?? 'N/A' }}
                                                                <strong>খতিয়ান নং:
                                                                </strong>{{ $license_moujas['ledgers'] ?? 'N/A' }}
                                                                <strong>রেকর্ড:
                                                                </strong>{{ $license_moujas['records'] ?? 'N/A' }}
                                                                <strong>দাগ:
                                                                </strong>{{ $license_moujas['masterplan_plots'] ?? 'N/A' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>জমির পরিমাণ</th>
                                                            <td>{{ $license_moujas['property_amount'] . ' একর' ?? 'N/A'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>লীজকৃত জমির পরিমাণ</th>
                                                            <td>{{ $license_moujas['property_amount'] . ' বর্গফুট' ?? 'N/A'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>মাস্টারপ্ল্যান নং</th>
                                                            <td>{{ $license_moujas['masterplan_no'] ?? 'N/A' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>মাস্টারপ্ল্যানের প্লট নং</th>
                                                            <td>{{ $license_moujas['masterplan_plots'] ?? 'N/A' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>ডিমান্ড নোটিশ নং</th>
                                                            <td>{{ $license->demand_notice_number ?? 'N/A' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>ডিমান্ড নোটিশের তারিখ</th>
                                                            <td>{{ date('F j, Y', strtotime($license->demand_notice_date)) ?? 'N/A' }}</td>
                                                        </tr>

                                                        <tr>
                                                            <th>নকশা নং</th>
                                                            <td>{{ $license->land_map_number }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>নকশার তারিখ</th>
                                                            <td>{{ date('d M Y', strtotime($license->land_map_date)) }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>চৌহদ্দি</th>
                                                            <td>
                                                                উত্তর:
                                                                {{ $license->land_map_north }},
                                                                দক্ষিণ:
                                                                {{ $license->land_map_south }},
                                                                পূর্ব:
                                                                {{ $license->land_map_east }},
                                                                পশ্চিম:
                                                                {{ $license->land_map_west }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>কি.মি.</th>
                                                            <td>{{ $license->land_map_kilo }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>লাইসেন্স অনুমোদনের কপি</th>
                                                            <td>
                                                                @if (file_exists(asset('uploads/commercial/' . $license->land_map_certificate)))
                                                                <a href="{{ asset('uploads/commercial/' . $license->land_map_certificate) }}" download>
                                                                    <span class="badge badge-primary">Download</span>
                                                                </a>
                                                                @else
                                                                <h6><span class="badge badge-danger">no file</span>
                                                                </h6>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="200">সময়কাল হতে:</th>
                                            <td>
                                                @php
                                                $from_date = explode('-', $balam->license_date)[0];
                                                $to_date = explode('-', $balam->license_date)[1];
                                                @endphp
                                                <select class="max_width_350 form-control" name="license_fee_from" id="license_fee_from">
                                                    <option value="">সময়কাল নির্ধারণ করুন</option>
                                                    @for ($i = date('Y'); $i >= 1893; $i--)
                                                    <option value="{{ $i }}" {{ $i == $from_date ? 'selected' : '' }}>1st July
                                                        {{ $i }}
                                                    </option>
                                                    @endfor
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th width="200">সময়কাল পর্যন্ত:</th>
                                            <td>
                                                <select class="max_width_350 form-control" name="license_fee_to" id="license_fee_to">
                                                    <option value="">সময়কাল নির্ধারণ করুন</option>
                                                    @for ($i = date('Y'); $i >= 1893; $i--)
                                                    <option value="{{ $i }}" {{ $i == $to_date ? 'selected' : '' }}>30th June
                                                        {{ $i }}
                                                    </option>
                                                    @endfor
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5>হিসাবের উদাহরণ</h5>
                                    @php
                                    $all_moujas = $license->commercialMoujas;
                                    $total = 0;
                                    foreach ($all_moujas as $mouja) {
                                    $total += $mouja->leased_area;
                                    }
                                    @endphp
                                    <p id="license_fee_calculated_data">
                                        জমির পরিমান: {{ number_format($total, 4) }} একর
                                        <br>
                                        মোট: {{ number_format($balam->license_fee, 2) }}/-
                                        <br>
                                        ভ্যাট: {{ number_format($balam->vat, 2) }}/-
                                        <br>
                                        ট্যাক্স: {{ number_format($balam->tax, 2) }}/-
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
                                <h5>বিভিন্ন ফি’র তথ্য</h5>
                                <div class="col-md-12">
                                    <table class="license_details_table_2">
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <label for="license_fee">লাইসেন্স ফি</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="form-control" name="license_fee" maxlength="11" id="license_fee" placeholder="লাইসেন্স ফি" value="{{ $balam->license_fee ?? '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_vat">ভ্যাট</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="form-control" name="license_vat" id="license_vat" placeholder="ভ্যাট" maxlength="11" value="{{ $balam->vat ?? '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_tax">উৎসে কর</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="form-control" name="license_tax" maxlength="11" id="license_tax" placeholder="উৎসে কর" value="{{ $balam->tax ?? '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_fines">জরিমানা</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="agri-fee-calculator form-control" data-key="fines" name="license_fines" id="license_fines" placeholder="জরিমানা" maxlength="11" value="{{ $balam->fine ?? '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_security">লাইসেন্সের সিকিউরিটি</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="agri-fee-calculator form-control" data-key="security" name="license_security" maxlength="11" id="license_security" placeholder="লাইসেন্সের সিকিউরিটি" value="{{ $balam->security ?? '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_plan_fee">লাইসেন্সের প্ল্যান ফি</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="agri-fee-calculator form-control" data-key="plan_fee" name="license_plan_fee" id="license_plan_fee" placeholder="লাইসেন্সের প্ল্যান ফি" maxlength="11" value="{{ $balam->plan_fee ?? '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_application_fee">লাইসেন্সের আবেদন ফি</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="agri-fee-calculator form-control" data-key="application_fee" name="license_application_fee" maxlength="11" id="license_application_fee" placeholder="লাইসেন্সের আবেদন ফি" value="{{ $balam->application_fee ?? '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_renew_fee">লাইসেন্সের নবায়ন ফি</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="agri-fee-calculator form-control" data-key="renew_fee" name="license_renew_fee" id="license_renew_fee" placeholder="লাইসেন্সের নবায়ন ফি" maxlength="11" value="{{ $balam->mutation_fee ?? '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_naming_fee">লাইসেন্সের নামজারী ফি</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="agri-fee-calculator form-control" data-key="naming_fee" name="license_naming_fee" id="license_naming_fee" placeholder="লাইসেন্সের নামজারী ফি" maxlength="11" value="{{ $balam->naming ?? '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_total_amount"><strong>মোট</strong></label>
                                                </th>
                                                <td>
                                                    <input type="text" class="form-control" id="license_total_amount" name="license_total_amount" readonly placeholder="মোট" maxlength="11" value="{{ $balam->total_fee ?? '' }}" />
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
                                                </tr>
                                                <tr>
                                                    <th><label for="license_vat_dd_no_{{ $key }}">ভাটের
                                                            ‘এ চালান’ নং</label></th>
                                                    <td>
                                                        <input type="number" class="form-control" id="license_vat_dd_no_{{ $key }}" placeholder="ভাটের ‘এ চালান’ নং" name="license_fee_dd[vat_no][{{ $key }}]" maxlength="11" value="{{ $dd->dd_vat ?? '' }}" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><label for="license_tax_dd_no_{{ $key }}">ট্যাক্সের
                                                            ডিডি নং</label></th>
                                                    <td>
                                                        <input type="number" class="form-control" id="license_tax_dd_no_{{ $key }}" placeholder="ট্যাক্সের ডিডি নং" name="license_fee_dd[tax_no][{{ $key }}]" value="{{ $dd->dd_tax ?? '' }}" />
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
                                                        <input type="date" class="form-control" name="license_fee_dd[dd_date][{{ $key }}]" id="license_dd_date_{{ $key }}" format="mm/dd/yyyy" placeholder="‘এ চালান’ এর তারিখ " value="{{ date('Y-m-d', strtotime($dd->dd_date)) ?? '' }}" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><label for="license_dd_total_amount_{{ $key }}">মোট
                                                            টাকা </label></th>
                                                    <td>
                                                        <input type="number" class="form-control" name="license_fee_dd[total_amount][{{ $key }}]" id="license_dd_total_amount_{{ $key }}" placeholder="মোট টাকা" value="{{ $dd->total ?? '' }}" />
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th><label for="license_dd_j1_slip_date_{{ $key }}">ফি
                                                            আদায়ের তারিখ</label>
                                                    </th>
                                                    <td>
                                                        <input type="date" class="form-control" name="license_fee_dd[j1_slip_date][{{ $key }}]" id="license_dd_j1_slip_date_{{ $key }}" placeholder="ফি আদায়ের তারিখ" value="{{ date('Y-m-d', strtotime($dd->j1_date)) ?? '' }}" />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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
                                                <tr>
                                                    <th><label for="license_dd_total_amount_0">মোট টাকা </label>
                                                    </th>
                                                    <td>
                                                        <input type="number" class="form-control" name="license_fee_dd[total_amount][0]" id="license_dd_total_amount_0" placeholder="মোট টাকা" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><label for="license_dd_j1_slip_date_0">ফি আদায়ের
                                                            তারিখ</label>
                                                    </th>
                                                    <td>
                                                        <input type="date" class="form-control" name="license_fee_dd[j1_slip_date][0]" id="license_dd_j1_slip_date_0" placeholder="ফি আদায়ের তারিখ" />
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