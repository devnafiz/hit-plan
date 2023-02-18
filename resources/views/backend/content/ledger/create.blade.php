@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('Register new patient'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('নতুন খতিয়ানের তথ্য যুক্ত করুন')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :text="__('Cancel')" :href="route('admin.ledger.index')" />
    </x-slot>

    <x-slot name="body">
        <div class="pageLoader" id="pageLoader"></div>
        <input type="hidden" id="kachari" value="{{ route('admin.ledger.fetch-kachari') }}">
        <input type="hidden" id="district" value="{{ route('admin.ledger.fetch-district') }}">
        <input type="hidden" id="upazila" value="{{ route('admin.ledger.fetch-upazila') }}">
        <input type="hidden" id="mouza" value="{{ route('admin.ledger.fetch-mouja') }}">
        <input type="hidden" id="station" value="{{ route('admin.ledger.fetch-station') }}">
        <input type="hidden" id="land" value="{{ route('admin.ledger.land-type') }}">
        <input type="hidden" id="land_type_option" value="{{ json_encode($land_type) }}">
        <input type="hidden" id="record" value="{{ route('admin.ledger.fetch-record') }}">
        <input type="hidden" id="ledger" value="{{ route('admin.ledger.fetch-ledger') }}">


        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs" id="nav-tab" role="tablist">
                    <li class="nav-link ledger-tab active" id="ledger-tab" aria-selected="true">খতিয়ানের তথ্য</li>

                    <li class="nav-link plot-tab" id="plot-tab" type="button" role="tab" aria-selected="false">দাগের
                        তথ্য
                    </li>

                    <li class="nav-link aqusition-tab" id="aqusition-tab" data-bs-toggle="tab" aria-selected="false">
                        অধিগ্রহণের
                        তথ্য
                    </li>
                </ul>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="tab-content" id="tab-content">
                    <div class="tab-pane ledger-tab active" role="tabpanel" id="ledger">
                        {{ html()->form('POST')->id('ledgerForm')->attribute('enctype', 'multipart/form-data')->attribute('next', 'plot-tab')->open() }}
                        <input type="hidden" class="form-route" value="{{ route('admin.ledger.store') }}">
                        <div class="col-md-10 d-flex justify-content-center">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="division_id">বিভাগের নাম:</label>
                                    <select required id="division_id" class="form-control" name="division_id">
                                        <option value="" disabled selected>বাছাই করুন</option>
                                        @foreach ($division as $divisions_name)
                                        <option value="{{ $divisions_name->division_id }}">
                                            {{ $divisions_name->division_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="kachari_id">কাচারীর নাম:</label>
                                    <select required id="kachari_id" class="form-control" name="kachari_id">
                                        <option selected disabled>কাচারী বাছাই করুন</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="district_id">জেলার নাম:</label>
                                    <select required class="form-control" id="district_id" name="district_id">
                                        <option selected disabled>জেলা বাছাই করুন</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="upazila_id">উপজেলার নাম:</label>
                                    <select required class="form-control" id="upazila_id" name="upazila_id">
                                        <option selected disabled>উপজেলা বাছাই করুন</option>
                                    </select>

                                </div>

                                <div class="form-group">
                                    <label for="station_id">স্টেশনের নাম:</label>
                                    <select required class="form-control" id="station_id" name="station_id" required>
                                        <option selected disabled>স্টেশন বাছাই করুন</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="mouja_id">মৌজার নাম:</label>
                                    <select class="form-control mouja_id" id="mouja_id" name="mouja_id" required>
                                        <option selected disabled>মৌজা বাছাই করুন</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="documents">সংযুক্তি:</label>
                                    <input type="file" class="form-control-file" id="documents" name="documents" />
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="record_name">রেকর্ডের নাম:</label>
                                    <select class="form-control record_name" id="record_name" name="record_name" required>
                                        <option selected disabled>রেকর্ড বাছাই করুন</option>
                                        @foreach ($record as $record_name)
                                        <option value="{{ $record_name->id }}">
                                            {{ $record_name->record_name }}
                                        </option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="form-group">
                                    <label for="ledger_number">খতিয়ান নং:</label>
                                    <input type="text" class="form-control ledger_validation" id="ledger_number" name="ledger_number" placeholder="" required />
                                    <small class="error-input-value"></small>
                                </div>

                                <div class="form-group">
                                    <label for="owner_name">নাম:</label>
                                    <input class="form-control" id="owner_name" name="owner_name" rows="3" placeholder="" required />

                                </div>

                                <div class="form-group">
                                    <label for="owner_address">ঠিকানা:</label>
                                    <textarea class="form-control" id="owner_address" name="owner_address" placeholder=""></textarea>

                                </div>

                                <div class="form-group">
                                    <label for="comments">মন্তব্য:</label>
                                    <input type="text" class="form-control" id="comments" name="comments" placeholder="" />
                                </div>

                                <div class="form-group ">
                                    <input type="text" hidden class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" placeholder="" />
                                </div>

                                <div class="form-group">
                                    <label for="comments_byDataEntry">ডাটা এন্ট্রির অপারেটরের মন্তব্য:</label>
                                    <textarea class="form-control" id="comments_byDataEntry" name="comments_byDataEntry" placeholder=""></textarea>
                                </div>
                            </div>
                        </div>
                        {{ html()->form()->close() }}
                    </div>

                    <div class="tab-pane plot-tab" role="tabpanel" id="plot">
                        {{ html()->form('POST')->id('plotForm')->attribute('enctype', 'multipart/form-data')->attribute('next', 'aqusition-tab')->open() }}
                        <input type="hidden" class="form-route" value="{{ route('admin.plot.store') }}">

                        <div class="col-md-10">
                            <table class="table table-bordered" id="dynamicAddRemove">
                                <input type="hidden" name="addMoreInputFields[0][ledger_id]" class="ledger_id">
                                <tr>
                                    <th>দাগ নম্বর</th>
                                    <th>জমির ধরণ</th>
                                    <th>জমির পরিমান</th>
                                    <th>মন্তব্য</th>
                                    <th action></th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" id="addMoreInputFields[0][plot_number]" name="addMoreInputFields[0][plot_number]" placeholder="দাগ নম্বর" class="form-control" />
                                    </td>
                                    <td>
                                        <select class="form-control plot-type" id="addMoreInputFields[0][land_type]" name="addMoreInputFields[0][land_type]">
                                            <option value="" disabled selected>জমির ধরণ বাছাই করুন</option>
                                            @foreach ($land_type as $land)
                                            <option value="{{ $land->land_type_id }}">{{ $land->land_type }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" id="addMoreInputFields[0][land_amount]" name="addMoreInputFields[0][land_amount]" placeholder="জমির পরিমান" class="form-control ledger_amount" />
                                    </td>
                                    <td>
                                        <input type="text" id="addMoreInputFields[0][land_comments]" name="addMoreInputFields[0][land_comments]" placeholder="মন্তব্য" class="form-control" />
                                    </td>
                                    <td>
                                        <button type="button" name="add" class="btn btn-outline-primary update_dynamic_plot">+</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        {{ html()->form()->close() }}
                    </div>

                    <div class="tab-pane aqusition-tab" role="tabpanel" id="aqusition">
                        {{ html()->form('POST')->id('aqusition')->attribute('enctype', 'multipart/form-data')->attribute('next', 'finish')->open() }}
                        <input type="hidden" class="form-route" value="{{ route('admin.acquisition.store') }}">
                        <div class="col-12">
                            <table class="table table-bordered" id="sectionDynamicAddRemove">
                                <tr>
                                    <th>সেকশনের নাম:</th>
                                    <th>অধিগ্রহণ কেস/ডিক্লারেশন</th>
                                    <th>অধিগ্রহণ এর তারিখ</th>
                                    <th>গেজেট এর নাম</th>
                                    <th>পৃষ্ঠা নং</th>
                                    <th>গেজেট এর তারিখ</th>
                                    <th action></th>
                                </tr>
                                <tr>
                                    <td>
                                        <select class="form-control section" name="addMoreInputFields[0][section_id]" id="addMoreInputFields[0][section_id]">
                                            <option value="" disabled selected>সেকশনের নাম:</option>
                                            @foreach ($section as $section_val)
                                            <option value="{{ $section_val->section_id }}">
                                                {{ $section_val->section_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <input type="hidden" name="addMoreInputFields[0][ledger_id]" class="ledger_id" value="">
                                    <td>
                                        <input type="text" name="addMoreInputFields[0][acq_case]" placeholder="Enter case number" class="form-control" />
                                    </td>

                                    <td>
                                        <input type="date" name="addMoreInputFields[0][acq_case_date]" placeholder="Enter case date" class="form-control" />
                                    </td>

                                    <td>
                                        <input type="text" name="addMoreInputFields[0][gadget]" placeholder="Enter gadget name" class="form-control" />
                                    </td>

                                    <td>
                                        <input type="text" name="addMoreInputFields[0][page_no]" placeholder="Enter page no" class="form-control page_no" />
                                    </td>

                                    <td>
                                        <input type="date" name="addMoreInputFields[0][gadget_date]" placeholder="Enter gadget name" class="form-control" />
                                    </td>

                                    <td><button type="button" name="add" id="dynamic-section" class="btn btn-outline-primary">+</button>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        {{ html()->form()->close() }}

                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-4">
                <x-slot name="footer">
                    <button class="btn btn-lg btn-primary float-right" id="ledger-button">@lang('Save
                        & Next')</button>
                </x-slot>
            </div> <!-- .col-md-9 -->
        </div> <!-- .row -->

    </x-slot>

</x-backend.card>


@endsection

@push('after-scripts')
@endpush