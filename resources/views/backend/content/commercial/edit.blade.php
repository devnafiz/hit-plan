@extends('backend.layouts.app')

@section('title', __('লাইসেন্স সংশোধন '))

@section('content')

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

{{ html()->modelForm($result, 'PUT', route('admin.commercial.update', $result))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}
<x-backend.card>
    <x-slot name="header">
        @lang('তথ্য সংশোধন ')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :href="route('admin.commercial.index')" :text="__('Cancel')" />
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
        <input type="hidden" id="plot" value="{{ route('admin.ledger.fetch-plot') }}">
        <input type="hidden" id="masterplan" value="{{ route('admin.ledger.fetch-masterplan') }}">
        <input type="hidden" id="masterplanplot" value="{{ route('admin.ledger.fetch-masterplan-plot') }}">

        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 bg-light text-justify mb-3">
                    <label class="mt-1">লাইসেন্সীর তথ্য</h6>
                </div>
                @foreach ($result->commercialOwner as $key => $owner)
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
                                    <option value="">Day</option>
                                    @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}" @if ($last_from_day==$i) selected @endif>{{ $i }}
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
                                    @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}" @if ($last_from_month==$i) selected @endif>
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
                                    @for ($i = date('Y', strtotime('+5 years')); $i >= 1893; $i--)
                                    <option value="{{ $i }}" @if ($last_from_year==$i) selected @endif>
                                        {{ $i }}
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
                                    @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}" @if ($last_to_day==$i) selected @endif>{{ $i }}
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
                                    @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}" @if ($last_to_month==$i) selected @endif>
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
                                    <option value="">বসর</option>
                                    @for ($i = date('Y', strtotime('+5 years')); $i >= 1893; $i--)
                                    <option value="{{ $i }}" @if ($last_to_year==$i) selected @endif>
                                        {{ $i }}
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
                            <input type="text" class="form-control" value="{{ $result->demand_notice_number }}" name="demand_notice_number" id="demand_notice_number" placeholder="ডিমান্ড নোটিশের নং">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="demand_notice_date">ডিমান্ড নোটিশের তারিখ:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime($result->demand_notice_date)) }}" name="demand_notice_date" id="demand_notice_date">
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
                        {{ html()->select('division_id', collect($division))->class('form-control')->id('division_id') }}
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
                        {{ html()->select('kachari_id', collect($kachari))->class('form-control')->id('kachari_id') }}
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
                        {{ html()->select('district_id', collect($district))->class('form-control')->id('district_id') }}
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
                        {{ html()->select('upazila_id', collect($upazila))->class('form-control')->id('upazila_id') }}
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
                        {{ html()->select('station_id', collect($station))->class('form-control')->attribute('data-key', 'masterplan')->attribute('data-target', '#masterplan_id_0')->id('station_id') }}
                        @if ($errors->has('station_id'))
                        <p class="text-danger">
                            <small>{{ $errors->first('station_id') }}</small>
                        </p>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <button type="button" name="add2" id="addComMoujas" class="btn btn-primary float-right" data-key="{{ count($licenseMoujas) }}">Add
                                    more</button>
                            </div>
                        </div>
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

                            @forelse ($licenseMoujas as $key => $mouja)
                            <tr>
                                <input type="hidden" name="mouja[{{ $key }}][masterPlanMouja]" value="{{ $mouja->id }}">
                                <input type="hidden" name="mouja[{{ $key }}][license_id]" value="{{ $result->id }}">
                                <td style="width: 20%;">
                                    {{ html()->select('mouja[' . $key . '][masterplan_id]', collect($masterplan), $mouja->masterplan_id)->class('form-control masterplan_no')->attribute('#plot_id_' . $key)->attribute('data-target', '#plot_id_' . $key)->id('masterplan_id_' . $key) }}
                                </td>

                                <td style="width: 30%;">
                                    <?php
                                    $moujaPlot = json_decode($mouja->plot_id, true);
                                    $totalLandAmount = 0;
                                    ?>
                                    <select class="form-control js-example-basic-single plot_id" id="plot_id_{{ $key }}" name="mouja[{{ $key }}][plot_id][]" data-target="#mouja_total_amount_{{ $key }}" multiple>
                                        {{-- <option selected disabled>দাগ নম্বর</option> --}}
                                        @foreach ($plots as $plot)
                                        @php
                                        $totalLandAmount += $plot->plot_size;
                                        @endphp
                                        <option value="{{ $plot->id }}" land-amount="{{ $plot->plot_size }}" {{ in_array($plot->id, $moujaPlot) ? 'selected' : '' }}>
                                            {{ $plot->plot_number }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <input type="test" class="form-control mr-1" name="mouja[{{ $key }}][plot_length]" id="plot_length_{{ $key }}" value="{{ $mouja->plot_length }}" data-target="#total_sft_{{ $key }}" data-target2="#plot_size_{{ $key }}" placeholder="প্লটের সাইজ(দৈর্ঘ্য)" data-height="#plot_width_{{ $key }}">
                                </td>
                                <td>
                                    <input type="test" class="form-control" name="mouja[{{ $key }}][plot_width]" id="plot_width_{{ $key }}" value="{{ $mouja->plot_width }}" placeholder="প্লটের সাইজ(প্রস্থ)" data-target="#total_sft_{{ $key }}" data-target2="#plot_size_{{ $key }}" data-height="#plot_length_{{ $key }}">
                                </td>

                                <td style="width: 20%;">
                                    <input type="text" name="mouja[{{ $key }}][property_amount]" id="mouja_total_amount_{{ $key }}" value="{{ $mouja->property_amount }}" placeholder="দাগে জমির পরিমাণ" class="form-control" />
                                </td>

                                <td style="width: 20%;">
                                    <input type="text" name="mouja[{{ $key }}][leased_area]" id="leased_area_{{ $key }}" value="{{ $mouja->leased_area }}" placeholder="লীজকৃত জমির পরিমাণ" class="form-control" />
                                </td>

                                <td style="width: 10%;">
                                    <a href="{{ route('admin.commercial_mouja.delete', $mouja->id) }}" type="button" data-method="delete-post" class="btn btn-outline-danger"><i class="fa fa-trash" data-method="delete-post" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            @empty
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
                            @endforelse
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
                            <input type="text" class="form-control" name="land_map_north" id="exampleFormControlInput17" value="{{ $result->land_map_north }}" placeholder="চৌহদ্দি: উত্তর" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="land_map_east">পূর্ব:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="land_map_east" id="land_map_east" value="{{ $result->land_map_east }}" placeholder="পূর্ব" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="land_map_south">দক্ষিণ:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="land_map_south" id="land_map_south" value="{{ $result->land_map_south }}" placeholder="দক্ষিণ" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="exampleFormControlInput20">পশ্চিম:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="exampleFormControlInput20" placeholder="পশ্চিম" value="{{ $result->land_map_west }}" name="land_map_west" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="exampleFormControlFile2">অনুমোদনের কপি:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            @if ($result->land_map_certificate &&
                            file_exists(public_path('uploads/commercial/' . $result->land_map_certificate)))
                            <a class="text-black" href="{{ asset('uploads/commercial/' . $result->land_map_certificate) }}" download><i class="fa fa-file fa-3x" aria-hidden="true"></i></a>
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
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-lg btn-dark float-right">Save New License</button>
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