@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('নতুন মাস্টারপ্লান যুক্ত'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('নতুন মাস্টারপ্লান যুক্ত করুন')
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

        <input type="hidden" id="kachari" value="{{ route('admin.ledger.fetch-kachari') }}">
        <input type="hidden" id="district" value="{{ route('admin.ledger.fetch-district') }}">
        <input type="hidden" id="upazila" value="{{ route('admin.ledger.fetch-upazila') }}">
        <input type="hidden" id="mouza" value="{{ route('admin.ledger.fetch-mouja') }}">
        <input type="hidden" id="station" value="{{ route('admin.ledger.fetch-station') }}">
        <input type="hidden" id="record" value="{{ route('admin.ledger.fetch-record') }}">
        <input type="hidden" id="ledger" value="{{ route('admin.ledger.fetch-ledger') }}">
        <input type="hidden" id="plot" value="{{ route('admin.ledger.fetch-plot') }}">

        @php
        $currentURL = request('tab', null);
        $masterplan_id = request('id', null);
        @endphp

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link @if ($currentURL == null) active @endif" style="text-decoration: none; color:black;" id="masterplan-tab" data-toggle="tab" role="tab" aria-controls="masterplan" aria-selected="true">মাস্টারপ্লান
                    সংক্রান্ত তথ্য</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if ($currentURL == 'plots') active @endif" style="text-decoration: none; color:black;" id="plots-tab" data-toggle="tab" role="tab" aria-controls="plots" aria-selected="false">মাস্টারপ্লানের প্লট
                    সংক্রান্ত তথ্য</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane @if ($currentURL == null) active show @else fade @endif" id="masterplan" role="tabpanel" aria-labelledby="masterplan-tab">
                {{ html()->form('POST', route('admin.masterplan.store'))->id('ownerForm')->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}
                @method('post')
                <input type="hidden" name="stepper" value="step-two">
                <div class="row mt-4">
                    <div class="col-md-12 col-sm-12">
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label for="masterplan_no">মাস্টারপ্লান নং:</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="masterplan_no" placeholder="মাস্টারপ্লান নং">
                                @if ($errors->has('masterplan_no'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('masterplan_no') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label for="masterplan_name">মাস্টারপ্লান এর নাম:</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="masterplan_name" placeholder="মাস্টারপ্লান এর নাম">
                                @if ($errors->has('masterplan_name'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('masterplan_name') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label for="approval_date">অনুমোদন এর তারিখ:</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control" name="approval_date">
                                @if ($errors->has('approval_date'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('approval_date') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label for="division_id">বিভাগ:</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select id="division_id" class="form-control division_id" name="division_id" required>
                                    <option value="" disabled selected>বাছাই করুন</option>
                                    @foreach ($division as $divisions_name)
                                    <option value="{{ $divisions_name->division_id }}">
                                        {{ $divisions_name->division_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('division_id'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('division_id') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label for="kachari_id">কাচারী:</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select id="kachari_id" class="form-control" name="kachari_id" required>
                                    <option selected disabled>কাচারী বাছাই করুন</option>
                                </select>
                                @if ($errors->has('kachari_id'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('kachari_id') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label for="district_id">জেলা:</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" id="district_id" name="district_id" required>
                                    <option selected disabled>জেলা বাছাই করুন</option>
                                </select>
                                @if ($errors->has('district_id'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('district_id') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label for="upazila_id">উপজেলা:</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" id="upazila_id" name="upazila_id" required>
                                    <option selected disabled>উপজেলা বাছাই করুন</option>
                                </select>
                                @if ($errors->has('upazila_id'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('upazila_id') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label for="station_id">স্টেশন:</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" id="station_id" name="station_id" required>
                                    <option selected disabled>স্টেশন বাছাই করুন</option>
                                </select>
                                @if ($errors->has('station_id'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('station_id') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 mt-4 responsive_table" style="overflow: auto;">
                        <table class="table table-bordered" id="masterplan_moujas" style="overflow-x: auto; width:100%;">
                            <tr>
                                <th>মৌজার নাম</th>
                                <th>রেকর্ডের নাম</th>
                                <th>খতিয়ান নম্বর</th>
                                <th>দাগ নম্বর</th>
                                <th>দাগে জমির পরিমাণ</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td style="width:15%">
                                    <select class="form-control mouja_id" id="mouja_id_0" data-target="#record_name_0" name="mouja[0][mouja_id]">
                                        <option selected disabled>মৌজা বাছাই করুন</option>
                                    </select>
                                </td>

                                <td style="width:15%">
                                    <select class="form-control record_name" id="record_name_0" data-target="#ledger_id_0" data-previous="mouja_id_0" name="mouja[0][record_name]">
                                        <option selected disabled>রেকর্ড</option>
                                    </select>
                                </td>

                                <td style="width:15%">
                                    <select class="form-control ledger_id" id="ledger_id_0" data-target="#plot_id_0" name="mouja[0][ledger_id]">
                                        <option selected disabled>খতিয়ান নম্বর</option>
                                    </select>
                                </td>

                                <td style="width:35%">
                                    <select class="form-control js-example-basic-single plot_id" id="plot_id_0" name="mouja[0][plot_id][]" multiple="multiple" data-target="#mouja_total_amount_0">
                                        <option selected disabled>দাগ নম্বর</option>
                                    </select>
                                </td>

                                <td style="width:15%">
                                    <input type="text" name="mouja[0][property_amount]" id="mouja_total_amount_0" placeholder="দাগে জমির পরিমাণ" class="form-control" maxlength="11" />
                                </td>

                                <td style="width:5%">
                                    <button type="button" name="add2" id="addMasterplanMouja" class="btn btn-outline-primary"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label for="masterplan_doc">মাস্টারপ্লান আপলোড:</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input type="file" class="form-control" name="masterplan_doc" id="masterplan_doc" />
                                @if ($errors->has('masterplan_doc'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('masterplan_doc') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-lg btn-primary float-right">SAVE & NEXT</button>
                </div>
                {{ html()->form()->close() }}
            </div>

            <div class="tab-pane @if ($currentURL == 'plots') active show @endif" id="plots" role="tabpanel" aria-labelledby="plots-tab">
                {{ html()->form('POST', route('admin.masterplan-plot.store'))->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}
                <input type="hidden" id="kachari" value="{{ route('admin.ledger.fetch-kachari') }}">
                <input type="hidden" id="district" value="{{ route('admin.ledger.fetch-district') }}">
                <input type="hidden" id="upazila" value="{{ route('admin.ledger.fetch-upazila') }}">
                <input type="hidden" id="station" value="{{ route('admin.ledger.fetch-station') }}">

                <div class="row mt-4">
                    <div class="col-md-12 col-sm-12">
                        <input type="hidden" name="masterplan_id" value="{{ $masterplan_id }}">
                        <table class="table table-bordered" id="mouja-plot">
                            <tr>
                                <td>
                                    <label for="plot_number">প্লট নম্বর:</label>
                                </td>
                                <td>
                                    <label for="plot_length">প্লটের দৈর্ঘ্য (ফুট) :</label>
                                </td>
                                <td>
                                    <label for="plot_width">প্লটের প্রস্থ (ফুট):</label>
                                </td>
                                <td>
                                    <label for="total_sft">প্লটের পরিমাপ (বর্গফুট):</label>
                                </td>
                                <!-- <td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <label for="plot_size">জমির পরিমান:</label>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </td> -->
                                <td>
                                    <label for="plot_size">মন্তব্য:</label>
                                </td>
                                <td>
                                    <label for="action">প্রক্রিয়া</label>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">
                                    <input type="text" class="form-control" name="masterplan_plot[0][plot_number]" id="plot_number_0" placeholder="প্লট নম্বর">
                                </td>
                                <td>
                                    <input type="test" class="form-control mr-1 plot_length numeric_number" name="masterplan_plot[0][plot_length]" id="plot_length_0" data-target="#total_sft_0" data-target2="#plot_size_0" placeholder="প্লটের সাইজ(দৈর্ঘ্য)" data-height="#plot_width_0">
                                </td>
                                <td>
                                    <input type="test" class="form-control plot_width numeric_number" name="masterplan_plot[0][plot_width]" id="plot_width_0" placeholder="প্লটের সাইজ(প্রস্থ)" data-target="#total_sft_0" data-target2="#plot_size_0" data-height="#plot_length_0">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="masterplan_plot[0][total_sft]" id="total_sft_0" placeholder="প্লটের সাইজ(স্কয়ারফিট)">
                                    <input type="hidden" class="form-control" name="masterplan_plot[0][plot_size]" id="plot_size_0" placeholder="মোট জমির পরিমান" value="0">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="masterplan_plot[0][plot_comments]" id="plot_comments_0" placeholder="মন্তব্য">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-primary addMasterPlanPlot" data-key="1"><i class="fa fa-plus"></i></button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary float-right">SAVE
                                NOW</button>
                        </div>
                    </div>
                </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </x-slot>

</x-backend.card>
@endsection

@push('after-styles')
{{-- <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"> --}}
@endpush

@push('after-scripts')
<script>
    $(".nav-item").click(function() {
        let val = $(this).children('a').attr('id');
        if (val == "masterplan-tab") {
            $("#masterplan").addClass("active show");
            $("#plots").removeClass("active show");
            $("#plots").addClass("fade");
        }

        if (val == "plots-tab") {
            $("#plots").addClass("active show");
            $("#masterplan").removeClass("active show");
            $("#plots").addClass("fade");
        }
    });
</script>
@endpush