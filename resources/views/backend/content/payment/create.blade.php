@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('পেমেন্ট সার্চ'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('পেমেন্ট সার্চ')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :text="__('Cancel')" />
    </x-slot>

    <x-slot name="body">
        @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
        @endif

        {{ html()->form('POST', route('admin.payment.store'))->id('ownerForm')->attribute('next', 'fee-tab')->open() }}
       



            <div class="col-md-12 bg-light text-justify mt-4 mb-3">
                <label class="mt-1">ফি সংক্রান্ত তথ্য</h6>
            </div>
            <div class="row">

                <div class="col-12">
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="demand_notice_number">Payment Date :</label>
                            </div>
                        </div>
                        <div class="col-md-7">
                        <input type="date" class="form-control" name="trans_date" id="demand_notice_date">
                        </div>
                    </div>
 
                </div>
                
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="demand_notice_number">Transaction Information  :</label>
                            </div>
                        </div>
                        <div class="col-md-7">
                        <input type="text" class="form-control" name="trnx_id" id="trnx_id">
                        </div>
                    </div>
 
                </div>

             
            </div>   

            <div class="row">
           
                <div class="col-md-2 text-right">
                    
                </div>
                <div class="col-7">
                    <button type="submit" class="btn btn-lg btn-block btn-info" style="font-size: 1.5rem!important;">Search</button>
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