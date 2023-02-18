@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('নতুন মামলার তথ্য যুক্ত'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('নতুন মামলার তথ্য যুক্ত করুন')
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

        {{ html()->form('POST', route('admin.case.store'))->id('ownerForm')->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}
        <input type="hidden" id="kachari" value="{{ route('admin.ledger.fetch-kachari') }}">
        <input type="hidden" id="district" value="{{ route('admin.ledger.fetch-district') }}">
        <input type="hidden" id="upazila" value="{{ route('admin.ledger.fetch-upazila') }}">
        <input type="hidden" id="mouza" value="{{ route('admin.ledger.fetch-mouja') }}">
        <input type="hidden" id="station" value="{{ route('admin.ledger.fetch-station') }}">
        <input type="hidden" id="land" value="{{ route('admin.ledger.land-type') }}">
        <input type="hidden" id="record" value="{{ route('admin.ledger.fetch-record') }}">
        <input type="hidden" id="ledger" value="{{ route('admin.ledger.fetch-ledger') }}">
        <input type="hidden" id="plot" value="{{ route('admin.ledger.fetch-plot') }}">
        
        <input type="hidden"  id="user_id" name="user_id" value="{{ Auth::user()->id }}"/>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>মামলার তথ্য</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>মামলা নং:</label>
                            <input type="text" class="form-control" name="case_no" placeholder="মামলা নং" require>
                        </div>
                        <div class="form-group">
                            <label>আদালতের নাম:</label>
                            <input type="text" class="form-control" name="court_name" placeholder="আদালতের নাম" require>
                        </div>
                        <div class="form-group">
                            <label>বাদীর নাম:</label>
                            <input type="text" class="form-control" name="accuser_name" placeholder="বাদীর নাম" require>
                        </div>
                        <div class="form-group">
                            <label>বাদীর ঠিকানা :</label>
                            <textarea class="form-control" name="accuser_address" placeholder="বাদীর ঠিকানা" require></textarea>
                        </div>
                        <div class="form-group">
                            <label>বাদীর মোবাইল নম্বর:</label>
                            <input type="phone" class="form-control" name="accuser_phone" placeholder="বিবাদীর মোবাইল নম্বর" require>
                        </div>
                        <div class="form-group">
                            <label>বিবাদীর নাম:</label>
                            <input type="text" class="form-control" name="defendant_name" placeholder="বিবাদীর নাম" require>
                        </div>
                        <div class="form-group">
                            <label>বিবাদীর ঠিকানা:</label>
                            <textarea class="form-control" name="defendant_address" placeholder="বিবাদীর ঠিকানা" require></textarea>
                        </div>
                        <div class="form-group">
                            <label>বাদীর মোবাইল নম্বর:</label>
                            <input type="text" class="form-control" name="defendant_phone" placeholder="বিবাদীর মোবাইল নম্বর" require>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>আরজি এবং আদেশের তথ্য</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>এসএফ এর স্মারক:</label>
                            <input type="text" class="form-control" name="sfref" placeholder="এসএফ এর স্মারক" require>
                        </div>
                        <div class="form-group">
                            <label>এসএফ এর তারিখ:</label>
                            <input type="date" class="form-control" name="sfdate" placeholder="এসএফ এর তারিখ" require>
                        </div>
                        <div class="form-group">
                            <label>এস এফ চেয়ে প্রেরিত পত্রের স্মারক নং:</label>
                            <input type="text" class="form-control" name="sfrefno" placeholder="এস এফ চেয়ে প্রেরিত পত্রের স্মারক নং" require>
                        </div>
                        <div class="form-group">
                            <label>এসএফ চেয়ে প্রেরিত পত্রের তারিখ:</label>
                            <input type="date" class="form-control" name="sffromdate" placeholder="এসএফ চেয়ে প্রেরিত পত্রের তারিখ" require>
                        </div>
                        <div class="form-group">
                            <label>মামলার সার সংক্ষেপ :</label>
                            <textarea class="form-control" name="case_summary" placeholder="মামলার সার সংক্ষেপ" require></textarea>
                        </div>
                        <div class="form-group">
                            <label>সংক্ষিপ্ত আদেশ:</label>
                            <textarea class="form-control" name="short_order" placeholder="সংক্ষিপ্ত আদেশ" require></textarea>
                        </div>
                        <div class="form-group">
                            <label>মামলার আগামী তারিখ:</label>
                            <input type="date" class="form-control" name="case_next_date" placeholder="মামলার আগামী তারিখ" require>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-12">
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="division_id">বিভাগের নাম:</label>
                            </div>
                        </div>
                       
                        <div class="col-md-3">
                            <select required id="division_id" class="form-control division_id" name="mouja[0][division_id]" data-target="#kachari_id_0" required>
                                <option value="" disabled selected>বাছাই করুন</option>
                                @foreach ($division as $divisions_name)
                                <option value="{{ $divisions_name->division_id }}">
                                    {{ $divisions_name->division_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 ">
                             <button type="button" id="addwhole-divisin" class="btn btn-primary">Add more</button>
                        </div> 
                        
                    </div>    

               
                    
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="kachari_id">কাচারীর নাম:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select required id="kachari_id_0" class="form-control kachari_id" name="mouja[0][kachari_id]" data-target="#district_id_0"  required>
                                <option selected disabled>কাচারী বাছাই করুন</option>
                            </select>
                        </div>
                    </div> 
 

                <div class="row">
                    <div class="col-md-2 text-right">
                        <div class="form-group">
                            <label for="district_id">জেলার নাম:</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select required class="form-control district_id" id="district_id_0" name="mouja[0][district_id]" data-target="#upazila_id_0" required>
                            <option selected disabled>জেলা বাছাই করুন</option>
                        </select>
                    </div>
                </div>


                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="upazila_id">উপজেলার নাম:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select required class="form-control upazila_id" id="upazila_id_0" name="mouja[0][upazila_id]"  data-target="#station_id_0" required>
                                <option selected disabled>উপজেলা বাছাই করুন</option>
                            </select>
                        </div>
                    </div>
                    
               

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="station_id">স্টেশনের নাম:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select required class="form-control station_id" id="station_id_0" name="mouja[0][station_id]" data-target="#mouja_id_0" required>
                                <option selected disabled>স্টেশন বাছাই করুন</option>
                            </select>
                        </div>
                    </div>
                    
                
            </div>


            <div class="col-md-12">
                <table class="table table-bordered" id="license_moujas">
                    <tr>
                        <th>মৌজার নাম</th>
                        <th>রেকর্ডের নাম</th>
                        <th>খতিয়ান নম্বর</th>
                        <th>দাগ নম্বর</th>
                        <th>লীজকৃত জমির পরিমাণ</th>


                    </tr>
                    <tr>
                        <td style="width: 10%;">
                            <select class="form-control mouja_id" id="mouja_id_0" data-target="#record_name_0" name="mouja[0][mouja_id]" required>
                                <option selected disabled>মৌজা</option>
                            </select>
                        </td>

                        <td style="width: 10%;">
                            <select class="form-control record_name" id="record_name_0" data-target="#ledger_id_0" name="mouja[0][record_name]" data-previous="mouja_id_0">
                                <option selected disabled>রেকর্ড</option>
                            </select>
                        </td>

                        <td style="width: 10%;">
                            <select class="form-control ledger_id" id="ledger_id_0" data-target="#plot_id_0" name="mouja[0][ledger_id]">
                                <option selected disabled>খতিয়ান নম্বর</option>
                            </select>
                        </td>

                        <td style="width: 20%;">
                            <select class="form-control js-example-basic-single plot_id" id="plot_id_0" name="mouja[0][plot_id][]" multiple="multiple" data-target="#mouja_total_amount_0">
                                <option selected disabled>দাগ নম্বর</option>
                            </select>
                        </td>

                        <td style="width: 10%;">
                            <input type="text" name="mouja[0][property_amount]" id="mouja_total_amount1_0" placeholder="জমির পরিমাণ" class="form-control" />
                        </td>




                    </tr>

                </table>
            </div>
                
                  


        </div>
        <div id="dynamic-wholedivision"></div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2 text-right">
                    <div class="form-group">
                        <label for="case_doc"> মামলার ফাইল আপলোড:</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="file" class="form-control" name="case_doc" id="case_doc" />
                    @if ($errors->has('case_doc'))
                    <p class="text-danger">
                        <small>{{ $errors->first('case_doc') }}</small>
                    </p>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-lg btn-dark float-right">সাবমিট</button>
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
<script src="{{asset('js/case.js')}}"></script>
@endpush