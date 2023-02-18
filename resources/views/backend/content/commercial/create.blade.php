@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('নতুন বাণিজ্যিক লাইসেন্স যুক্ত করুন'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('নতুন বাণিজ্যিক লাইসেন্স যুক্ত করুন')
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

        {{ html()->form('POST', route('admin.commercial.store'))->id('ownerForm')->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}
        <input type="hidden" id="kachari" value="{{ route('admin.ledger.fetch-kachari') }}">
        <input type="hidden" id="district" value="{{ route('admin.ledger.fetch-district') }}">
        <input type="hidden" id="upazila" value="{{ route('admin.ledger.fetch-upazila') }}">
        <input type="hidden" id="mouza" value="{{ route('admin.ledger.fetch-mouja') }}">
        <input type="hidden" id="station" value="{{ route('admin.ledger.fetch-station') }}">
        <input type="hidden" id="plot" value="{{ route('admin.ledger.fetch-plot') }}">
        <input type="hidden" id="masterplan" value="{{ route('admin.ledger.fetch-masterplan') }}">
        <input type="hidden" id="masterplanplot" value="{{ route('admin.ledger.fetch-masterplan-plot') }}">

        <input type="hidden"  id="user_id" name="user_id" value="{{ Auth::user()->id }}"/>

        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 bg-light text-justify mb-3">
                    <label class="mt-1">লাইসেন্সীর তথ্য</h6>
                </div>
                <div class="row" id="license_owner_repeat_item_0">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="owner_name_0">লাইসেন্সীর নাম</label>
                            <input type="text" id="owner_name_0" class="form-control" value="{{ old('owner.0.name') }}" name="owner[0][name]" placeholder="লাইসেন্সীর নাম" required />
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="owner[0][nameOption]" id="fatherName" value="fatherName" checked>
                                <label class="form-check-label" for="fatherName">
                                    পিতার নাম
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="owner[0][nameOption]" id="husbandName" value="husbandName">
                                <label class="form-check-label" for="husbandName">
                                    স্বামীর নাম
                                </label>
                            </div>

                            <div class="form-group mt-1">
                                <input type="text" id="full_name_0" class="form-control" name="owner[0][full_name]" value="{{ old('owner.0.full_name]') }}" placeholder="পূর্ণ নাম" />
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="nid_0">জাতীয় পরিচয়পত্র নং</label>
                            <input type="number" class="form-control nid_validation" id="nid_0" name="owner[0][nid]" value="{{ old('owner.0.nid]') }}" placeholder="জাতীয় পরিচয়পত্র নং" maxlength="20" />
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

                    <div class="col-md-2 mt-4">
                        <button type="button" id="license-owner" class="btn btn-primary">Add more</button>
                    </div>

                    <div class="col-12 imagediv" style="display: none;">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" id="web_image" name="owner[0][capture]">
                                    <label for="exampleFormControlTextarea1">Webcam</label>
                                    <video id="video" class="border" width="250" height="200" playsinline autoplay></video>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1" style="">Picture</label>
                                    <canvas id="canvas" width="250" height="200" style="display:none;" class="border"></canvas>
                                    <img src="" alt="" id="photo">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-3">
                                <button type="button" class="btn-sm btn-danger" id="snap">Capture</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label" for="photo_0">ছবি সংযুক্ত করুন</label>

                            <div class="row">
                                <div class="col-md-3">
                                    <input class="form-control" id="photo_0" name="owner[0][photo]" type="file">
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-outline-primary form-control capture_photo" data-target="#owner_photo_capture_0" id="take" type="button">ছবি তুলুন
                                        &nbsp;<i class="icon-camera"></i></button>
                                    <input class="form-control" id="owner_photo_capture_0" name="owner[0][owner_capture_photo]" type="file" accept="image/*;capture=camera" style="display: none;">
                                    <div class="owner_photo_capture"></div>
                                </div>
                            </div>
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
                                    <option value="">Day</option>
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
                                    <option value="">Month</option>
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
                                    <option value="">Year</option>
                                    @for ($i = date('Y'); $i >= 1893; $i--)
                                    <option value="{{ $i }}">{{ $i }}
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
                                    <option value="">Day</option>
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
                                    <option value="">Month</option>
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
                                    <option value="">Year</option>
                                    @for ($i = date('Y'); $i >= 1893; $i--)
                                    <option value="{{ $i }}">{{ $i }}
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
                                <label for="demand_notice_number">ডিমান্ড নোটিশের নং:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" value="{{ old('demand_notice_number') }}" name="demand_notice_number" id="demand_notice_number" placeholder="ডিমান্ড নোটিশের নং">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="demand_notice_date">ডিমান্ড নোটিশের তারিখ:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" value="{{ old('demand_notice_date') }}" name="demand_notice_date" id="demand_notice_date">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 bg-light text-justify mt-2 mb-3">
                    <label class="mt-1">এলাকা সংক্রান্ত তথ্য</h6>
                </div>

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
                        <select required class="form-control" id="station_id" name="station_id" data-key="masterplan" data-target="#masterplan_id_0" required>
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
                    <div class="col-md-12">
                        <table class="table table-bordered" id="commercial_moujas">
                            <tr>
                                <th>মাস্টারপ্লান</th>
                                <th>প্লট নম্বর</th>
                                <th>প্লটের সাইজ(দৈর্ঘ্য)</th>
                                <th>প্লটের সাইজ(প্রস্থ)</th>
                                <th>প্লটের জমির পরিমাণ</th>
                                <th>লীজকৃত জমির পরিমাণ</th>
                                <th>প্রক্রিয়া</th>
                            </tr>
                            <tr>
                                <td>
                                    <select class="form-control masterplan_no" id="masterplan_id_0" name="mouja[0][masterplan_id]" data-target="#plot_id_0">
                                        <option selected disabled>মাস্টারপ্লান বাছাই করুন</option>
                                    </select>
                                </td>

                                <td class="w-25">
                                    <select class="form-control js-example-basic-single plot_id" id="plot_id_0" name="mouja[0][plot_id][]" data-target="#mouja_total_amount_0" multiple>
                                        <option selected disabled>দাগ নম্বর</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="test" class="form-control mr-1" name="mouja[0][plot_length]" id="plot_length_0" data-target="#total_sft_0" data-target2="#plot_size_0" placeholder="প্লটের সাইজ(দৈর্ঘ্য)" data-height="#plot_width_0">
                                </td>
                                <td>
                                    <input type="test" class="form-control" name="mouja[0][plot_width]" id="plot_width_0" placeholder="প্লটের সাইজ(প্রস্থ)" data-target="#total_sft_0" data-target2="#plot_size_0" data-height="#plot_length_0">
                                </td>

                                <td>
                                    <input type="text" name="mouja[0][property_amount]" id="mouja_total_amount_0" placeholder="দাগে জমির পরিমাণ" class="form-control" />
                                </td>

                                <td>
                                    <input type="text" name="mouja[0][leased_area]" id="leased_area_0" placeholder="লীজকৃত জমির পরিমাণ" class="form-control" />
                                </td>

                                <td style="width: 10%;">
                                    <button type="button" name="add2" id="addComMoujas" class="btn btn-outline-primary" data-key="1">Add</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>


                <div class="col-md-12 bg-light text-justify mt-4 mb-3">
                    <label class="mt-1">চৌহদ্দি সংক্রান্ত তথ্য</h6>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="exampleFormControlInput17">চৌহদ্দি: উত্তর:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="land_map_north" id="exampleFormControlInput17" value="{{ old('land_map_north') }}" placeholder="চৌহদ্দি: উত্তর" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="land_map_east">পূর্ব:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="land_map_east" id="land_map_east" value="{{ old('land_map_east') }}" placeholder="পূর্ব" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="land_map_south">দক্ষিণ:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="land_map_south" id="land_map_south" value="{{ old('land_map_south') }}" placeholder="দক্ষিণ" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="exampleFormControlInput20">পশ্চিম:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="exampleFormControlInput20" placeholder="পশ্চিম" value="{{ old('land_map_west') }}" name="land_map_west" />
                        </div>
                    </div>

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
@endpush