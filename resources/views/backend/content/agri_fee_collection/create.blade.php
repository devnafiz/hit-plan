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
        @lang('লাইসেন্স ফি আদায় ফরম')
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
        {{ html()->form('POST', route('admin.agri-license-fees.store'))->id('ownerForm')->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}
        <input type="hidden" id="license_fee_route" value="{{ route('admin.agriculture.license.fee.details') }}" />
        <input type="hidden" id="license_fee_calculator" value="{{ route('admin.agriculture.license.fee.calculator') }}" />
        <input type="hidden" id="license_owner_id" name="license_owner_id" />
        <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="col-md-12 bg-light text-justify mb-3">
                    <label class="mt-1">লাইসেন্স সংক্রান্ত তথ্য</h6>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="license_number">লাইসেন্স নং</label>
                            <div class="row">
                                <div class="col-md-9">
                                    <input type="number" id="license_number" class="form-control" maxlength="11" name="license_number" placeholder="লাইসেন্স নং" />
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-outline-primary btn-lg" id="checkingLicense"><i class="fa fa-search" aria-hidden="true"></i> চেক
                                        করুন</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hidden_form_parts">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <div class="card">
                                <div class="card-body" id="license_owner_info">

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
                                            <input type="hidden" id="type" value="1">
                                            <th width="200">সময়কাল হতে:</th>
                                            <td>
                                                <select class="max_width_350 form-control" name="license_fee_from" id="license_fee_from">
                                                    <option value="">সময়কাল নির্ধারণ করুন</option>
                                                    @for ($i = date('Y', strtotime('+5 years')); $i >= 1893; $i--)
                                                    <option value="{{ $i }}">১লা
                                                        বৈশাখ-{{ bangla_number($i - 593) }}
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
                                                    @for ($i = date('Y', strtotime('+5 years')); $i >= 1893; $i--)
                                                    <option value="{{ $i + 1 }}">৩০শে
                                                        চৈত্র-{{ bangla_number($i - 593) }}
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
                                    <p id="license_fee_calculated_data">

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
                                                    <input type="text" class="form-control" name="license_fee" maxlength="11" id="license_fee" placeholder="লাইসেন্স ফি" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_vat">ভ্যাট</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="form-control" name="license_vat" id="license_vat" placeholder="ভ্যাট" maxlength="11" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_tax">উৎসে কর</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="form-control" name="license_tax" maxlength="11" id="license_tax" placeholder="উৎসে কর" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_fines">জরিমানা</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="agri-fee-calculator form-control" data-key="fines" name="license_fines" id="license_fines" placeholder="জরিমানা" maxlength="11" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_security">লাইসেন্সের সিকিউরিটি</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="agri-fee-calculator form-control" data-key="security" name="license_security" maxlength="11" id="license_security" placeholder="লাইসেন্সের সিকিউরিটি" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_plan_fee">লাইসেন্সের প্ল্যান ফি</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="agri-fee-calculator form-control" data-key="plan_fee" name="license_plan_fee" id="license_plan_fee" placeholder="লাইসেন্সের প্ল্যান ফি" maxlength="11" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_application_fee">লাইসেন্সের আবেদন ফি</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="agri-fee-calculator form-control" data-key="application_fee" name="license_application_fee" maxlength="11" id="license_application_fee" placeholder="লাইসেন্সের আবেদন ফি" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_renew_fee">লাইসেন্সের নবায়ন ফি</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="agri-fee-calculator form-control" data-key="renew_fee" name="license_renew_fee" id="license_renew_fee" placeholder="লাইসেন্সের নবায়ন ফি" maxlength="11" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_naming_fee">লাইসেন্সের নামজারী ফি</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="agri-fee-calculator form-control" data-key="naming_fee" name="license_naming_fee" id="license_naming_fee" placeholder="লাইসেন্সের নামজারী ফি" maxlength="11" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <label for="license_total_amount"><strong>মোট</strong></label>
                                                </th>
                                                <td>
                                                    <input type="text" class="form-control" id="license_total_amount" name="license_total_amount" readonly placeholder="মোট" maxlength="11" />
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
                                                    <th><label for="license_tax_dd_no_0">ট্যাক্সের ডিডি নং</label></th>
                                                    <td>
                                                        <input type="text" class="form-control" id="license_tax_dd_no_0" placeholder="ট্যাক্সের ডিডি নং" name="license_fee_dd[tax_no][0]" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><label for="license_bank_name_0">ব্যাংক ও শাখার নাম </label>
                                                    </th>
                                                    <td>
                                                        <input type="text" class="form-control" name="license_fee_dd[bank_name][0]" id="license_bank_name_0" placeholder="ব্যাংক ও শাখার নাম " />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><label for="license_dd_date_0">‘এ চালান’ এর তারিখ </label></th>
                                                    <td>
                                                        <input type="date" class="form-control" name="license_fee_dd[dd_date][0]" id="license_dd_date_0" placeholder="‘এ চালান’ এর তারিখ " />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><label for="license_dd_total_amount_0">মোট টাকা </label></th>
                                                    <td>
                                                        <input type="number" class="form-control" name="license_fee_dd[total_amount][0]" id="license_dd_total_amount_0" placeholder="মোট টাকা" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><label for="license_dd_j1_slip_date_0">ফি আদায়ের তারিখ</label>
                                                    </th>
                                                    <td>
                                                        <input type="date" class="form-control" name="license_fee_dd[j1_slip_date][0]" id="license_dd_j1_slip_date_0" placeholder="ফি আদায়ের তারিখ" />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row save-button-container" id="save-button-container">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-lg btn-primary float-right">সেভ করুন</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{ html()->form()->close() }}
    </x-slot>

</x-backend.card>


@endsection

@push('after-styles')
@endpush

@push('after-scripts')
@endpush