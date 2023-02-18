@extends('backend.layouts.app')

@section('title', __('কৃষি লাইসেন্স সংশোধন '))

@section('content')

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

{{ html()->modelForm($result, 'PUT', route('admin.agriculture.update', $result))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}
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
        <input type="hidden" id="mouza" value="{{ route('admin.ledger.fetch-mouja') }}">
        <input type="hidden" id="station" value="{{ route('admin.ledger.fetch-station') }}">
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
                @foreach ($result->owner as $key => $owner)
                <div class="row" id="license_owner_repeat_item_0">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="owner_name_0">আবেদনকারীর নাম</label>
                            <input type="text" id="owner_name_{{ $key }}" class="form-control" value="{{ $owner->name }}" name="owner[{{ $key }}][name]" placeholder="আবেদনকারীর নাম" />
                        </div>

                        @if ($owner->father_name)
                        <div class="form-group">
                            <label for="father_name_{{ $key }}">পিতার নাম</label>
                            <input type="text" id="father_name_{{ $key }}" class="form-control" name="owner[{{ $key }}][father_name]" value="{{ $owner->father_name }}" placeholder="পিতার নাম" />
                        </div>
                        @endif

                        @if ($owner->husband_name)
                        <div class="form-group">
                            <label for="husband_name_{{ $key }}">স্বামীর নাম</label>
                            <input type="text" id="husband_name_{{ $key }}" class="form-control" name="owner[{{ $key }}][husband_name]" value="{{ $owner->husband_name }}" placeholder="স্বামীর নাম" />
                        </div>
                        @endif
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
                            <label for="address_0">ঠিকানা</label>
                            <textarea name="owner[{{ $key }}][address]" id="address_{{ $key }}" class="form-control" cols="30" rows="5" placeholder="আবেদনকারীর পূর্ণ ঠিকানা" value="{{ $owner->address }}">{{ $owner->address }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-2 mt-4">
                        <button type="button" id="license-owner" class="btn btn-primary">Add more</button>
                    </div>

                    <div class="row col-12">
                        <div class="col-md-3">
                            <div class="form-group" id="for_New_upload">
                                @php
                                $image = $owner->photo ? $owner->photo : 'img/backend/no-image.gif';
                                @endphp
                                <label for="image">
                                    <img src="{{ asset($image) }}" class="img-fluid" id="holder" alt="Image upload">
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
                    <label class="mt-1">খতিয়ান ও দাগ সম্পর্কিত তথ্য</h6>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="demand_notice_number">ডিমান্ড নোটিশের নং:</label>
                            <input type="text" class="form-control" name="demand_notice_number" maxlength="11" id="demand_notice_number" placeholder="ডিমান্ড নোটিশের নং" value="{{ $result->demand_notice_number }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="demand_notice_date">ডিমান্ড নোটিশের তারিখ:</label>
                            <input type="date" class="form-control" value="{{ $result->demand_notice_date }}" name="demand_notice_date" id="demand_notice_date">
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
                                <th><button type="button" class="btn btn-sm btn-primary" id="addMoujas">
                                        <icon class="fa fa-plus"></icon> Action
                                    </button>
                                </th>
                            </tr>
                            @foreach ($licenseMoujas as $key => $mouja)
                            <tr>
                                <td>
                                    <select class="form-control mouja_id" data-target="#record_name_{{ $key }}" name="mouja[{{ $key }}][mouja_id]" required>
                                        <option selected disabled>মৌজা বাছাই করুন</option>
                                        @foreach ($moujas as $mouja_value)
                                        <option value="{{ $mouja_value->mouja_id }}" @if ($mouja_value->mouja_id == $mouja->mouja_id) selected @endif>
                                            {{ $mouja_value->mouja_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <select class="form-control record_name" id="record_name_{{ $key }}" data-target="#ledger_id_{{ $key }}" name="mouja[{{ $key }}][record_name]" required>
                                        <option selected disabled>রেকর্ড বাছাই করুন</option>
                                        @foreach ($record as $record_value)
                                        <option value="{{ $record_value->id }}" @if ($record_value->id == $mouja->record_name) selected @endif>
                                            {{ $record_value->record_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <select class="form-control ledger_id" id="ledger_id_{{ $key }}" data-target="#plot_id_{{ $key }}" name="mouja[{{ $key }}][ledger_id]" required>
                                        <option selected disabled>খতিয়ান নম্বর</option>
                                        @foreach ($ledgers as $ledger_value)
                                        <option value="{{ $ledger_value->id }}" @if ($ledger_value->id == $mouja->ledger_id) selected @endif>
                                            {{ $ledger_value->ledger_number }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <?php
                                    $moujaPlot = json_decode($mouja->plot_id, true);
                                    ?>
                                    <select class="form-control js-example-basic-single plot_id" id="plot_id_{{ $key }}" name="mouja[{{ $key }}][plot_id][]" multiple="multiple" data-target="#mouja_total_amount_{{ $key }}" required>
                                        <option selected disabled>দাগ নম্বর</option>
                                        @foreach ($plots as $key => $plot)
                                        <option value="{{ $plot->plot_id }}" {{ in_array($plot->plot_id, $moujaPlot) ? 'selected' : '' }}>
                                            {{ $plot->plot_number }}
                                        </option>
                                        @endforeach
                                    </select>

                                <td>
                                    <input type="text" name="mouja[{{ $key }}][property_amount]" id="mouja_total_amount_0" value="{{ $mouja->property_amount }}" class="form-control" maxlength="11" required />
                                </td>
                                <td>
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
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="exampleFormControlInput15">নকশা নং:</label>
                            <input type="text" class="form-control" id="exampleFormControlInput15" placeholder="নকশা নং" name="land_map_number" value="{{ $result->plans->land_map_number }}" maxlength="11" />
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput21">কি.মি:</label>
                            <input type="text" class="form-control ledger_amount" id="exampleFormControlInput21" placeholder="কি.মি" name="land_map_area" value="{{ $result->plans->land_map_area }}" maxlength="11" />
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput20">পশ্চিম:</label>
                            <input type="text" class="form-control" id="exampleFormControlInput20" placeholder="পশ্চিম" value="{{ $result->plans->land_map_sides }}" name="land_map_sides" />
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <label for="exampleFormControlInput16">নকশার তারিখ:</label>
                            <input type="date" class="form-control" name="land_map_date" id="exampleFormControlInput16" value="{{ date('Y-m-d', strtotime($result->plans->land_map_date)) }}" />
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput17">চৌহদ্দি: উত্তর:</label>
                            <input type="text" class="form-control" name="land_map_west_north" id="exampleFormControlInput17" value="{{ $result->plans->land_map_west_north }}" />
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile2">অনুমোদনের কপি আপলোড করুন: </label>
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