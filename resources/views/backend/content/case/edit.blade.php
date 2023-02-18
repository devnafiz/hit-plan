@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __(' মামলার তথ্য সংশোধন'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang(' মামলার তথ্য সংশোধন করুন')
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

        {{ html()->form('PUT', route('admin.case.update',$casedetails->id))->id('ownerForm')->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}
        
        <input type="hidden" id="kachari" value="{{ route('admin.ledger.fetch-kachari') }}">
        <input type="hidden" id="district" value="{{ route('admin.ledger.fetch-district') }}">
        <input type="hidden" id="upazila" value="{{ route('admin.ledger.fetch-upazila') }}">
        <input type="hidden" id="mouza" value="{{ route('admin.ledger.fetch-mouja') }}">
        <input type="hidden" id="station" value="{{ route('admin.ledger.fetch-station') }}">
        <input type="hidden" id="land" value="{{ route('admin.ledger.land-type') }}">
        <input type="hidden" id="record" value="{{ route('admin.ledger.fetch-record') }}">
        <input type="hidden" id="ledger" value="{{ route('admin.ledger.fetch-ledger') }}">
        <input type="hidden" id="plot" value="{{ route('admin.ledger.fetch-plot') }}">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>মামলার তথ্য</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>মামলা নং:</label>
                            <input type="text" class="form-control" name="case_no" placeholder="মামলা নং" value="{{$casedetails->case_no}}" require>
                        </div>
                        <div class="form-group">
                            <label>আদালতের নাম:</label>
                            <input type="text" class="form-control" name="court_name" placeholder="আদালতের নাম"  value="{{$casedetails->court_name}}" require>
                        </div>
                        <div class="form-group">
                            <label>বাদীর নাম:</label>
                            <input type="text" class="form-control" name="accuser_name" placeholder="বাদীর নাম" value="{{$casedetails->accuser_name}}" require>
                        </div>
                        <div class="form-group">
                            <label>বাদীর ঠিকানা :</label>
                            <textarea class="form-control" name="accuser_address" placeholder="বাদীর ঠিকানা" require>{{$casedetails->accuser_address}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>বাদীর মোবাইল নম্বর:</label>
                            <input type="phone" class="form-control" name="accuser_phone" placeholder="বিবাদীর মোবাইল নম্বর"  value="{{$casedetails->accuser_phone}}" require>
                        </div>
                        <div class="form-group">
                            <label>বিবাদীর নাম:</label>
                            <input type="text" class="form-control" name="defendant_name" placeholder="বিবাদীর নাম" value="{{$casedetails->defendant_name}}" require>
                        </div>
                        <div class="form-group">
                            <label>বিবাদীর ঠিকানা:</label>
                            <textarea class="form-control" name="defendant_address" placeholder="বিবাদীর ঠিকানা" require>{{$casedetails->defendant_address}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>বাদীর মোবাইল নম্বর:</label>
                            <input type="text" class="form-control" name="defendant_phone" placeholder="বিবাদীর মোবাইল নম্বর" value="{{$casedetails->defendant_phone}}" require>
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
                            <input type="text" class="form-control" name="sfref" placeholder="এসএফ এর স্মারক" value="{{$casedetails->sfref}}" require>
                        </div>
                        <div class="form-group">
                            <label>এসএফ এর তারিখ:</label>
                            <input type="date" class="form-control" name="sfdate" placeholder="এসএফ এর তারিখ" value="{{$casedetails->sfdate}}" require>
                        </div>
                        <div class="form-group">
                            <label>এস এফ চেয়ে প্রেরিত পত্রের স্মারক নং:</label>
                            <input type="text" class="form-control" name="sfrefno" placeholder="এস এফ চেয়ে প্রেরিত পত্রের স্মারক নং" value="{{$casedetails->sfrefno}}" require>
                        </div>
                        <div class="form-group">
                            <label>এসএফ চেয়ে প্রেরিত পত্রের তারিখ:</label>
                            <input type="date" class="form-control" name="sffromdate" placeholder="এসএফ চেয়ে প্রেরিত পত্রের তারিখ" value="{{$casedetails->sffromdate}}" require>
                        </div>
                        <div class="form-group">
                            <label>মামলার সার সংক্ষেপ :</label>
                            <textarea class="form-control" name="case_summary" placeholder="মামলার সার সংক্ষেপ" require>{{$casedetails->case_summary}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>সংক্ষিপ্ত আদেশ:</label>
                            <textarea class="form-control" name="short_order" placeholder="সংক্ষিপ্ত আদেশ" require>{{$lastCaseDate->short_order}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>মামলার আগামী তারিখ:</label>
                            <input type="date" class="form-control" name="case_next_date" value="{{date('d-M-y', strtotime($lastCaseDate->case_next_date))}}"  require>
                        </div>
                    </div>
                </div>

                
            </div>
            @foreach ($disMoujas as $key => $dis)
            <div class="col-12">
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="division_id">বিভাগের নাম:</label>
                            </div>
                        </div>
                       
                        <div class="col-md-3">
                       
                            <select required id="division_id" class="form-control division_id" name="mouja[{{$key}}][division_id]"  data-target="#kachari_id_{{ $key }}" required>
                                <option value="" disabled selected>বাছাই করুন</option>
                                @foreach ($division as $divisions_name)
                                <option value="{{ $divisions_name->division_id }}" {{($dis->division_id==$divisions_name->division_id )?'selected':''}}>
                                    {{ $divisions_name->division_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 ">
                          <!-- <button type="button" id="addwhole-divisin" class="btn btn-danger">delete</button> -->
                          <a href="{{route('admin.case.division.delete',$dis->id)}}"  data-method="delete-post" class="btn btn-outline-danger"><i class="fa fa-trash"></i></a> 
                          <button type="button" id="addwhole-divisin" class="btn btn-primary {{($key>0)? 'none' :''}}"  >add more</button>
                            
                       </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="kachari_id">কাচারীর নাম:</label>
                              
                            </div>
                        </div>
                        <div class="col-md-3">
                        {{ html()->select('mouja[' . $key . '][kachari_id]', $kacharis->pluck('kachari_name', 'kachari_id'), $dis->kachari_id)->class('form-control kachari_id')->attribute('data-target', '#district_id_' . $key)->id('kachari_id_' . $key) }}
                           
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="district_id">জেলার নাম:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                        {{ html()->select('mouja[' . $key . '][district_id]', $districtes->pluck('district_name', 'district_id'), $dis->district_id)->class('form-control district_id')->attribute('data-target', '#upazila_id_' . $key)->id('district_id_' . $key) }}
                          
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="upazila_id">উপজেলার নাম:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                        {{ html()->select('mouja[' . $key . '][upazila_id]', $upazila->pluck('upazila_name', 'upazila_id'), $dis->upazila_id)->class('form-control upazila_id')->attribute('data-target', '#station_id_' . $key)->id('upazila_id_' . $key) }}
                           
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="station_id">স্টেশনের নাম:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                        {{ html()->select('mouja[' . $key . '][station_id]', $station->pluck('station_name', 'station_id'), $dis->station_id)->class('form-control station_id')->attribute('data-target', '#mouja_id_' . $key)->id('station_id_' . $key) }}
                           
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
                                <th>লীজকৃত জমি পরিমাণ</th>
                                
                               
                            </tr>
                            <tr>
                                <td style="width: 10%;">
                                    <!-- <select class="form-control mouja_id" id="mouja_id_0" data-target="#record_name_0" name="mouja[0][mouja_id]" required>
                                        <option selected disabled>মৌজা</option>
                                    </select> -->
                                    {{ html()->select('mouja[' . $key . '][mouja_id]', $mouja->pluck('mouja_name', 'mouja_id'), $dis->mouja_id)->class('form-control mouja_id2')->attribute('data-target', '#record_name_' . $key)->id('mouja_id_' . $key) }}
                                </td>

                                <td style="width: 10%;">
                                {{ html()->select('mouja[' . $key . '][record_name]', collect($records), $dis->record_name)->class('form-control record_name')->attribute('data-target', '#ledger_id_' . $key)->attribute('data-previous', 'mouja_id_' . $key)->id('id', 'record_name_' . $key) }}
                                    <!-- <select class="form-control record_name" id="record_name_0" data-target="#ledger_id_0" name="mouja[0][record_name]" data-previous="mouja_id_0">
                                        <option selected disabled>রেকর্ড</option>
                                    </select> -->
                                </td>

                                <td style="width: 10%;">
                                    <select class="form-control ledger_id" id="ledger_id_{{ $key }}"
                                                data-target="#plot_id_{{ $key }}"
                                                name="mouja[{{ $key }}][ledger_id]">
                                                <option disabled>খতিয়ান নম্বর</option>
                                                @forelse ($ledgers as $ledger)
                                                    @if ($ledger != null)
                                                        <option value="{{ $ledger->id }}"
                                                            @if ($ledger && $ledger->id == $dis->ledger_id) selected @endif>
                                                            {{ $ledger->ledger_number }}
                                                        </option>
                                                    @endif
                                                @empty
                                                @endforelse
                                            </select>
                                </td>

                                <td style="width: 20%;">
                                           @php
                                                $moujaPlot = json_decode($dis->plot_id, true);
                                                $totalLandAmount = 0;
                                                $ledgerPlots = $plots->where('ledger_id', $dis->ledger_id);
                                            @endphp
                                            <select class="form-control js-example-basic-single plot_id"
                                                id="plot_id_{{ $key }}"
                                                name="mouja[{{ $key }}][plot_id][]" multiple
                                                data-target="#mouja_total_amount_{{ $key }}">
                                                @foreach ($ledgerPlots as $plot)
                                                    @php
                                                        $totalLandAmount += $plot->land_amount;
                                                    @endphp
                                                    <option value="{{ $plot->plot_id }}"
                                                        land-amount="{{ $plot->land_amount }}"
                                                        {{ in_array($plot->plot_id, $moujaPlot) ? 'selected' : '' }}>
                                                        {{ $plot->plot_number }}
                                                    </option>
                                                @endforeach
                                            </select>
                                </td>

                                <td style="width: 10%;">
                                    <input type="text" name="mouja[{{$key}}][property_amount]" id="mouja_total_amount_{{$key}}" placeholder="জমির পরিমাণ" class="form-control" value="{{ $dis->property_amount }}" />
                                </td>

                               

                                
                            </tr>

                        </table>
                    </div>
                



            
        </div>
       
        @endforeach
        @if($casedis==NULL)
        <div class="col-12">
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="division_id">বিভাগের নাম:</label>
                            </div>
                        </div>
                       
                        <div class="col-md-3">
                            <select required id="division_id" class="form-control division_id" name="mouja[0][division_id]" required>
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
                            <select required id="kachari_id" class="form-control" name="mouja[0][kachari_id]" required>
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
                            <select required class="form-control" id="district_id" name="mouja[0][district_id]" required>
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
                            <select required class="form-control" id="upazila_id" name="mouja[0][upazila_id]" required>
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
                            <select required class="form-control" id="station_id" name="mouja[0][station_id]" required>
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
                                <th>জমির পরিমাণ</th>
                                
                               
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
                                    <input type="text" name="mouja[0][property_amount]" id="mouja_total_amount_0" placeholder="জমির পরিমাণ" class="form-control" />
                                </td>

                               

                                
                            </tr>

                        </table>
                    </div>
                



            
        </div>
        @endif
        
        
        
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
                <button type="submit" class="btn btn-lg btn-dark float-right">আপডেট</button>
            </div>
        </div>

        {{ html()->form()->close() }}
    </x-slot>

</x-backend.card>

<script></script>
<style>
    .none{
        display:none;
    }
</style>
@endsection

@push('after-styles')
{{-- <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"> --}}
@endpush

@push('after-scripts')
<script src="{{asset('js/case.js')}}"></script>
@endpush