@extends('frontend.layouts.app')

@section('title', __('Url Shortner'))

@section('content')
<div class="container mb-5">
    <div class="row justify-content-center mt-3">
        <div class="col-md-11 col-sm-12">
            <div class="card">
                <div class="m-3">
                    <div class="row m-2 justify-content-between">
                        <span>
                            <h2>দরপত্র বিবরণী</h2>
                        </span>

                        <div class="div">
                            <button class="btn"><i class="fa fa-download"></i> Download</button>
                            <a href="{{ route('frontend.tender.applying-form', $tender->id)}}" class="btn btn-sm btn-light">Apply Now</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for=""><strong>দরপত্র নং:</strong></label>
                                </div>
                                <div class="col-md-9">
                                    <label for="">{{ $tender->tender_no ?? 'N/A' }}</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label for=""><strong>এলাকা সংক্রান্ত তথ্য:</strong></label>
                                </div>
                                <div class="col-md-9 col-sm-12">
                                    <label for="">
                                        <strong>বিভাগের:
                                        </strong>{{ $tender->divisionDetails->division_name ?? 'N/A' }} ,
                                        <strong>কাচারী: </strong>{{ $tender->kachariDetails->kachari_name ?? 'N/A' }},
                                        <strong>জেলা: </strong>{{ $tender->districtDetails->district_name ?? 'N/A' }},
                                        <strong>স্টেশন: </strong>{{ $tender->stationDetails->station_name ?? 'N/A' }},
                                        <strong>মাস্টারপ্লান:
                                        </strong>{{ $tender->masterplanDetails->masterplan_no ?? 'N/A' }},
                                        <strong>উপজেলা: </strong>
                                        {{ $tender->upazilaDetails->upazila_name ?? 'N/A' }},
                                    </label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label for=""><strong>দরপত্র বিক্রয় শুরু:</strong></label>
                                </div>
                                <div class="col-md-9 col-sm-12">
                                    {{ date('Y-m-d', strtotime($tender->tender_publish_date)) }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label for=""><strong>দরপত্র বিক্রয়ের শেষ তারিখ:</strong></label>
                                </div>
                                <div class="col-md-9 col-sm-12">
                                    {{ date('Y-m-d', strtotime($tender->tender_closing_date)) }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label for=""><strong>অনলাইনে গ্রহনের তারিখ:</strong></label>
                                </div>
                                <div class="col-md-9 col-sm-12">
                                    {{ date('Y-m-d', strtotime($tender->tender_online_rcv_date)) }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label for=""><strong>অনলাইনে গ্রহনের শেষ সময়:</strong></label>
                                </div>
                                <div class="col-md-9 col-sm-12">
                                    {{ date('Y-m-d', strtotime($tender->tender_online_close_date)) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row p-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">নং</th>
                                    <th class="text-center">দাগ নাম্বার</th>
                                    <th class="text-center">দৈর্ঘ্যে</th>
                                    <th class="text-center">প্রস্থ</th>
                                    <th class="text-center">স্কয়ার ফিট</th>
                                    <th class="text-center">একর</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tender->tenderPlotDetails as $key => $tenderPlot)
                                <tr>
                                    <th class="text-center">{{ $key + 1 }}</th>
                                    <th class="text-center">{{ $tenderPlot->plot_number }}</th>
                                    <th class="text-center">{{ $tenderPlot->plot_length }}</th>
                                    <th class="text-center">{{ $tenderPlot->plot_width }}</th>
                                    <th class="text-center">{{ $tenderPlot->total_sft }}</th>
                                    <th class="text-center">{{ $tenderPlot->plot_size }}</th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
</div> <!-- container-->

@endsection

@push('after-styles')
<livewire:styles />
@endpush

@push('after-scripts')
<livewire:scripts />
@endpush