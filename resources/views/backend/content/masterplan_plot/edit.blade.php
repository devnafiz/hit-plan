@extends('backend.layouts.app')

@section('title', __('মাস্টারপ্লান সংশোধন '))

@section('content')

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

{{ html()->modelForm($masterplan, 'PUT', route('admin.masterplan-plot.update', $masterplan))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}
<x-backend.card>
    <x-slot name="header">
        @lang('তথ্য সংশোধন')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :href="route('admin.masterplan-plot.index')" :text="__('Cancel')" />
    </x-slot>

    <x-slot name="body">
        @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
        @endif
        <div class="row justify-content-end">
            <div class="col-md-2 mb-2">
                <div class="form-group">
                    <a href="{{ route('admin.masterplan-plot.create') }}" type="button" class="btn btn-primary float-right"><i class="fa fa-plus"></i>
                        Create New Plot</a>
                </div>
            </div>
        </div>

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
                            <label for="action">প্রক্রিয়া</label>
                        </td>
                    </tr>
                    @foreach ($masterplan_plot as $key => $plot)
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
                            <input type="text" class="form-control" name="masterplan_plot[{{ $key }}][total_sft]" value="{{ $plot->total_sft }}" id="total_sft_{{ $key }}" placeholder="প্লটের সাইজ(স্কয়ারফিট)" readonly>
                        </td>
                        <!-- <td>
                            <input type="text" class="form-control" name="masterplan_plot[{{ $key }}][plot_size]" id="plot_size_{{ $key }}" value="{{ $plot->plot_size }}" placeholder="মোট জমির পরিমান">
                        </td> -->
                        <td>
                            <a href="{{ route('admin.masterplan-plot.destroy', $plot->id) }}" type="button" data-method="delete" class="btn btn-outline-danger">-</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-lg btn-dark float-right">Update Masterplan Plot</button>
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