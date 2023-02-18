@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('নতুন মাস্টারপ্লান প্লট যুক্ত'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('নতুন মাস্টারপ্লান প্লট যুক্ত করুন')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header class="btn btn-sm btn-tool btn-info" icon="fas fa-backspace" :href="route('admin.masterplan.show', $id)" :text="__('Back to Masterplan')" />
        <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :href="route('admin.masterplan-plot.index')" :text="__('Cancel')" />
    </x-slot>

    <x-slot name="body">
        @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
        @endif
        {{ html()->form('POST', route('admin.masterplan-plot.store'))->id('ownerForm')->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}
        <div class="row">
            <div class="col-12">
                <!-- <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="masterplan_no">মাস্টারপ্লান বাছাই:</label>
                            <select required id="masterplan_no" class="form-control" name="masterplan_id" required>
                                <option selected disabled>মাস্টারপ্লান বাছাই করুন</option>
                                @foreach ($masterplans as $masterplan)
                                <option value="{{ $masterplan->id }}">{{ $masterplan->masterplan_no }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div> -->
                <input type="hidden" name="masterplan_id" id="masterplan_no" value="{{$id}}">
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
                    <td>
                        <input type="text" class="form-control" name="masterplan_plot[0][plot_number]" id="plot_number_0" placeholder="প্লট নম্বর">
                    </td>
                    <td>
                        <input type="test" class="form-control mr-1 plot_length ledger_amount" name="masterplan_plot[0][plot_length]" id="plot_length_0" data-target="#total_sft_0" data-target2="#plot_size_0" placeholder="প্লটের সাইজ(দৈর্ঘ্য)" data-height="#plot_width_0">
                    </td>
                    <td>
                        <input type="test" class="form-control plot_width ledger_amount" name="masterplan_plot[0][plot_width]" id="plot_width_0" placeholder="প্লটের সাইজ(প্রস্থ)" data-target="#total_sft_0" data-target2="#plot_size_0" data-height="#plot_length_0">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="masterplan_plot[0][total_sft]" id="total_sft_0" placeholder="প্লটের সাইজ(স্কয়ারফিট)">
                        <input type="hidden" class="form-control" name="masterplan_plot[0][plot_size]" id="plot_size_0" placeholder="মোট জমির পরিমান">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="masterplan_plot[0][plot_comments]" id="plot_comments_0" placeholder="মন্তব্য">
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-primary addMasterPlanPlot" data-key="1"><i class="fa fa-plus"></i></button>
                    </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-primary float-right">Save New Plot</button>
                </div>
            </div>
        </div>
        {{ html()->form()->close() }}
    </x-slot>

</x-backend.card>

<script></script>
@endsection

@push('after-styles')
{{-- <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"> --}}
@endpush

@push('after-scripts')
@endpush