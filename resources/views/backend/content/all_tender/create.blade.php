@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('নতুন বাণিজ্যিক দরপত্র যুক্ত'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('নতুন বাণিজ্যিক দরপত্র যুক্ত করুন')
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
        {{ html()->form('POST', route('admin.masterplan.store'))->id('ownerForm')->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}
        <input type="hidden" id="kachari" value="{{ route('admin.ledger.fetch-kachari') }}">
        <input type="hidden" id="district" value="{{ route('admin.ledger.fetch-district') }}">
        <input type="hidden" id="upazila" value="{{ route('admin.ledger.fetch-upazila') }}">
        <input type="hidden" id="mouza" value="{{ route('admin.ledger.fetch-mouja') }}">
        <input type="hidden" id="station" value="{{ route('admin.ledger.fetch-station') }}">
        <input type="hidden" id="land" value="{{ route('admin.ledger.land-type') }}">
        <input type="hidden" id="record" value="{{ route('admin.ledger.fetch-record') }}">
        <input type="hidden" id="ledger" value="{{ route('admin.ledger.fetch-ledger') }}">
        <input type="hidden" id="plot" value="{{ route('admin.ledger.fetch-plot') }}">

        <input type="hidden" id="land_type_option" value="{{ json_encode($land_type) }}">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 bg-light text-justify mb-3">
                    <label class="mt-1">বাণিজ্যিক দরপত্র তৈরি</h6>
                </div>

                <div class="col-12">

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="division_id">বিভাগ:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select required id="division_id" class="form-control division_id" name="division_id" required>
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
                            <select required id="kachari_id" class="form-control" name="kachari_id" required>
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
                            <select required class="form-control" id="district_id" name="district_id" required>
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
                            <select required class="form-control" id="upazila_id" name="upazila_id" required>
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
                            <select required class="form-control" id="station_id" name="station_id" required>
                                <option selected disabled>স্টেশন বাছাই করুন</option>
                            </select>
                            @if ($errors->has('station_id'))
                            <p class="text-danger">
                                <small>{{ $errors->first('station_id') }}</small>
                            </p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="masterplan_id">মাস্টারপ্লান:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select required class="form-control" id="masterplan_id" name="masterplan_id" required>
                                <option selected disabled>মাস্টারপ্লান বাছাই করুন</option>
                            </select>
                            @if ($errors->has('masterplan_id'))
                            <p class="text-danger">
                                <small>{{ $errors->first('masterplan_id') }}</small>
                            </p>
                            @endif
                        </div>
                    </div>

                    <div class="row" id="plot_width_length">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="plot_id">প্লট:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control js-example-basic-single plot_id" id="plot_id_0" name="mouja[0][plot_id][]" multiple="multiple" data-target="#mouja_total_amount_0" required>
                                <option selected disabled>প্লট নম্বর</option>
                            </select>
                            @if ($errors->has('plot_id'))
                            <p class="text-danger">
                                <small>{{ $errors->first('plot_id') }}</small>
                            </p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="tender_publish_date">দরপত্র বিক্রই শুরুর (তারিখ):</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="tender_publish_date">
                            @if ($errors->has('tender_publish_date'))
                            <p class="text-danger">
                                <small>{{ $errors->first('tender_publish_date') }}</small>
                            </p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="tender_closing_date">দরপত্র বিক্রয়ের শেষের তারিখ:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="tender_closing_date">
                            @if ($errors->has('tender_closing_date'))
                            <p class="text-danger">
                                <small>{{ $errors->first('tender_closing_date') }}</small>
                            </p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="tender_name">দরপত্র নাম:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="tender_name" placeholder="দরপত্র নাম">
                            @if ($errors->has('tender_name'))
                            <p class="text-danger">
                                <small>{{ $errors->first('tender_name') }}</small>
                            </p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="tender_no">দরপত্র নম্বর:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="tender_no" placeholder="দরপত্র নম্বর">
                            @if ($errors->has('tender_no'))
                            <p class="text-danger">
                                <small>{{ $errors->first('tender_no') }}</small>
                            </p>
                            @endif
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-lg btn-dark float-right">Create tender</button>
            </div>
        </div>

        {{ html()->form()->close() }}
    </x-slot>

</x-backend.card>

<script></script>
@endsection


@push('after-scripts')
@endpush