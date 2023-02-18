@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('নতুন সংস্থা লাইসেন্স যুক্ত করুন'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('নতুন সংস্থা লাইসেন্স যুক্ত করুন')
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

        {{ html()->form('POST', route('admin.agency.store'))->id('ownerForm')->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}
        <input type="hidden" id="kachari" value="{{ route('admin.ledger.fetch-kachari') }}">
        <input type="hidden" id="district" value="{{ route('admin.ledger.fetch-district') }}">
        <input type="hidden" id="upazila" value="{{ route('admin.ledger.fetch-upazila') }}">
        <input type="hidden" id="mouza" value="{{ route('admin.ledger.fetch-mouja') }}">
        <input type="hidden" id="station" value="{{ route('admin.ledger.fetch-station') }}">
        <input type="hidden" id="land" value="{{ route('admin.ledger.land-type') }}">
        <input type="hidden" id="record" value="{{ route('admin.ledger.fetch-record') }}">
        <input type="hidden" id="ledger" value="{{ route('admin.ledger.fetch-ledger') }}">
        <input type="hidden" id="plot" value="{{ route('admin.ledger.fetch-plot') }}">

        <input type="hidden"  id="user_id" name="user_id" value="{{ Auth::user()->id }}"/>


        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 bg-light text-justify mb-3">
                    <label class="mt-1">লাইসেন্সীর তথ্য</h6>
                </div>
                <div class="row" id="license_owner_repeat_item_0">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="owner_name_0">সংস্থার নাম</label>
                            <input type="text" id="owner_name_0" class="form-control" value="{{ old('owner.0.name') }}" name="owner[0][name]" placeholder="লাইসেন্সীর নাম" required />
                        </div>

                        <div class="form-group">
                            <div class="form-group mt-1">
                                <label class="form-check-label" for="fatherName">
                                    পদবী
                                </label>
                                <input type="text" id="agency_position" class="form-control" name="owner[0][agency_position]" value="{{ old('owner.0.agency_position]') }}" placeholder="সংস্থার পদবী" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mobile_0">মোবাইল নং</label>
                            <input type="number" id="mobile_0" class="form-control ledger_amount" name="owner[0][phone]" placeholder="Phone Number" class="form-control" value="{{ old('owner.0.phone]') }}" maxlength="15" />
                        </div>
                        <div class="form-group">
                            <label for="address_0">ঠিকানা</label>
                            <textarea name="owner[0][address]" id="address_0" class="form-control" cols="30" rows="5" placeholder="আবেদনকারীর পূর্ণ ঠিকানা" value="{{ old('owner.0.address]') }}"></textarea>
                        </div>
                    </div>
                </div>

                <div id="dynamic-owner-information"></div>


                <div class="col-md-12 bg-light text-justify mt-4 mb-3">
                    <label class="mt-1">সর্বশেষ লাইসেন্স ফি পরিশোধের সময়কাল</h6>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="demand_notice_number">হতে:</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="hidden" id="type" value="1">
                                <select class="form-control" name="from_date[license_fee_from_dd]" id="license_fee_from_dd">
                                    <option value="">তারিখ</option>
                                    @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}">{{ $i }}
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

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="hidden" id="type" value="1">
                                <select class="form-control" name="from_date[license_fee_from_mm]" id="license_fee_from_mm">
                                    <option value="">মাস</option>
                                    @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}">
                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                        @endfor
                                </select>
                            </div>
                            @if ($errors->has('license_fee_from_mm'))
                            <p class="text-danger">
                                <small>{{ $errors->first('license_fee_from_mm') }}</small>
                            </p>
                            @endif
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="hidden" id="type" value="1">
                                <select class="form-control" name="from_date[license_fee_from_yy]" id="license_fee_from_yy">
                                    <option value="">বছর</option>
                                    @for ($i = date('Y'); $i >= 1893; $i--)
                                    <option value="{{ date('Y', strtotime($i)) }}">{{ $i }}
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
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control" name="to_date[license_fee_to_dd]" id="license_fee_to_mm">
                                    <option value="">তারিখ</option>
                                    @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}">{{ $i }}
                                        </option>
                                        @endfor
                                </select>
                            </div>
                            @if ($errors->has('license_fee_to_mm'))
                            <p class="text-danger">
                                <small>{{ $errors->first('license_fee_to_mm') }}</small>
                            </p>
                            @endif
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control" name="to_date[license_fee_to_mm]" id="license_fee_to_mm">
                                    <option value="">মাস</option>
                                    @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}">
                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                        @endfor
                                </select>
                            </div>
                            @if ($errors->has('license_fee_to_mm'))
                            <p class="text-danger">
                                <small>{{ $errors->first('license_fee_to_mm') }}</small>
                            </p>
                            @endif
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="to_date[license_fee_to_yy]" id="license_fee_to_yy">
                                    <option value="">বছর</option>
                                    @for ($i = date('Y'); $i >= 1893; $i--)
                                    <option value="{{ date('Y', strtotime($i)) }}">{{ $i }}
                                    </option>
                                    @endfor
                                </select>
                            </div>
                            @if ($errors->has('license_fee_to_yy'))
                            <p class="text-danger">
                                <small>{{ $errors->first('license_fee_to_yy') }}</small>
                            </p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-12 bg-light text-justify mt-4 mb-3">
                    <label class="mt-1">ফি সংক্রান্ত তথ্য</h6>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="demand_notice_number">ডিমান্ড নোটিশের নং এবং নোটিশের তারিখ :</label>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <textarea cols="100" rows="5" type="text" class="form-control" value="{{ old('demand_notice_number') }}" name="demand_notice_number" id="demand_notice_number" placeholder="ডিমান্ড নোটিশের নং এবং নোটিশের তারিখ "> </textarea>
                        </div>
                    </div>

                </div>

                <div class="col-md-12 bg-light text-justify mt-2 mb-3">
                    <label class="mt-1">এলাকা সংক্রান্ত তথ্য</h6>
                </div>

                <!-- division-->

                <div class="col-12">
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="division_id">বিভাগের নাম:</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <select required id="division_id" class="form-control division_id" name="mouja[0][division_id]" data-target="#kachari_id_0" required>
                                <option value="" disabled selected>বাছাই করুন</option>
                                @foreach ($division as $divisions_name)
                                <option value="{{ $divisions_name->division_id }}">
                                    {{ $divisions_name->division_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 ">
                            <button type="button" id="addwhole-divisin" class="btn btn-primary">Add more</button>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="kachari_id">কাচারীর নাম:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select required id="kachari_id_0" class="form-control kachari_id" name="mouja[0][kachari_id]" data-target="#district_id_0" required>
                                <option selected disabled>কাচারী বাছাই করুন</option>
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="district_id">জেলার নাম:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select required class="form-control district_id" id="district_id_0" name="mouja[0][district_id]" data-target="#upazila_id_0" required>
                                <option selected disabled>জেলা বাছাই করুন</option>
                            </select>
                        </div>

                    </div>




                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="upazila_id">উপজেলার নাম:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select required class="form-control upazila_id" id="upazila_id_0" name="mouja[0][upazila_id]" data-target="#station_id_0" required>
                                <option selected disabled>উপজেলা বাছাই করুন</option>
                            </select>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="station_id">স্টেশনের নাম:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select required class="form-control station_id" id="station_id_0" name="mouja[0][station_id]" data-target="#mouja_id_0" required>
                                <option selected disabled>স্টেশন বাছাই করুন</option>
                            </select>
                        </div>
                    </div>


                </div>


                <div class="col-md-12">
                    <table class="table table-bordered" id="license_moujas">
                        <tr>
                            <th>মৌজার নাম</th>
                            <th>রেকর্ডের নাম</th>
                            <th>খতিয়ান নম্বর</th>
                            <th>দাগ নম্বর</th>
                            <th>লীজকৃত জমির পরিমাণ</th>
                            <!-- <th>লীজকৃত জমির পরিমাণ </th> -->


                        </tr>
                        <tr>
                            <td style="width: 10%;">
                                <select class="form-control mouja_id" id="mouja_id_0" data-target="#record_name_0" name="mouja[0][mouja_id]" required>
                                    <option selected disabled>মৌজা</option>
                                </select>
                            </td>

                            <td style="width: 10%;">
                                <select class="form-control record_name" id="record_name_0" data-target="#ledger_id_0" name="mouja[0][record_name]" data-previous="mouja_id_0">
                                    <option selected disabled>রেকর্ড</option>
                                </select>
                            </td>

                            <td style="width: 10%;">
                                <select class="form-control ledger_id" id="ledger_id_0" data-target="#plot_id_0" name="mouja[0][ledger_id]">
                                    <option selected disabled>খতিয়ান নম্বর</option>
                                </select>
                            </td>

                            <td style="width: 20%;">
                                <select class="form-control js-example-basic-single plot_id" id="plot_id_0" name="mouja[0][plot_id][]" multiple="multiple" data-target="#mouja_total_amount_0">
                                    <option selected disabled>দাগ নম্বর</option>
                                </select>
                            </td>

                            <td style="width: 10%;">
                                <input type="text" name="mouja[0][property_amount]" id="mouja_total_amount1_0" placeholder="জমির পরিমাণ (বর্গফুট)" class="form-control" />
                            </td>
                            <!-- <td style="width:10%;">
                                    <input type="text" name="mouja[0][leased_area]" id="leased_area_0" placeholder="লীজকৃত জমি (বর্গ ফুট)" class="form-control" />
                      </td> -->




                        </tr>

                    </table>
                </div>




            </div>
            <div class="col-md-12">
                <div id="dynamic-wholedivision"></div>
            </div>

            <!-- end-- division-->


            <div class="col-md-12 bg-light text-justify mt-4 mb-3">
                <label class="mt-1">চৌহদ্দি সংক্রান্ত তথ্য</h6>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-md-2 text-right">
                        <div class="form-group">
                            <label for="demand_notice_number">নকসা নং এবং তারিখ :</label>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <textarea cols="100" rows="5" type="text" class="form-control" value="{{ old('design_and_date') }}" name="design_and_date" id="design_and_date" placeholder="নকসা নং এবং তারিখ"> </textarea>
                    </div>
                </div>
                <br />

                <div class="row">
                    <div class="col-md-2 text-right">
                        <div class="form-group">
                            <label for="demand_notice_number">অন্যান্য :</label>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <textarea cols="100" rows="5" type="text" class="form-control" value="{{ old('others') }}" name="others" id="others" placeholder="অন্যান্য"> </textarea>
                    </div>
                </div>

                <br />
                <div class="row">
                    <div class="col-md-2 text-right">
                        <div class="form-group">
                            <label for="exampleFormControlFile2">অনুমোদনের কপি আপলোড করুন: </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="file" class="form-control" name="land_map_certificate" id="exampleFormControlFile2" />
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-lg btn-dark float-right">Save New License</button>
            </div>
        </div>

        {{ html()->form()->close() }}
    </x-slot>

</x-backend.card>

<script></script>
@endsection

@push('after-styles')
{{-- <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"> --}}
@endpush

@push('after-scripts')
<script src="{{asset('js/case.js')}}"></script>
@endpush