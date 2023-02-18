@extends('backend.layouts.app')

@section('title', __('মামলা তৈরি'))

@section('content')

<x-backend.card xmlns:livewire="">
    <x-slot name="header">
        @lang('মামলা সমূহ')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header icon="fas fa-plus" class="btn btn-sm btn-tool btn-primary" :href="route('admin.case.create')" :text="__('মামলা তৈরি')" />
    </x-slot>

    <x-slot name="body">
        <div class="main-content">
            <section class="section">
                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>মামলা সমূহ</h4>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-bordered responsive_table" id="tableExport" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>ক্র. নং</th>
                                                    <th>মামলা নং</th>
                                                    <th>কোর্টের নাম</th>
                                                    <th>বাদীর নাম ও ঠিকানা</th>
                                                    <th>বিবাদীর নাম ও ঠিকানা</th>
                                                    <!--<th>নালিশী ভূমির তফসিল</th>-->
                                                    <th>মামলার সার সংক্ষেপ </th>
                                                    <th>এসএফ এর নং ও তারিখ</th>
                                                    
                                                    <th>মামলার পরবর্তী তারিখ</th>
                                                    
                                                    <th>বিস্তারিত</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($casedetails as $k=>$case)
                                                <tr>
                                                    <td>{{$k+1}}</td>
                                                    <td>{{ $case->case_no }}</td>
                                                    <td>{{ $case->court_name }}</td>
                                                    <td>{{ $case->accuser_name }}</td>
                                                    <td>{{ $case->defendant_name }}</td>
                                                    <td>{{$case->case_summary}}</td>
                                                    
                                                
                                                    <td>{{ $case->sfrefno }} ও {{ $case->sffromdate }}</td>
                                                    
                                                    <td>
                                                        @php
                                                        $date= DB::table('case_date')->where('case_id',$case->id)->orderBy('created_at')->get()->last();
                                                        
                                                        @endphp
                                                        

                                                       
                                                         
                                                          {{ date('d-M-y', strtotime($date->case_next_date)) }}
                                                       
                                                        

                                                 
                                                    </td>
                                                   
                                                    <td> @include('backend.content.case.includes.actions')</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </x-slot>
</x-backend.card>

@endsection

@push('after-styles')
<livewire:styles />
@endpush

@push('after-scripts')
<livewire:scripts />
@endpush