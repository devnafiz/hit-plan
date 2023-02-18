@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('লাইসেন্স সংক্রান্ত তথ্য'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('লাইসেন্স সংক্রান্ত তথ্য')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :href="route('admin.commercial-fees.index')" :text="__('Cancel')" />
    </x-slot>

    <x-slot name="body">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="col-md-12 bg-light text-justify mb-3">
                    <label class="mt-1">লাইসেন্স সংক্রান্ত তথ্য</h6>
                </div>
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <div class="card">
                            <div class="card-body" id="license_owner_info">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        @foreach ($license_owner as $owner)
                                        <h5>লাইসেন্সীর তথ্য</h5>
                                        <div class="mb-3">
                                            <table class="text-center table-striped license_details_table">
                                                <tbody>
                                                    <tr>
                                                        <th>লাইসেন্সীর ছবি</th>
                                                        <td>
                                                            @if (file_exists(asset($owner->photo)))
                                                            <img src="{{ asset($owner->photo) }}" alt="img" style="max-width: 80px;">
                                                            @else
                                                            <img src="{{ asset('images/no-file.png') }}" alt="img" style="max-width: 80px;">
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>লাইসেন্সের নং</th>
                                                        <td>{{ $license->generated_id }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>লাইসেন্সীর নাম</th>
                                                        <td>{{ $owner->name ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        @if ($owner->father_name)
                                                        <th>পিতার নাম</th>
                                                        <td>{{ $owner->father_name ?? 'N/A' }}</td>
                                                        @endif
                                                        @if ($owner->husband_name)
                                                        <th>স্বামীর নাম</th>
                                                        <td>{{ $owner->husband_name ?? 'N/A' }}</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th>মোবাইল নং</th>
                                                        <td>{{ $owner->phone ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>ঠিকানা</th>
                                                        <td>{{ $owner->address ?? 'N/A' }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>জাতীয় পরিচয়পত্র নং</th>
                                                        <td>{{ $owner->nid }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>কাচারী নং</th>
                                                        <td>{{ $license->kachari->kachari_name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>জেলা</th>
                                                        <td>{{ $license->district->district_name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>উপজেলা</th>
                                                        <td>{{ $license->upazila->upazila_name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>স্টেশন</th>
                                                        <td>{{ $license->station->station_name }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <h5>লাইসেন্স ফি’র তথ্য</h5>
                                        <div class="table-responsive-sm table-striped">
                                            <table class="text-center license_details_table">
                                                <tbody>
                                                    <tr>
                                                        <th>জমির তফসিল</th>
                                                        <td>
                                                            <?php $license_moujas = commercial_license_moujas($license->commercialMoujas); ?>
                                                            <strong>মৌজা:
                                                            </strong>{{ $license_moujas['moujas'] ?? 'N/A' }}
                                                            <strong>রেকর্ড:
                                                            </strong>{{ $license_moujas['records'] ?? 'N/A' }}
                                                            <strong>দাগ:
                                                            </strong>{{ $license_moujas['masterplan_plots'] ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>জমির পরিমাণ</th>
                                                        <td>{{ $license_moujas['property_amount'] . ' একর' ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>লীজকৃত জমি</th>
                                                        <td>{{ $license_moujas['leased_area'] . ' বর্গফুট' ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>মাস্টারপ্ল্যান নং</th>
                                                        <td>{{ $license_moujas['masterplan_no'] ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>মাস্টারপ্ল্যানের প্লট নং</th>
                                                        <td>{{ $license_moujas['masterplan_plots'] ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>ডিমান্ড নোটিশ নং</th>
                                                        <td>{{ $license->demand_notice_number ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>ডিমান্ড নোটিশের তারিখ</th>
                                                        <td>{{ date('F j, Y', strtotime($license->demand_notice_date)) ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>চৌহদ্দি উত্তর</th>
                                                        <td>{{ $license->land_map_north ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>পূর্ব</th>
                                                        <td>{{ $license->land_map_east ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>দক্ষিণ</th>
                                                        <td>{{ $license->land_map_south ?? 'N/A' }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>পশ্চিম</th>
                                                        <td>{{ $license->land_map_west ?? 'N/A' }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>লাইসেন্স অনুমোদনের কপি</th>
                                                        <td>
                                                            @if ($license->land_map_certificate &&
                                                            file_exists(public_path('uploads/commercial/' . $license->land_map_certificate)))
                                                            <a href="{{ asset('uploads/commercial/' . $license->land_map_certificate) }}" download>
                                                                <span class="badge badge-primary">Download</span>
                                                            </a>
                                                            @else
                                                            <h6><span class="badge badge-danger">no file</span>
                                                            </h6>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">

                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>হিসাবের উদাহরণ</h5>
                                @php
                                $all_moujas = $balam->commercialLicense->commercialMoujas;
                                $total = 0;
                                foreach ($all_moujas as $mouja) {
                                $total += $mouja->leased_area;
                                }
                                @endphp
                                <p>
                                    জমির পরিমান: {{ number_format($total, 4) }} একর
                                    <br>
                                    মোট: {{ number_format($balam->license_fee, 2) }}/-
                                    <br>
                                    ভ্যাট: {{ number_format($balam->vat, 2) }}/-
                                    <br>
                                    ট্যাক্স: {{ number_format($balam->tax, 2) }}/-
                                    <br><br>
                                    মোট ফি: {{ number_format($balam->total_fee, 2) }}/-
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5>বিভিন্ন ফি’র তথ্য</h5>
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <th>
                                        <label for="license_fee">লাইসেন্স ফি</label>
                                    </th>
                                    <td>
                                        {{ $balam->license_fee ?? '' }}/-
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="license_vat">ভ্যাট</label>
                                    </th>
                                    <td>
                                        {{ $balam->vat ?? '' }}/-
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="license_tax">উৎসে কর</label>
                                    </th>
                                    <td>
                                        {{ $balam->tax ?? '' }}/-
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="license_fines">জরিমানা</label>
                                    </th>
                                    <td>
                                        {{ $balam->fine ?? '' }}/-
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="license_security">লাইসেন্সের সিকিউরিটি</label>
                                    </th>
                                    <td>
                                        {{ $balam->security ?? '' }}/-
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="license_plan_fee">লাইসেন্সের প্ল্যান ফি</label>
                                    </th>
                                    <td>
                                        {{ $balam->plan_fee ?? '' }}/-
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="license_application_fee">লাইসেন্সের আবেদন ফি</label>
                                    </th>
                                    <td>
                                        {{ $balam->application_fee ?? '' }}/-
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="license_renew_fee">লাইসেন্সের নবায়ন ফি</label>
                                    </th>
                                    <td>
                                        {{ $balam->mutation_fee ?? '' }}/-
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="license_naming_fee">লাইসেন্সের নামজারী ফি</label>
                                    </th>
                                    <td>
                                        {{ $balam->naming ?? '' }}/-
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="license_total_amount"><strong>মোট</strong></label>
                                    </th>
                                    <td>
                                        {{ $balam->total_fee ?? '' }}/-
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5>‘এ চালান’ সংক্রান্ত তথ্য</h5>
                        @foreach ($balam->dd as $key => $dd)
                        <table class="license_details_table_2">
                            <tbody>
                                <tr>
                                    <th>
                                        <label for="license_fee_ddn_no_{{ $key }}">লাইসেন্স
                                            ফি'র ‘এ চালান’ নং</label>
                                    </th>
                                    <td>
                                        {{ $dd->dd_no ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="license_vat_dd_no_{{ $key }}">ভাটের ‘এ
                                            চালান’ নং</label></th>
                                    <td>
                                        {{ $dd->dd_vat ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="license_tax_dd_no_{{ $key }}">ট্যাক্সের
                                            ডিডি নং</label></th>
                                    <td>
                                        {{ $dd->dd_tax ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="license_bank_name_{{ $key }}">ব্যাংক ও
                                            শাখার নাম </label></th>
                                    <td>
                                        {{ $dd->bank_name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="license_dd_date_{{ $key }}">‘এ চালান’
                                            এর তারিখ </label></th>
                                    <td>
                                        {{ $dd->dd_date ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="license_dd_total_amount_{{ $key }}">মোট
                                            টাকা </label></th>
                                    <td>
                                        {{ $dd->total ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="license_dd_j1_slip_no_{{ $key }}">জ১
                                            রশিদ নং</label></th>
                                    <td>
                                        {{ $dd->j1 ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="license_dd_j1_slip_date_{{ $key }}">ফি
                                            আদায়ের তারিখ</label>
                                    </th>
                                    <td>
                                        {{ $dd->j1_date ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

    </x-slot>

</x-backend.card>


@endsection

@push('after-styles')
{{-- <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"> --}}
@endpush

@push('after-scripts')
{{-- <script type="text/javascript">

    </script> --}}
@endpush