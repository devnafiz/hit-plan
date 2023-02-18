@extends('backend.layouts.app')

@section('title', __('Update Ledger'))

@section('content')

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

<x-backend.card>
    <x-slot name="header">
        @lang('খতিয়ান, দাগ, অধিগ্রহন')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :href="route('admin.ledger.index')" :text="__('Cancel')" />
    </x-slot>

    <x-slot name="body">
        <div class="row">
            <div class="col-md-9">
                <input type="hidden" id="kachari" value="{{ route('admin.ledger.fetch-kachari') }}">
                <input type="hidden" id="district" value="{{ route('admin.ledger.fetch-district') }}">
                <input type="hidden" id="upazila" value="{{ route('admin.ledger.fetch-upazila') }}">
                <input type="hidden" id="mouza" value="{{ route('admin.ledger.fetch-mouja') }}">
                <input type="hidden" id="station" value="{{ route('admin.ledger.fetch-station') }}">
                <input type="hidden" id="land" value="{{ route('admin.ledger.land-type') }}">
                <input type="hidden" id="land_type_option" value="{{ json_encode($land_types) }}">
                <input type="hidden" id="sections" value="{{ json_encode($sections) }}">

                {{ html()->modelForm($ledger, 'PUT', route('admin.ledger.update', $ledger))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}
                <x-backend.card>
                    <div class="card-header with-border">
                        <h3 class="card-title">Manage ledger <small class="ml-2">Update ledger</small></h3>
                    </div>
                    <x-slot name="body">
                        <div class="row">
                            <h4>খতিয়ান </h4>
                        </div>
                        <hr class="mt-0">
                        <div class="col-md-12 d-flex justify-content-center">
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

                                <div class="form-group">
                                    <label for="mouja_id">মৌজার নাম:</label>
                                    {{ html()->select('mouja_id', collect($mouja))->class('form-control mouja_id')->id('mouja_id') }}
                                    <p class="text-danger error mt-2"></p>
                                </div>

                                <div class="form-group">
                                    <label for="documents">সংযুক্তি:</label>
                                    <input type="file" class="form-control-file" id="documents" name="documents" />
                                    <p class="text-danger error mt-2"></p>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="record_name">রেকর্ডের নাম:</label>
                                    {{ html()->select('record_name', collect($record))->class('form-control')->id('record_name') }}
                                    <p class="text-danger error mt-2"></p>
                                </div>

                                <div class="form-group">
                                    <label for="ledger_number">খতিয়ান নং:</label>
                                    {{ html()->text('ledger_number')->class('form-control ledger_validation')->id('ledger_number') }}
                                    <p class="text-danger error mt-2"></p>
                                </div>

                                <div class="form-group">
                                    <label for="owner_name">নাম:</label>
                                    {{ html()->text('owner_name')->class('form-control')->id('owner_name') }}
                                    <p class="text-danger error mt-2"></p>
                                </div>

                                <div class="form-group">
                                    <label for="owner_address">ঠিকানা:</label>
                                    {{ html()->textarea('owner_address')->class('form-control')->id('owner_address') }}
                                    <p class="text-danger error mt-2"></p>
                                </div>

                                <div class="form-group">
                                    <label for="comments">মন্তব্য:</label>
                                    {{ html()->text('comments')->class('form-control')->id('comments') }}
                                    <p class="text-danger error mt-2"></p>
                                </div>

                                <div class="form-group ">
                                    <input type="text" hidden class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" placeholder="" />
                                </div>

                                <div class="form-group">
                                    <label for="comments_byDataEntry">ডাটা এন্ট্রির অপারেটরের মন্তব্য:</label>
                                    {{ html()->textarea('comments_byDataEntry')->class('form-control')->id('comments_byDataEntry') }}
                                    <p class="text-danger error mt-2"></p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-lg btn-primary mr-1" type="submit">@lang('Update')</button>
                        </div>
                    </x-slot> <!--  .card-body -->

                </x-backend.card>
                {{ html()->closeModelForm() }}

                {{ html()->modelForm($ledger, 'PUT', route('admin.plot.update', $ledger))->class('form-horizontal plot-form')->attribute('enctype', 'multipart/form-data')->open() }}
                <input type="hidden" name="land-type" value="{{ route('admin.ledger.land-type') }}">
                <x-backend.card>
                    <div class="card-header with-border">
                        <h3 class="card-title">Manage ledger <small class="ml-2">Update ledger</small>
                        </h3>
                    </div>
                    <x-slot name="body">
                        <div class="col-md-12 d-flex justify-content-between">
                            <h4>দাগ </h4>
                            <div class="form-group">
                                <a name="add" data-key="" class="update_dynamic_plot text-blue" style="cursor: pointer;">+ Add new</a>
                            </div>
                        </div>
                        <hr class="mt-0">
                        <div class="col-md-12 d-flex justify-content-center">
                            <table class="table table-bordered" id="dynamicAddRemove">
                                <input type="hidden" class="form-route" name="ledger_id" value="{{ $ledger->id }}">
                                <tr>
                                    <th>দাগ নাম্বার</th>
                                    <th>জমির ধরণ</th>
                                    <th>জমির পরিমান</th>
                                    <th>মন্ততব</th>
                                    <th action></th>
                                </tr>
                                @foreach ($ledger->plot as $key => $plot)
                                <tr id="repeater_container_{{ $key }}" data-key="{{ $key }}" data-id="{{ $plot->plot_id }}">

                                    <input type="hidden" name="addMoreInputFields[{{ $key }}][plot_id]" value="{{ $plot->plot_id }}">

                                    <td>
                                        {{ html()->text('addMoreInputFields[' . $key . '][plot_number]', $plot->plot_number)->class('form-control')->id('addMoreInputFields[' . $key . '][plot_number]') }}
                                    </td>

                                    <td>
                                        {{ html()->select('addMoreInputFields[' . $key . '][land_type]', collect($land_type), $plot->land_type)->class('form-control land_type_section')->id('addMoreInputFields[' . $key . '][land_type]') }}
                                    </td>

                                    <td>
                                        {{ html()->text('addMoreInputFields[' . $key . '][land_amount]', $plot->land_amount)->class('form-control ledger_amount')->id('addMoreInputFields[' . $key . '][land_amount]') }}
                                    </td>

                                    <td>
                                        {{ html()->text('addMoreInputFields[' . $key . '][land_comments]', $plot->land_comments)->class('form-control')->id('addMoreInputFields[' . $key . '][land_comments]') }}
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.plot.destroy', $plot->plot_id) }}" type="button" data-method="delete" class="btn btn-outline-danger">-</a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-lg btn-primary mr-1" type="submit">@lang('Update')</button>
                        </div>
                    </x-slot> <!--  .card-body -->
                </x-backend.card>
                {{ html()->closeModelForm() }}

                {{ html()->modelForm($acquisitions, 'PUT', route('admin.acquisition.update', $id))->class('form-horizontal acq-form')->attribute('enctype', 'multipart/form-data')->open() }}
                <x-backend.card>
                    <div class="card-header with-border">
                        <h3 class="card-title">Manage Acquisition <small class="ml-2">Update
                                acquisition</small>
                        </h3>
                    </div>
                    <x-slot name="body">
                        <div class="col-md-12 d-flex justify-content-between">
                            <h4>অধিগ্রহন </h4>
                            <div class="form-group">
                                <a name="add" data-key="" class="dynamic-section text-blue" style="cursor: pointer;">+
                                    Add new</a>
                            </div>
                        </div>
                        <hr class="mt-0">
                        <div class="col-md-12 d-flex justify-content-center">
                            <input type="hidden" class="form-route ledger_id" name="ledger_id" value="{{ $ledger->id }}">
                            <table class="table table-bordered" id="sectionDynamicAddRemove">
                                <tr>
                                    <th>সেকশনের নাম:</th>
                                    <th>অধিগ্রহন কেস/ডিক্লারেশন</th>
                                    <th>অধিগ্রহণ এর তারিখ</th>
                                    <th>গেজেট এর নাম</th>
                                    <th>প্রেষ্ঠা নং</th>
                                    <th>গেজেট এর তারিখ</th>
                                    <th action></th>
                                </tr>
                                @forelse ($acquisitions ?? [] as $key => $acquisition)
                                <input type="hidden" value="{{ $acquisitions->count() }}" class="key_no">
                                <tr class="repeater_container" data-key="{{ $key }}" data-id="{{ $acquisition->id }}">
                                    <input type="hidden" name="addMoreInputFields[{{ $key }}][id]" value="{{ $acquisition->id }}">
                                    <td>
                                        {{ html()->select('addMoreInputFields[' . $key . '][section_id]', collect($section), $acquisition->section_id)->class('form-control section') }}
                                    </td>

                                    <td>
                                        {{ html()->text('addMoreInputFields[' . $key . '][acq_case]', $acquisition->acq_case)->class('form-control')->id('addMoreInputFields[' . $key . '][acq_case]') }}
                                    </td>

                                    <td>
                                        {{ html()->date('addMoreInputFields[' . $key . '][acq_case_date]', $acquisition->acq_case_date)->class('form-control')->id('addMoreInputFields[' . $key . '][acq_case_date]') }}
                                    </td>

                                    <td>
                                        {{ html()->text('addMoreInputFields[' . $key . '][gadget]', $acquisition->gadget)->class('form-control')->id('addMoreInputFields[' . $key . '][gadget]') }}
                                    </td>

                                    <td>
                                        {{ html()->text('addMoreInputFields[' . $key . '][page_no]', $acquisition->page_no)->class('form-control page_no')->id('addMoreInputFields[' . $key . '][page_no]') }}
                                    </td>

                                    <td>
                                        {{ html()->date('addMoreInputFields[' . $key . '][gadget_date]', $acquisition->gadget_date)->class('form-control')->id('addMoreInputFields[' . $key . '][gadget_date]') }}
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.acquisition.destroy', $acquisition->id) }}" type="button" data-method="delete" class="btn btn-outline-danger">-</a>
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                            </table>

                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-lg btn-primary mr-1" type="submit">@lang('Update')</button>
                        </div>
                    </x-slot> <!--  .card-body -->
                </x-backend.card>
                {{ html()->closeModelForm() }}

            </div> <!-- .col-md-9 -->

            <div class="col-sm-3">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title">সংযুক্তি</h3>
                    </div>
                    <div class="card-body p-3">
                        <div class="form-group" id="for_New_upload">
                            @php
                            'img/backend/no-image.gif';
                            @endphp

                            {{ html()->file('documents')->id('documents')->class('d-none')->acceptImage() }}
                        </div> <!-- form-group -->
                        <div class="attached-group attached-group d-inline mb-2 mr-2">
                            @if ($ledger->documents && file_exists(public_path('uploads/ledger/' . $ledger->documents)))
                            <label class="text-muted">
                                <a href="{{ asset('uploads/ledger/' . $ledger->documents) }}" download>
                                    <i class="fas fa-3x fa-file-pdf"></i>
                                    <?php $value = pathinfo($ledger->documents, PATHINFO_EXTENSION); ?>
                                    <p>{{ 'সংযুক্তি', '.' . $value }}</p>
                                </a>
                            </label>
                            @else
                            <span>No file Uploaded</span>
                            @endif
                        </div>
                    </div> <!--  card-body -->
                </div> <!-- /.card -->
            </div> <!-- .col-md-3 -->
        </div> <!-- .row -->
    </x-slot>

</x-backend.card>

@endsection