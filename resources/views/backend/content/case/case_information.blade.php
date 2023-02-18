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
          
            <a href="{{route('admin.case-date.create',$casedetails->id)}}" class="btn btn-sm btn-primary"
                id="">
                <i class="fa fa-plus" aria-hidden="true"></i>পরবর্তী মামলার তারিখ
            </a>
            <a href="{{route('admin.case.edit',$casedetails->id)}}" class="btn btn-sm btn-warning">
                <i class="fas fa-pencil-alt" aria-hidden="true"></i> তথ্য সংশোধন
            </a>
            <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :text="__('Cancel')" />
        </x-slot>


    <x-slot name="body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>মামলা সমূহ বিস্তারিত</h4>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tbody>
                                <tr>
                                    <td>মামলা নং:</td>
                                    <td>{{ $casedetails->case_no }}</td>
                                </tr>
                                <tr>
                                    <td>আদালতের নাম:</td>
                                    <td>{{ $casedetails->court_name }}</td>
                                </tr>
                                <tr>
                                    <td>বাদীর নাম:</td>
                                    <td>{{ $casedetails->court_name }}</td>
                                </tr>
                                <tr>
                                    <td>আদালতের নাম:</td>
                                    <td>{{ $casedetails->accuser_name }}</td>
                                </tr>
                                <tr>
                                    <td>বাদীর ঠিকানা:</td>
                                    <td>{{ $casedetails->accuser_address }}</td>
                                </tr>
                                <tr>
                                    <td>বাদীর মোবাইল নম্বর:</td>
                                    <td>{{ $casedetails->accuser_phone }}</td>
                                </tr>
                                <tr>
                                    <td>বিবাদীর নাম:</td>
                                    <td>{{ $casedetails->defendant_name }}</td>
                                </tr>
                                <tr>
                                    <td>বিবাদীর ঠিকানা:</td>
                                    <td>{{ $casedetails->defendant_address }}</td>
                                </tr>
                                <tr>
                                    <td>বাদীর মোবাইল নম্বর:</td>
                                    <td>{{ $casedetails->defendant_phone }}</td>
                                </tr>
                               
                                <tr>
                                    <td>এসএফ এর স্মারক:</td>
                                    <td>{{ $casedetails->sfref }}</td>
                                </tr>
                                <tr>
                                    <td>এসএফ এর তারিখ:</td>
                                    <td>{{ date('d-M-y', strtotime($casedetails->sfdate)) }}</td>
                                </tr>
                                <tr>
                                    <td>মামলার সার সংক্ষেপ:</td>
                                    <td>{{ $casedetails->case_summary }}</td>

                                </tr>
                                <tr>
                                    <td>মামলার ফাইল </td>
                                    <td>

                                    @if ($casedetails->case_doc &&
                                                    file_exists(public_path('uploads/case/' . $casedetails->case_doc)))
                                                    <a class="text-black"
                                                        href="{{ asset('uploads/case/' . $casedetails->case_doc) }}"
                                                        download><i class="fa fa-file fa-2x" aria-hidden="true"></i></a>
                                                @else
                                                    <h6><span class="badge badge-danger">no file</span></h6>
                                                @endif
                                    </td>
                                    
                                </tr>
                                
                              
                            </tbody>
                        </table>
                    </div>    
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>মামলা  পরবর্তী তারিখ</h4>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>মামলার তারিখ</th>
                                    <th>সংক্ষিপ্ত আদেশ</th>  
                                    <th>Action</th> 

                                </tr>
                            </thead>
                            <tbody>

                            @foreach($caseDate as $date)
                                <tr>
                                    <td>{{ date('d-M-y', strtotime($date->case_next_date)) }}</td>
                                    <td>{{$date->short_order}}</td>
                                    <td><a href="{{route('admin.case-date.edit',$date->id)}}"><i class="fa fa-edit"></i></a></td>
                                </tr>
                             @endforeach   
                                
                              
                            </tbody>
                        </table>
                    </div>    
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    
                    <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>বিভাগের নাম</th>
                                    <th>কাচারীর নাম:</th>
                                    <th>জেলার নাম</th>
                                    <th>উপজেলার নাম</th>
                                    <th>স্টেশনের নাম</th>
                                    <th>মৌজার নাম</th>
                                    <th>রেকর্ডের নাম</th>
                                    <th>খতিয়ান নম্বর</th>
                                    <th>দাগ নম্বর</th>
                                    <th>লীজকৃত জমি পরিমাণ</th>
                                    

                                </tr>
                            </thead>
                            <tbody>

                            @foreach($caseDistrict as $dis)
                                <tr>
                                    <td>{{$dis->divisionDetails->division_name}}</td>
                                    <td>{{$dis->kachariDetails->kachari_name}}</td>
                                    <td>{{$dis['districtDetails']['district_name']}}</td>
                                    <td>{{$dis['upazilaDetails']['upazila_name']}}</td>
                                    <td>{{$dis['stationDetails']['station_name']}}</td>
                                    <td>{{$dis['mouja']['mouja_name']}}</td>
                                    <td>{{$dis['record']['record_name']}}</td> 
                                    <td>
                                    <?php  $ledger= App\Models\Backend\ledger::where('id',$dis->ledger_id)->pluck('ledger_number')->first();?>    
                                    {{$ledger}}</td>
                                    
                                    <td>@foreach (json_decode($dis->plot_id) as $plot)
                                        @php
                                        $plots= App\Models\Backend\plot::where('plot_id',$plot)->get();
                                        @endphp
                                      
                                      @foreach ($plots as $p)
                                      {{$p->plot_number}}
                                      @endforeach
                                       
                                      @endforeach
                                    </td>
                                    <td>{{$dis->property_amount}}</td>
                                   
                                </tr>
                             @endforeach   
                                
                              
                            </tbody>
                        </table>
                    </div>    
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