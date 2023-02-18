@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('বাণিজ্যিক লাইসেন্সের বালাম'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('বাণিজ্যিক লাইসেন্সের তথ্য')
    </x-slot>
    <x-slot name="headerActions">
        <a href="{{ route('admin.agri-license-fees.create') }}" class="btn btn-sm btn-primary">
            <i class="fa fa-plus" aria-hidden="true"></i> লাইসেন্স ফি আদায়
        </a>
        <a href="{{ route('admin.agriculture.edit', $license) }}" class="btn btn-sm btn-warning">
            <i class="fas fa-pencil-alt" aria-hidden="true"></i> তথ্য সংশোধন
        </a>
        <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :text="__('Cancel')" />
    </x-slot>

    <x-slot name="body">
        <div class="container-fluid">
            <!-- row -->
            <div class="row">
                <!-- table section -->
                <div class="col-md-4">
                    @foreach ($license_owner as $owner)
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>লাইসেন্সীর ছবি</th>
                                <td><img src="{{ $owner->photo ? asset('uploads/owners/' . $owner->photo) : asset('uploads/noimage.png') }}" alt="img" style="max-width: 80px;"></td>
                            </tr>
                            <tr>
                                <th>লাইসেন্স নং</th>
                                <td class="text-bold">
                                    {{ $license->generated_id ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>লাইসেন্সর ধরন</th>
                                <td class="text-bold">কৃষি লাইসেন্স</td>
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
                                <th>জাতীয় পরিচয়পত্র নং</th>
                                <td>{{ $owner->nid ?? 'N/A' }}</td>
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
                                <th>কাচারী</th>
                                <td>{{ $license->kachari->kachari_name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>জেলা</th>
                                <td>{{ $license->district->district_name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>উপজেলা</th>
                                <td>{{ $license->upazila->upazila_name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>স্টেশন</th>
                                <td>
                                    {{ $license->station->station_name ?? 'N/A' }}
                                </td>

                            </tr>

                        </table>
                    </div>
                    @endforeach
                </div>
                <!-- table section -->
                <div class="col-md-8">
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>জমির তফসিল</th>
                                <td>
                                    <?php $license_moujas = commercial_license_moujas($license->commercialMoujas); ?>
                                    {{-- <strong>মৌজা: </strong>{{ $license_moujas['moujas'] ?? 'N/A' }}
                                    <strong>খতিয়ান নং: </strong>{{ $license_moujas['ledgers'] ?? 'N/A' }}
                                    <strong>রেকর্ড: </strong>{{ $license_moujas['records'] ?? 'N/A' }} --}}
                                    <strong>দাগ: </strong>{{ $license_moujas['plots'] ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>জমির পরিমাণ</th>
                                <td>{{ number_format($license->commercialMoujas->sum('property_amount')) }} একর</td>
                            </tr>
                            <tr>
                                <th>লীজকৃত জমি</th>
                                <td>{{ number_format($license->commercialMoujas->sum('leased_area')) }} বর্গফুট</td>
                            </tr>
                            <tr>
                                <th>ডিমান্ড নোটিশ নং</th>
                                <td>{{ $license->demand_notice_number ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>ডিমান্ড নোটিশের তারিখ</th>
                                <td>{{ date('F j, Y', strtotime($license->demand_notice_date)) ?? 'N/A' }}</td>

                            </tr>

                            <tr>
                                <th>নকশা নং</th>
                                <td>{{ $license->land_map_number ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>নকশার তারিখ</th>
                                <td>{{ $license->land_map_date ? date('F j, Y', strtotime($license->land_map_date)) : 'N/A' }}
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
                                <th>কি.মি.</th>
                                <td>{{ $license->land_map_kilo ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>পশ্চিম</th>
                                <td>{{ $license->land_map_west ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>লাইসেন্স অনুমোদনের কপি</th>
                                <td><img src="{{ $license->land_map_certificate ? asset($license->land_map_certificate) : asset('images/12113.JPG') }}" alt="img" style="max-width: 80px;"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- table section -->
            </div>
    </x-slot>

</x-backend.card>


{{-- <x-backend.card>
        <x-slot name="body">
            <div class="row">
                <div class="col-md-12">
                    <div class="white_shd full margin_bottom_30">
                        <div class="full graph_head">
                            <div class="heading1 margin_0">
                                <h2>বালাম</h2>
                            </div>
                        </div>
                        <div class="table_section padding_infor_info">
                            <div class="table-responsive-sm">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>সময়কাল</th>
                                            <th>লাইসেন্স ফি</th>
                                            <th>ভ্যাট</th>
                                            <th>ট্যাক্স</th>
                                            <th>জরিমানা</th>
                                            <th>সিকিউরিটি</th>
                                            <th>প্ল্যান ফি</th>
                                            <th>আবেদন ফি</th>
                                            <th>নবায়ন ফি</th>
                                            <th>নামজারী ফি</th>
                                            <th>মোট ফি</th>
                                            <th>লাইসেন্স ফি‘র ডিডি নং</th>
                                            <th>ভ্যাটের ডিডি নং</th>
                                            <th>ট্যাক্সের ডিডি নং</th>
                                            <th>ব্যাংক ও শাখার নাম</th>
                                            <th>‘এ চালান’ এর তারিখ</th>
                                            <th>মোট টাকা</th>
                                            <th>জ১ রশিদ নং</th>
                                            <th>জ১ রশিদের তারিখ</th>
                                            <th>জ১ প্রিন্ট</th>
                                            <th>আপডেট</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>2018-07-01 হতে 2019-06-30 পর্যন্ত</td>
                                            <td>8000</td>
                                            <td>200</td>
                                            <td>35</td>
                                            <td>200</td>
                                            <td>100</td>
                                            <td>20</td>
                                            <td>20</td>
                                            <td>20</td>
                                            <td>20</td>
                                            <td>8500</td>
                                            <td>22542545</td>
                                            <td>545454545</td>
                                            <td>425423435</td>
                                            <td>Sonali Bank, Lalmonirhat</td>
                                            <td>2020-08-04</td>
                                            <td>8500</td>
                                            <td>543545</td>
                                            <td>2020-08-25</td>

                                            <td><a href="#"><button type="button" class="btn btn-secondary">জ/১
                                                        প্রিন্ট</button></a></td>

                                            <td><a href="agriculture-edit.html"><button type="button"
                                                        class="btn btn-info">আপডেট</button></a></td>
                                        </tr>


                                        <tr>
                                            <td>2019-07-01 হতে 2020-06-30 পর্যন্ত</td>
                                            <td>1000</td>
                                            <td>150</td>
                                            <td>100</td>
                                            <td>200</td>
                                            <td>100</td>
                                            <td>20</td>
                                            <td>20</td>
                                            <td>20</td>
                                            <td>0</td>
                                            <td>9500</td>
                                            <td>22542545</td>
                                            <td>545454545</td>
                                            <td>425423435</td>
                                            <td>Sonali Bank, Lalmonirhat</td>
                                            <td>2020-06-18</td>
                                            <td>8500</td>
                                            <td>543545</td>
                                            <td>2020-06-30</td>

                                            <td><a href="#"><button type="button" class="btn btn-secondary">জ/১
                                                        প্রিন্ট</button></a></td>

                                            <td><a href="agriculture-edit.html"><button type="button"
                                                        class="btn btn-info">আপডেট</button></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-backend.card> --}}

@endsection

@push('after-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endpush

@push('after-scripts')
@endpush