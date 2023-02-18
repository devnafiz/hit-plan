@extends('backend.layouts.app')

@section('title', __('কৃষি লাইসেন্স সংশোধন '))

@section('content')

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

{{ html()->modelForm($license, 'PUT', route('admin.agriculture.update', $license))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}
<x-backend.card>
    <x-slot name="header">
        @lang('তথ্য সংশোধন ')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :href="route('admin.agriculture.index')" :text="__('Cancel')" />
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
        <input type="hidden" id="station" value="{{ route('admin.ledger.fetch-station') }}">

        <input type="hidden" id="mouza" value="{{ route('admin.ledger.fetch-mouja') }}">
        <input type="hidden" id="land" value="{{ route('admin.ledger.land-type') }}">
        <input type="hidden" id="record" value="{{ route('admin.ledger.fetch-record') }}">
        <input type="hidden" id="ledger" value="{{ route('admin.ledger.fetch-ledger') }}">
        <input type="hidden" id="plot" value="{{ route('admin.ledger.fetch-plot') }}">

        <input type="hidden" id="land_type_option" value="{{ json_encode($land_type) }}">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="col-md-12 bg-light text-justify mb-3">
                    <label class="mt-1">আবেদনকারীর তথ্য</h6>
                </div>
                @foreach ($license->agriOwner as $key => $owner)
                <div class="row" id="license_owner_repeat_item_{{ $key }}" class="license_owner_repeat_item">
                    <input type="hidden" value="{{ $owner->id }}" name="owner[{{ $key }}][id]" />
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="owner_name_{{ $key }}">আবেদনকারীর নাম</label>
                            <input type="text" id="owner_name_{{ $key }}" class="form-control" value="{{ $owner->name }}" name="owner[{{ $key }}][name]" placeholder="আবেদনকারীর নাম" />
                        </div>
                        <div class="form-group mt-1">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="owner[{{ $key }}][nameOption]" id="fatherName" value="fatherName" @if ($owner->father_name) checked @endif>
                                <label class="form-check-label" for="fatherName">
                                    পিতার নাম
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="owner[{{ $key }}][nameOption]" id="husbandName" value="husbandName" @if ($owner->husband_name) checked @endif>
                                <label class="form-check-label" for="husbandName">
                                    স্বামীর নাম
                                </label>
                            </div>
                            <input type="text" id="full_name_{{ $key }}" class="form-control" name="owner[{{ $key }}][full_name]" value="{{ $owner->father_name ? $owner->father_name : $owner->husband_name }}" placeholder="পূর্ণ নাম" />
                        </div>

                        <div class="form-group">
                            <label for="nid_{{ $key }}">জাতীয় পরিচয়পত্র নং</label>
                            <input type="text" class="form-control nid_validation" id="nid_{{ $key }}" name="owner[{{ $key }}][nid]" value="{{ $owner->nid }}" placeholder="জাতীয় পরিচয়পত্র নং" maxlength="20" />
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mobile_{{ $key }}">মোবাইল নং</label>
                            <input type="text" id="mobile_{{ $key }}" class="form-control ledger_amount" name="owner[{{ $key }}][phone]" placeholder="Phone Number" class="form-control" value="{{ $owner->phone }}" maxlength="15" />
                        </div>
                        <div class="form-group">
                            <label for="address_{{ $key }}">ঠিকানা</label>
                            <textarea name="owner[{{ $key }}][address]" id="address_{{ $key }}" class="form-control" cols="30" rows="5" placeholder="আবেদনকারীর পূর্ণ ঠিকানা" value="{{ $owner->address }}">{{ $owner->address }}</textarea>
                        </div>
                    </div>

                    @if ($key === 0)
                    <div class="col-md-2 mt-4">
                        <button type="button" id="license-owner" class="btn btn-primary">Add more</button>
                    </div>
                    @else
                    <div class="col-md-2 mt-4">
                        <a href="{{ route('admin.license_owner.delete', $owner->id) }}" data-method="delete-post" class="btn btn-danger agri-license-owner-delete">Delete</a>
                    </div>
                    @endif

                    <div class="row col-12">
                        <div class="col-md-3">
                            <div class="form-group" id="for_New_upload">
                                @php
                                $image = $owner->photo ? $owner->photo : 'no-image.gif';
                                @endphp
                                <label for="image">
                                    <img src="{{ asset('uploads/owners/' . $image) }}" class="img-fluid" id="holder" alt="Image upload">
                                </label>
                                {{ html()->file('picture')->id('image')->class('d-none')->acceptImage() }}
                            </div> <!-- form-group -->
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <div class="row">
                                <label for="photo_{{ $key }}">ছবি সংযুক্ত করুন</label>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <input class="form-control" id="photo_{{ $key }}" name="owner[{{ $key }}][photo]" type="file">
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-outline-primary form-control capture_photo" data-target="#owner_photo_capture_0" type="button">ছবি তুলুন &nbsp;<i class="icon-camera"></i></button>
                                    <input class="form-control" id="owner_photo_capture_{{ $key }}" name="owner[{{ $key }}][owner_capture_photo]" type="file" accept="image/*;capture=camera" style="display: none;">
                                    <div class="owner_photo_capture"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach

                <div id="dynamic-owner-information"></div>

                <div class="col-md-12 bg-light text-justify mt-4 mb-3">
                    <label class="mt-1">সর্বশেষ লাইসেন্স ফি পরিশোধের সময়কাল</h6>
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

                <div class="col-12">
                    <input type="hidden" name="balam_id" value="{{ $balam_id }}">
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
                                    @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}" @if ($last_from_day==$i) selected @endif>{{ bangla_number($i) }}
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
                                    <option value="{{ $key + 1 }}" @if ($last_from_month==$key + 1) selected @endif>{{ $month }}
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
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control" name="to_date[license_fee_to_dd]" id="license_fee_to_mm">
                                    <option value="">তারিখ</option>
                                    @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}" @if ($last_to_day==$i) selected @endif>{{ bangla_number($i) }}
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
                                    <option value="{{ $key + 1 }}" @if ($last_to_month==$key + 1) selected @endif>{{ $month }}
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
                                    @for ($i = date('Y', strtotime('+5 years')); $i >= 1893; $i--)
                                    <option value="{{ $i - 593 }}" @if ($last_to_year==$i - 593) selected @endif>
                                        {{ bangla_number($i - 593) }}
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
                    <label class="mt-1">খতিয়ান ও দাগ সম্পর্কিত তথ্য</h6>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="demand_notice_number">ডিমান্ড নোটিশের নং:</label>
                            <input type="text" class="form-control" name="demand_notice_number" id="demand_notice_number" placeholder="ডিমান্ড নোটিশের নং" value="{{ $license->demand_notice_number }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="demand_notice_date">ডিমান্ড নোটিশের তারিখ:</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime($license->demand_notice_date)) }}" name="demand_notice_date" id="demand_notice_date">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="division_id">বিভাগের নাম:</label>
                            {{ html()->select('division_id', collect($division))->class('form-control')->id('division_id') }}
                            <p class="text-danger error mt-2"></p>
                        </div>

                        <div class="form-group">
                            <label for="kachari_id">কাচারীর নাম:</label>
                            {{ html()->select('kachari_id', collect($kachari))->class('form-control')->id('kachari_id') }}
                            <p class="text-danger error mt-2"></p>
                        </div>

                        <div class="form-group">
                            <label for="district_id">জেলার নাম:</label>
                            {{ html()->select('district_id', collect($district))->class('form-control')->id('district_id') }}
                            <p class="text-danger error mt-2"></p>
                        </div>

                        <div class="form-group">
                            <label for="upazila_id">উপজেলার নাম:</label>
                            {{ html()->select('upazila_id', collect($upazila))->class('form-control')->id('upazila_id') }}
                            <p class="text-danger error mt-2"></p>
                        </div>

                        <div class="form-group">
                            <label for="station_id">স্টেশনের নাম:</label>
                            {{ html()->select('station_id', collect($station))->class('form-control')->id('station_id') }}
                            <p class="text-danger error mt-2"></p>
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
                                <th>লীজকৃত জমির পরিমাণ</th>
                                <th>
                                    <button type="button" class="btn btn-sm btn-primary" id="addMoujas">
                                        <icon class="fa fa-plus"></icon> Action
                                    </button>
                                </th>
                            </tr>

                            @foreach ($licenseMoujas as $key => $mouja)
                            <tr>
                                <td style="width: 10%;">
                                    {{ html()->select('mouja[' . $key . '][mouja_id]', $moujas->pluck('mouja_name', 'mouja_id'), $mouja->mouja_id)->class('form-control mouja_id')->attribute('data-target', '#record_name_' . $key)->id('mouja_id_' . $key) }}
                                </td>

                                <td style="width: 10%;">
                                    {{ html()->select('mouja[' . $key . '][record_name]', collect($records), $mouja->record_name)->class('form-control record_name')->attribute('data-target', '#ledger_id_' . $key)->attribute('data-previous', 'mouja_id_' . $key)->id('id', 'record_name_' . $key) }}
                                </td>

                                <td style="width: 10%;">
                                    <select class="form-control ledger_id" id="ledger_id_0" data-target="#plot_id_{{ $key }}" name="mouja[{{ $key }}][ledger_id]">
                                        <option disabled>খতিয়ান নম্বর</option>
                                        @forelse ($ledgers as $ledger)
                                        @if ($ledger != null)
                                        <option value="{{ $ledger->id }}" @if ($ledger && $ledger->id == $mouja->ledger_id) selected @endif>
                                            {{ $ledger->ledger_number }}
                                        </option>
                                        @endif
                                        @empty
                                        @endforelse
                                    </select>
                                </td>

                                <td style="width:20%;">
                                    @php
                                    $moujaPlot = json_decode($mouja->plot_id, true);
                                    $totalLandAmount = 0;
                                    $ledgerPlots = $plots->where('ledger_id', $mouja->ledger_id);
                                    @endphp
                                    <select class="form-control js-example-basic-single plot_id" id="plot_id_{{ $key }}" name="mouja[{{ $key }}][plot_id][]" multiple data-target="#mouja_total_amount_{{ $key }}">
                                        @foreach ($ledgerPlots as $plot)
                                        @php
                                        $totalLandAmount += $plot->land_amount;
                                        @endphp
                                        <option value="{{ $plot->plot_id }}" land-amount="{{ $plot->land_amount }}" {{ in_array($plot->plot_id, $moujaPlot) ? 'selected' : '' }}>
                                            {{ $plot->plot_number }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td style="width:10%;">
                                    <input type="text" name="mouja[{{ $key }}][property_amount]" id="mouja_total_amount_{{ $key }}" value="{{ $mouja->property_amount }}" class="form-control" />
                                </td>

                                <td style="width:10%;">
                                    <input type="text" name="mouja[{{ $key }}][leased_area]" id="leased_area_{{ $key }}" placeholder="লীজকৃত জমির পরিমাণ" value="{{ $mouja->leased_area }}" class="form-control" />
                                </td>

                                <td style="width:10%;">
                                    <a href="{{ route('admin.license_mouja.delete', $mouja) }}" type="button" data-method="delete-post" class="btn btn-outline-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            @endforeach

                        </table>
                    </div>
                </div>

                <div class="col-md-12 bg-light text-justify mt-4 mb-3">
                    <label class="mt-1">জমির নকশা</h6>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        <div class="form-group">
                            <label for="exampleFormControlInput15">নকশা নং:</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="exampleFormControlInput15" placeholder="নকশা নং" name="land_map_number" value="{{ $license->land_map_number }}" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        <div class="form-group">
                            <label for="exampleFormControlInput16">নকশার তারিখ:</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control" name="land_map_date" id="exampleFormControlInput16" value="{{ $license->land_map_date ? date('Y-m-d', strtotime($license->land_map_date)) : '' }}" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        <div class="form-group">
                            <label for="exampleFormControlInput17">চৌহদ্দি: উত্তর:</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="land_map_north" id="exampleFormControlInput17" value="{{ $license->land_map_north }}" placeholder="চৌহদ্দি: উত্তর" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 text-right">
                        <div class="form-group">
                            <label for="land_map_south">দক্ষিণ:</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="land_map_south" id="land_map_south" value="{{ $license->land_map_south }}" placeholder="দক্ষিণ" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        <div class="form-group">
                            <label for="land_map_east">পূর্ব:</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="land_map_east" id="land_map_east" value="{{ $license->land_map_east }}" placeholder="পূর্ব" />
                    </div>
                </div>

                

                <div class="row">
                    <div class="col-md-2 text-right">
                        <div class="form-group">
                            <label for="exampleFormControlInput20">পশ্চিম:</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="exampleFormControlInput20" placeholder="পশ্চিম" value="{{ $license->land_map_west }}" name="land_map_west" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        <div class="form-group">
                            <label for="exampleFormControlInput21">কি.মি: (ইংরেজিতে)</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control ledger_amount" id="exampleFormControlInput21" placeholder="কি.মি" name="land_map_kilo" value="{{ $license->land_map_kilo }}" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 text-right">
                        <div class="form-group">
                            <label for="exampleFormControlFile2">অনুমোদনের কপি:</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        @if ($license->land_map_certificate &&
                        file_exists(public_path('uploads/agriculture/' . $license->land_map_certificate)))
                        <a class="text-black" href="{{ asset('uploads/agriculture/' . $license->land_map_certificate) }}" download><i class="fa fa-file fa-3x" aria-hidden="true"></i></a>
                        @else
                        <h6><span class="badge badge-danger">no file</span></h6>
                        @endif
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
                <button type="submit" class="btn btn-lg btn-dark float-right">Update License</button>
            </div>
        </div>

    </x-slot>


</x-backend.card>

{{ html()->closeModelForm() }}

@endsection

@push('after-styles')
{{-- <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"> --}}
@endpush

@push('after-scripts')
@endpush