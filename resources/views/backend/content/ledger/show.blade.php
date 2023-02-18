@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('Ledger details'))

@php
    $required = html()
        ->span(' *')
        ->class('text-danger');
@endphp

@section('content')

    <x-backend.card>
        <x-slot name="header">
            @lang('খতিয়াণের যাবতীয় তথ্য')
        </x-slot>

        <x-slot name="headerActions">
            <a href="{{ route('admin.ledger.edit', $ledger) }}" class="btn btn-sm btn-light mr-2" data-toggle="tooltip"
                title="Edit">
                <i class="ti-pencil-alt"></i> Edit
            </a>
            <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :text="__('Cancel')" />
        </x-slot>

        <x-slot name="body">
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="col-md-12 d-flex justify-content-center">
                        <div class="col-md-6 col-sm-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="division_id" class="text-bold">বিভাগের নাম</label>
                                    </div>
                                </div>
                                <div class="col-md-1 text-right">
                                    <div class="form-group">
                                        <label for="division_id" class="text-bold">:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <span>{{ $ledger->division->division_name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="kachari_id" class="text-bold">কাচারীর নাম</label>
                                    </div>
                                </div>
                                <div class="col-md-1 text-right">
                                    <div class="form-group">
                                        <label for="kachari_id" class="text-bold">:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <span>{{ $ledger->kachari->kachari_name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="district_id" class="text-bold">জেলার নাম</label>
                                    </div>
                                </div>
                                <div class="col-md-1 text-right">
                                    <div class="form-group">
                                        <label for="district_id" class="text-bold">:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <span>{{ $ledger->district->district_name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="upazila_id" class="text-bold">উপজেলার নাম</label>
                                    </div>
                                </div>
                                <div class="col-md-1 text-right">
                                    <div class="form-group">
                                        <label for="upazila_id" class="text-bold">:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <span>{{ $ledger->upazila->upazila_name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="station_id" class="text-bold">স্টেশনের নাম</label>
                                    </div>
                                </div>
                                <div class="col-md-1 text-right">
                                    <div class="form-group">
                                        <label for="station_id" class="text-bold">:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <span>
                                            {{ $ledger->station->station_name }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mouja_id" class="text-bold">মৌজার নাম</label>
                                    </div>
                                </div>
                                <div class="col-md-1 text-right">
                                    <div class="form-group">
                                        <label for="mouja_id" class="text-bold">:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <span>{{ $ledger->mouja->mouja_name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mouja_id" class="text-bold">মোট জমির পরিমাণ</label>
                                    </div>
                                </div>
                                <div class="col-md-1 text-right">
                                    <div class="form-group">
                                        <label for="mouja_id" class="text-bold">:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <span>{{ land_amount($ledger->plot) ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mouja_id" class="text-bold">সংযুক্তি</label>
                                    </div>
                                </div>
                                <div class="col-md-1 text-right">
                                    <div class="form-group">
                                        <label for="mouja_id" class="text-bold">:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        @if ($ledger->documents && file_exists(public_path('uploads/ledger/' . $ledger->documents)))
                                            <a href="{{ asset('uploads/ledger/' . $ledger->documents) }}" download>
                                                <span class="badge badge-primary">Download</span>
                                            </a>
                                        @else
                                            <h6><span class="badge badge-danger">no file</span></h6>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="record_id" class="text-bold">রেকর্ডের নাম</label>
                                    </div>
                                </div>
                                <div class="col-md-1 text-right">
                                    <div class="form-group">
                                        <label for="record_id" class="text-bold">:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <span>{{ $ledger->record->record_name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ledger_id" class="text-bold">খতিয়ান নং</label>
                                    </div>
                                </div>
                                <div class="col-md-1 text-right">
                                    <div class="form-group">
                                        <label for="ledger_id" class="text-bold">:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <span>{{ $ledger->ledger_number ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="owner_name" class="text-bold">নাম</label>
                                    </div>
                                </div>
                                <div class="col-md-1 text-right">
                                    <div class="form-group">
                                        <label for="owner_name" class="text-bold">:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <span>{{ $ledger->owner_name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="owner_address" class="text-bold">ঠিকানা</label>
                                    </div>
                                </div>
                                <div class="col-md-1 text-right">
                                    <div class="form-group">
                                        <label for="owner_address" class="text-bold">:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <span>{{ $ledger->owner_address ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="comments" class="text-bold">মন্তব্য</label>
                                    </div>
                                </div>
                                <div class="col-md-1 text-right">
                                    <div class="form-group">
                                        <label for="comments" class="text-bold">:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <span>{{ $ledger->comments ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="division_id" class="text-bold">ডাটা এন্ট্রির অপারেটরের
                                            মন্তব্য</label>
                                    </div>
                                </div>
                                <div class="col-md-1 text-right">
                                    <div class="form-group">
                                        <label for="division_id" class="text-bold">:</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <span>{{ $ledger->comments_byDataEntry ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9 col-sm-12 ml-3">
                    <label for="" class="text-bold">দাগ সমূহঃ</label>
                    <table class="table table-bordered" id="dynamicAddRemove">
                        <input type="hidden" name="addMoreInputFields[0][ledger_id]" class="ledger_id">
                        <tr>
                            <th>নং</th>
                            <th>দাগ নাম্বার</th>
                            <th>জমির ধরণ</th>
                            <th>জমির পরিমান</th>
                            <th>মন্ততব</th>
                        </tr>

                        @forelse ($ledger->plot as $key=>$plot)
                            <tr>
                                <td>
                                    {{ $key + 1 }}
                                </td>
                                <td>
                                    {{ $plot->plot_number }}
                                </td>
                                <td>
                                    {{ $plot->landType->land_type }}
                                </td>
                                <td>
                                    {{ $plot->land_amount }}
                                </td>
                                <td>
                                    {{ $plot->land_comments }}
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </table>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-9 col-sm-12 ml-3">
                    <label for="" class="text-bold">অধিগ্রহন সমূহঃ</label>
                    <table class="table table-bordered" id="sectionDynamicAddRemove">
                        <tr>
                            <th>নং</th>
                            <th>সেকশনের নাম:</th>
                            <th>অধিগ্রহন কেস/ডিক্লারেশন</th>
                            <th>অধিগ্রহণ এর তারিখ</th>
                            <th>গেজেট এর নাম</th>
                            <th>প্রেষ্ঠা নং</th>
                            <th>গেজেট এর তারিখ</th>
                        </tr>
                        @forelse ($ledger->acquisition ?? [] as $key=>$acquisition)
                            <tr>
                                <td>
                                    {{ $key + 1 }}
                                </td>

                                <td>
                                    {{ $acquisition->section->section_name }}
                                </td>

                                <td>
                                    {{ $acquisition->acq_case }}
                                </td>

                                <td>
                                    {{ $acquisition->acq_case_date }}
                                </td>

                                <td>
                                    {{ $acquisition->gadget }}
                                </td>

                                <td>
                                    {{ $acquisition->page_no }}
                                </td>

                                <td>
                                    {{ date('f y m', strtotime($acquisition->gadget_date)) }}
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </table>
                    <br>
                    <div>
                        @if ($ledger->user)
                            {{ $ledger->user->name }}, &nbsp {{ $ledger->user->designation }}, কর্তৃক ডাটা এন্ট্রি
                        @else
                            মো:মোস্তাফিজার রাহমান, ফিল্ড কানুনগো,
                            ০১ নং কাচারী কর্তৃক আদায়কৃত
                        @endif
                    </div>
                </div>
            </div>
        </x-slot>

    </x-backend.card>


@endsection

@push('after-scripts')
@endpush
