@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('মামলা সমূহ বিস্তারিত'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('মামলা সমূহ বিস্তারিত')
    </x-slot>
   

    <x-slot name="headerActions">
          
            
            <a href="{{route('admin.case.show',$id)}}" class="btn btn-sm btn-warning">
                <i class="fas fa-pencil-alt" aria-hidden="true"></i> মামলার বিস্তারিত তথ্য
            </a>
            <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :text="__('Cancel')" />
    </x-slot>


    <x-slot name="body">
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
     @endif
     {{ html()->form('POST',route('admin.case-date.store'))->id('ownerForm')->open()}}
     <input type="hidden" name="case_id" value="{{$id}}">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>মামলা পরবর্তী তারিখ</h4>
                    </div>
                    <div class="card-body">
                       <div class="row">
                           <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile_0"> মামলার পরবর্তী তারিখ</label>
                                        <input type="date" id="date" class="form-control ledger_amount" name="case_next_date" placeholder="মামলার পরবর্তী তারিখ" class="form-control" value="{{ old('case_next_date') }}" maxlength="15" />
                                    </div>
                                    
                            </div>
                            <div class="col-md-8">
                                    
                                    <div class="form-group">
                                        <label for="address_0">সংক্ষিপ্ত আদেশ</label>
                                        <textarea name="short_order" id="a  ress_0" class="form-control" cols="30" rows="5" placeholder="সংক্ষিপ্ত আদেশ" value="{{ old('short_order') }}"></textarea>
                                    </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-12">
                               <button type="submit" class="btn btn-lg btn-dark float-right">Save Date</button>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{ html()->form()->close() }}
    </x-slot>

</x-backend.card>

@endsection

@push('after-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endpush

@push('after-scripts')
@endpush