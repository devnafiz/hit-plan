@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('নতুন পদবী তথ্য যুক্ত'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang(' পদবী তথ্য যুক্ত করুন')
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

        {{ html()->form('POST', route('admin.designation.update',$edit_data->id))->id('ownerForm')->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}
         @method('PATCH')
       
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>পদবী তথ্য</h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label>পদবী নাম :</label>
                            <input type="text" class="form-control" name="name" value="{{$edit_data->name}}" require>
                        </div>
                        <div class="form-group">
                            <label>পদবী বিস্তারিত:</label>
                            <input type="text" class="form-control" name="details" value="{{$edit_data->details}}" require>
                        </div>

                         <div class="form-group">
                           
                            
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status" id="fatherName" value="{{$edit_data->status}}" @if ($edit_data->status) checked @endif>
                                <label class="form-check-label" for="fatherName">
                                    check
                                </label>
                            </div>
                        </div>
                        
                        
                        
                    </div>
                </div>


            </div>

            
     
        </div>

       

        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-lg btn-dark float-right">আপডেট</button>
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