@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('লাইসেন্সের বালাম'))

@php
    $required = html()
        ->span(' *')
        ->class('text-danger');
@endphp

@section('content')

    <x-backend.card>
        <x-slot name="header">
            @lang('জলাশয় লাইসেন্সের তথ্য')
        </x-slot>

        <x-slot name="headerActions">
            <a href="{{ route('admin.pond.license.fees.form', $license) }}" class="btn btn-sm btn-primary">
                <i class="fa fa-plus" aria-hidden="true"></i> লাইসেন্স ফি আদায়
            </a>
            <a href="{{ route('admin.pond-license.edit', $license) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-pencil-alt" aria-hidden="true"></i> তথ্য সংশোধন
            </a>
            <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" :href="route('admin.all_license_fees.create')" icon="fas fa-backspace"
                :text="__('Cancel')" />
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
                                        <td><img src="{{ $owner->photo ? asset('uploads/owners/' . $owner->photo) : asset('images/no-file.png') }}"
                                                alt="img" style="max-width: 80px;"></td>
                                    </tr>
                                    <tr>
                                        <th>লাইসেন্স নং</th>
                                        <td class="text-bold">
                                            {{ $license->generated_id ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>লাইসেন্সর ধরন</th>
                                        <td class="text-bold">জলাশয় লাইসেন্স</td>
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
                                        <?php $license_moujas = license_moujas($license->pondMoujas); ?>
                                        <strong>মৌজা: </strong>{{ $license_moujas['moujas'] ?? 'N/A' }}
                                        <strong>খতিয়ান নং: </strong>{{ $license_moujas['ledgers'] ?? 'N/A' }}
                                        <strong>রেকর্ড: </strong>{{ $license_moujas['records'] ?? 'N/A' }}
                                        <strong>দাগ: </strong>{{ $license_moujas['plots'] ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>জমির পরিমাণ</th>
                                    <td>{{ $license_moujas['property_amount'] . ' একর' ?? 'N/A' }} </td>
                                </tr>
                                <tr>
                                    <th>লাইসেন্সকৃত জমির পরিমান</th>
                                    <td>{{ $license_moujas['leased_area'] . ' বর্গফুট' ?? 'N/A' }} </td>
                                </tr>
                                <tr>
                                    <th>জলাশয় প্লট নং</th>
                                    <td>{{ $license->pond_plot_no ?? 'N/A' }} </td>
                                </tr>
                                <tr>
                                    <th>জমির অবস্থা</th>
                                    <td>{{ $license->land_type . ' মাস পানি' ?? 'N/A' }} </td>
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
                                    <td>
                                        @if ($license->land_map_certificate && file_exists(public_path('uploads/pond/' . $license->land_map_certificate)))
                                            <a class="text-black"
                                                href="{{ asset('uploads/pond/' . $license->land_map_certificate) }}"
                                                download><i class="fa fa-file fa-2x" aria-hidden="true"></i></a>
                                        @else
                                            <h6><span class="badge badge-danger">no file</span></h6>
                                        @endif

                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- table section -->
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h2>বালাম</h2>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered responsive_table">
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
                                        <th>ফি আদায় এর তারিখ</th>
                                        <th>মোট টাকা</th>
                                        <th>জ১ রশিদ নং</th>
                                        <th>জ১ রশিদের তারিখ</th>
                                        <th> প্রিন্ট</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($license_balam as $balam)
                                        @php
                                            $license_dd = $license_balam_dd->where('balam_pond_id', $balam->id);
                                            $dd_info = dd_info($license_dd);
                                            $license_date_from = date_en_to_bn($balam['from_date']);
                                            $license_date_to = date_en_to_bn($balam['to_date']);
                                        @endphp
                                        <tr>
                                            <td>
                                                @if ($license_date_from && $license_date_to)
                                                    {{ $license_date_from }}<strong> হইতে
                                                    </strong>{{ $license_date_to }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $balam->license_fee }}</td>
                                            <td>{{ $balam->vat }}</td>
                                            <td>{{ $balam->tax }}</td>
                                            <td>{{ $balam->fine }}</td>
                                            <td>{{ $balam->security }}</td>
                                            <td>{{ $balam->plan_fee }}</td>
                                            <td>{{ $balam->application_fee }}</td>
                                            <td>{{ $balam->mutation_fee }}</td>
                                            <td>{{ $balam->naming }}</td>
                                            <td>{{ number_format($balam->total_fee) }}</td>
                                            <td>{{ $dd_info['dd_no'] }}</td>
                                            <td>{{ $dd_info['dd_vat'] }}</td>
                                            <td>{{ $dd_info['dd_tax'] }}</td>
                                            <td>{{ $dd_info['bank_name'] }}</td>
                                            <td>{{ date('F j, Y', strtotime($balam->created_at)) }}</td>
                                            <td>{{ number_format($dd_info['total']) }}</td>
                                            <td>{{ $dd_info['dd_j1'] }}</td>
                                            <td>{{ $dd_info['j1_date'] }}</td>
                                            <td>
                                                @include('backend.content.pond.includes.balam_action')
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <th colspan="20" class="text-center">
                                                No result found
                                            </th>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <br>
                            <div>
                             @if ($license->user)
                                    {{ $license->user->name }}, &nbsp {{ $license->user->designation }}, কর্তৃক ডাটা
                                    এন্ট্রি
                                @else
                                    মো:মোস্তাফিজার রাহমান, ফিল্ড কানুনগো,
                                    ০১ নং কাচারী কর্তৃক আদায়কৃত
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-backend.card>

@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endpush

@push('after-scripts')
@endpush
