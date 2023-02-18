@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('নতুন কৃষি লাইসেন্স যুক্ত'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('নতুন কৃষি লাইসেন্স যুক্ত করুন')
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
        {{ html()->form('POST', route('admin.agriculture.store'))->id('ownerForm')->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}
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
        <input type="hidden"  id="user_id" name="user_id" value="{{ Auth::user()->id }}"/>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="col-md-12 bg-light text-justify mb-3">
                    <label class="mt-1">লাইসেন্সীর তথ্য</h6>
                </div>
                <div class="row" id="license_owner_repeat_item_0">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="owner_name_0">লাইসেন্সীর নাম</label>
                            <input type="text" id="owner_name_0" class="form-control" value="{{ old('owner.0.name') }}" name="owner[0][name]" placeholder="লাইসেন্সীর নাম" />
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
                            <textarea name="owner[0][address]" id="a  ress_0" class="form-control" cols="30" rows="5" placeholder="আবেদনকারীর পূর্ণ ঠিকানা" value="{{ old('owner.0.address]') }}"></textarea>
                        </div>
                    </div>

                    <div class="col-md-2 mt-4">
                        <button type="button" id="license-owner" class="btn btn-primary">Add more</button>
                    </div>

                    <div class="col-12 imagediv_0" style="display: none;">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" id="web_image_0" name="owner[0][capture]">
                                    <label for="exampleFormControlTextarea1">Webcam</label>
                                    <video id="video_0" class="border" width="250" height="200" playsinline autoplay></video>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1" style="">Picture</label>
                                    <canvas id="canvas_0" width="250" height="200" style="display:none;" class="border"></canvas>
                                    <img src="" alt="" id="photo_0">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-3">
                                <button type="button" class="btn-sm btn-danger" id="snap_0">Capture</button>
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
                                    <button class="btn btn-outline-primary form-control capture_photo" data-target="#owner_photo_capture_0" type="button" data-video="#video_0" data-snap="#snap_0" data-canvas="#canvas_0" data-photo="#photo_0" data-display=".imagediv_0">
                                        ছবি তুলুন
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
                                    <option value="">তারিখ</option>
                                    @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}">{{ bangla_number($i) }}
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
                                    @foreach ($bn_months as $key => $month)
                                    <option value="{{ $key + 1 }}">{{ $month }}
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

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="hidden" id="type" value="1">
                                <select class="form-control" name="from_date[license_fee_from_yy]" id="license_fee_from_yy">
                                    <option value="">বঙ্গাব্দ</option>
                                    @for ($i = date('Y'); $i >= 1893; $i--)
                                    <option value="{{ $i - 593 }}">{{ bangla_number($i - 593) }}
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
                                    @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}">{{ bangla_number($i) }}
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
                                    @foreach ($bn_months as $key => $month)
                                    <option value="{{ $key + 1 }}">{{ $month }}
                                    </option>
                                    @endforeach
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
                                    <option value="">বঙ্গাব্দ</option>
                                    @for ($i = date('Y'); $i >= 1893; $i--)
                                    <option value="{{ $i - 593}}">{{ bangla_number($i - 593) }}
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

                <div class="col-md-12 bg-light text-justify mt-4 mb-3">
                    <label class="mt-1">এলাকা সংক্রান্ত তথ্য</h6>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="division_id">বিভাগের নাম:</label>
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
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="kachari_id">কাচারীর নাম:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select required id="kachari_id" class="form-control" name="kachari_id" required>
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
                            <select required class="form-control" id="district_id" name="district_id" required>
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
                            <select required class="form-control" id="upazila_id" name="upazila_id" required>
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
                            <select required class="form-control" id="station_id" name="station_id" required>
                                <option selected disabled>স্টেশন বাছাই করুন</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered" id="license_moujas">
                            <tr>
                                <th>মৌজার নাম</th>
                                <th>রেকর্ডের নাম</th>
                                <th>খতিয়ান নম্বর</th>
                                <th>দাগ নম্বর</th>
                                <th>জমির পরিমাণ</th>
                                <th>ইজারা পরিমাণ</th>
                                <th>প্রক্রিয়া</th>
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
                                    <input type="text" name="mouja[0][property_amount]" id="mouja_total_amount_0" placeholder="জমির পরিমাণ" class="form-control" />
                                </td>

                                <td style="width:10%;">
                                    <input type="text" name="mouja[0][leased_area]" id="leased_area_0" placeholder="লীজকৃত জমি" class="form-control" />
                                </td>

                                <td style="width:10%;">
                                    <button type="button" name="add2" id="addMoujas" class="btn btn-outline-primary">Add</button>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>

                <div class="col-md-12 bg-light text-justify mt-4 mb-3">
                    <label class="mt-1">চৌহদ্দি সংক্রান্ত তথ্য</h6>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        <div class="form-group">
                            <label for="exampleFormControlInput15">নকশা নং:</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="exampleFormControlInput15" placeholder="নকশা নং" name="land_map_number" value="{{ old('land_map_number') }}" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        <div class="form-group">
                            <label for="exampleFormControlInput16">নকশার তারিখ:</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="date" id="datepicker-autoclose" class="form-control bongabdo" name="land_map_date" id="exampleFormControlInput16" value="{{ old('land_map_date') }}" />
                    </div>
                </div>

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
                            <label for="exampleFormControlInput21">কি.মি: (ইংরেজিতে)</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control ledger_amount" id="exampleFormControlInput21" placeholder="কি.মি" name="land_map_kilo" value="{{ old('land_map_kilo') }}" />
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="jquery.bongabdo.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.bongabdo').bongabdo();
    });
</script>
@endpush

@push('after-scripts')
@endpush