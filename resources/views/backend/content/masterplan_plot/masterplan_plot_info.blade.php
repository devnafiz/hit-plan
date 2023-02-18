@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('মাস্টারপ্লান তথ্য'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('মাস্টারপ্লান তথ্য')
    </x-slot>

    <x-slot name="headerActions">
        <a href="{{ route('admin.masterplan-plot.create') }}" class="btn btn-sm btn-primary">
            <i class="fa fa-plus" aria-hidden="true"></i> মাস্টারপ্লান যুক্ত করুন
        </a>
        <a href="{{ route('admin.masterplan-plot.edit', $masterplan) }}" class="btn btn-sm btn-warning">
            <i class="fas fa-pencil-alt" aria-hidden="true"></i> তথ্য সংশোধন
        </a>
        <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :text="__('Cancel')" />
    </x-slot>

    <x-slot name="body">
        <div class="container-fluid">
            <!-- row -->
            <div class="row">
                <!-- table section -->
                <div class="col-md-8 col-sm-12">
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>মাস্টারপ্লান নং</th>
                                <td>{{ $masterplan->masterplan_no ?? 'N/A' }} </td>
                            </tr>
                            <tr>
                                <th>মাস্টারপ্লান এর নাম </th>
                                <td>{{ $masterplan->masterplan_name ?? 'N/A' }} </td>
                            </tr>
                            <tr>
                                <th>অনুমোদন এর তারিখ</th>
                                <td>{{ date('F j, Y', strtotime($masterplan->approval_date)) ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>কাচারী</th>
                                <td>{{ $masterplan->kachari->kachari_name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>স্টেশন</th>
                                <td>
                                    {{ $masterplan->station->station_name ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>জমির তফসিল</th>
                                <td>
                                    <?php $masterplan_moujas = commercial_license_moujas($masterplan->masterPlanMouja); ?>
                                    <strong>মৌজা: </strong>{{ $masterplan_moujas['moujas'] ?? 'N/A' }}<br>
                                    <strong>খতিয়ান নং: </strong>{{ $masterplan_moujas['ledgers'] ?? 'N/A' }}<br>
                                    <strong>রেকর্ড: </strong>{{ $masterplan_moujas['records'] ?? 'N/A' }}<br>
                                    <strong>দাগ: </strong>{{ $masterplan_moujas['plots'] ?? 'N/A' }}<br>
                                    <strong>জমির পরিমাণ:
                                    </strong>{{ $masterplan->masterPlanMouja->sum('property_amount'). ' একর' ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>প্লট সংখ্যা</th>
                                <td>{{ $masterplan->no_of_plot ?? 'N/A' }} </td>
                            </tr>

                            <tr>
                                <th>মোট জমির পরিমাণ</th>
                                <td>{{ number_format($masterplan->total_area) ?? 'N/A' }} একর</td>
                            </tr>
                            <tr>
                                <th>লাইসেন্স অনুমোদনের কপি</th>
                                <td>
                                    @if ($masterplan->masterplan_doc)
                                    <a href="{{ asset('uploads/masterplan/' . $masterplan->masterplan_doc) }}" download>
                                        <icon class="fas fa-file-download fa-2x"></icon>
                                    </a>
                                    @else
                                    <span class="badge badge-danger">No file</span>
                                    @endif

                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- table section -->
            </div>

            <h4>প্লট সমূহঃ</h4>
            <hr>

            <div class="row justify-content-end">
                <div class="col-md-2 mb-2">
                    <a href="{{ route('admin.masterplan.plot.create', $masterplan->id ) }}" type="button" class="btn btn-primary float-right"><i class="fa fa-plus"></i>
                        Create New Plot</a>
                </div>
            </div>

            <form method="post" action="{{ route('admin.masterplan-plot.update', $masterplan->id) }}">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered" id="mouja-plot">
                            <tr>
                                <td>
                                    <label for="plot_number">প্লট নম্বর:</label>
                                </td>
                                <td>
                                    <label for="plot_length">প্লটের দৈর্ঘ্য (ফুট) :</label>
                                </td>
                                <td>
                                    <label for="plot_width">প্লটের প্রস্থ (ফুট):</label>
                                </td>
                                <td>
                                    <label for="total_sft">প্লটের পরিমাপ(বর্গফুট):</label>
                                </td>
                                <!-- <td>
                                    <label for="plot_size">জমির পরিমান:</label>
                                </td> -->
                                <td>
                                    <label for="plot_size">মন্তব্য:</label>
                                </td>
                                <td>
                                    <label for="action">প্রক্রিয়া</label>
                                </td>
                            </tr>
                            @foreach ($masterPlanPlot as $key => $plot)
                            <tr>
                                <td>
                                    <input type="hidden" name="masterplan_id" value="{{ $masterplan->id }}">
                                    <input type="hidden" name="masterplan_plot[{{ $key }}][masterplanplot_id]" value="{{ $plot->id }}">
                                    <input type="text" class="form-control" name="masterplan_plot[{{ $key }}][plot_number]" id="plot_number_{{ $key }}" value="{{ $plot->plot_number }}" placeholder="প্লট নম্বর">
                                </td>
                                <td>
                                    <input type="text" class="form-control mr-1 plot_length ledger_amount" name="masterplan_plot[{{ $key }}][plot_length]" data-target="#total_sft_{{ $key }}" id="plot_length_{{ $key }}" value="{{ $plot->plot_length }}" placeholder="প্লটের সাইজ(দৈর্ঘ্য)" data-height="#plot_width_{{ $key }}" data-target2="#plot_size_{{ $key }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control ledger_amount plot_width" name="masterplan_plot[{{ $key }}][plot_width]" id="plot_width_{{ $key }}" value="{{ $plot->plot_width }}" placeholder="প্লটের সাইজ(প্রস্থ)" data-target="#total_sft_{{ $key }}" data-target2="#plot_size_{{ $key }}" data-height="#plot_length_{{ $key }}">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="masterplan_plot[{{ $key }}][total_sft]" value="{{ $plot->total_sft }}" id="total_sft_{{ $key }}" placeholder="প্লটের সাইজ(স্কয়ারফিট)" readonly>
                                </td>
                                <!-- <td>
                                    <input type="text" class="form-control" name="masterplan_plot[{{ $key }}][plot_size]" id="plot_size_{{ $key }}" value="{{ $plot->plot_size }}" placeholder="মোট জমির পরিমান">
                                </td> -->
                                <td>
                                    <input type="text" class="form-control" name="masterplan_plot[{{ $key }}][plot_comments]" id="plot_size_{{ $key }}" value="{{ $plot->plot_comments }}" placeholder="মন্তব্য">
                                </td>
                                <td>
                                    <a href="{{ route('admin.masterplan-plot.destroy', $plot->id) }}" type="button" data-method="delete" class="btn btn-outline-danger">-</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="clearfix mt-3">
                        <div class="d-inline-block float-right">
                            @if (!empty($masterPlanPlot))
                            {{ $masterPlanPlot->appends(request()->query())->links() }}
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-lg btn-dark float-right">Update Masterplan Plot</button>
                    </div>
                </div>
            </form>
    </x-slot>

</x-backend.card>

@endsection

@push('after-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endpush

@push('after-scripts')
@endpush