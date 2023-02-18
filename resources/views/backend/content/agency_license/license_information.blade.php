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
        @lang('সংস্থা লাইসেন্সের তথ্য')
    </x-slot>

    <x-slot name="headerActions">
        <a href="{{ route('admin.agency.license.fees.form',$license->id)}}" class="btn btn-sm btn-primary">
            <i class="fa fa-plus" aria-hidden="true"></i> লাইসেন্স ফি আদায়
        </a>
        <a href="{{ route('admin.agency.edit', $license) }}" class="btn btn-sm btn-warning">
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
                                <th>লাইসেন্স নং</th>
                                <td class="text-bold">
                                    {{ $license->generated_id ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>লাইসেন্সর ধরন</th>
                                <td class="text-bold">সংস্থা লাইসেন্স</td>
                            </tr>
                            <tr>
                                <th>সংস্থার নাম</th>
                                <td>{{ $owner->name ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>পদবী</th>
                                <td>{{ $owner->agency_position ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>মোবাইল নং</th>
                                <td>{{ $owner->phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>ঠিকানা</th>
                                <td>{{ $owner->address ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                    @endforeach
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-bordered">
                            <?php $license_moujas = agency_license_moujas($license->agencyMoujas); ?>
                            <tr>
                                <th>কাচারী</th>
                                <td>{{ $license_moujas['kacharis'] ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>জেলা</th>
                                <td>{{ $license_moujas['districts'] ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>উপজেলা</th>
                                <td>{{ $license_moujas['upazilas'] ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>স্টেশন</th>
                                <td>
                                    {{ $license_moujas['stations'] ?? 'N/A' }}
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>

                <!-- table section -->
                <div class="col-md-8 col-sm-12 col-lg-8">
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>জমির তফসিল</th>
                                <?php $license_moujas = agency_license_moujas($license->agencyMoujas); ?>
                                <td>
                                    <strong>মৌজা: </strong>{{ $license_moujas['moujas'] ?? 'N/A' }},
                                    <strong>খতিয়ান নং: </strong>{{ $license_moujas['ledgers'] ?? 'N/A' }},
                                    <strong>রেকর্ড: </strong>{{ $license_moujas['records'] ?? 'N/A' }},

                                </td>
                            </tr>
                            <tr>
                                <th>লীজকৃত জমির পরিমাণ</th>
                                <td>{{ $license_moujas['property_amount'] . ' বর্গফুট' ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>ডিমান্ড নোটিশ নং এবং নোটিশের তারিখ</th>
                                <td>{{ $license->demand_notice_number ?? 'N/A' }}</td>
                            </tr>


                            <tr>
                                <th>নকশা নং এবং নকশার তারিখ</th>
                                <td>{{ $license->design_and_date ?? 'N/A' }}</td>
                            </tr>



                            <tr>
                                <th>লাইসেন্স অনুমোদনের কপি</th>
                                <td>
                                    @if ($license->land_map_certificate &&
                                    file_exists(public_path('uploads/agency/' . $license->land_map_certificate)))
                                    <a href="{{ asset('uploads/agency/' . $license->land_map_certificate) }}" download>
                                        <span class="badge badge-primary">Download</span>
                                    </a>
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
                    <div style="overflow: auto;">
                        <table class="table table-striped table-bordered responsive_table">
                            <thead>
                                <tr>
                                    <th>সময়কাল</th>
                                    <th class="text-center">লাইসেন্স ফি</th>
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
                                    <th>জ১ প্রিন্ট</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($license_balam as $balam)
                                @php
                                $license_dd = $license_balam_dd->where('balam_agency_id', $balam->id);
                                $dd_info = dd_info($license_dd);
                                $license_date_from = date('F j, Y', strtotime($balam['from_date']));
                                $license_date_to = date('F j, Y', strtotime($balam['to_date']));
                                @endphp

                                <tr>
                                    <td>
                                        @if ($license_date_from && $license_date_to)
                                        <strong>from </strong>{{ $license_date_from }}<strong><br> to
                                        </strong>{{ $license_date_to }}
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td>{{ number_format($balam->license_fee) }}</td>
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
                                    <td>{{ $dd_info['dd_date'] ? $dd_info['dd_date'] : 'N/A' }}
                                    </td>
                                    <td>{{ number_format($dd_info['total']) }}</td>
                                    <td>{{ $dd_info['dd_j1'] ? $dd_info['dd_j1'] : 'N/A' }}</td>
                                    <td>{{ date('F j, Y', strtotime($balam['created_at'])) }}
                                    </td>
                                    <td>

                                        @include('backend.content.agency_license.includes.balam_action')

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