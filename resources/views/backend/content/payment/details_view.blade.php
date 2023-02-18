@extends('backend.layouts.app')

@section('title', __('ট্রানজেকশন'))

@section('content')

    <x-backend.card xmlns:livewire="">
        <x-slot name="header">
            @lang('ট্রানজেকশন')
        </x-slot>

        <x-slot name="headerActions">
            
        </x-slot>

        <x-slot name="body">
            {{-- <!-- <livewire:backend.agriculturelicense-table /> --> --}}

            <div class="report-params p-3" style="border: solid #d9d9d9 3px;">
               
                    
                  
            </div>
            <br>
           
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div style="overflow: auto;">
                            <table id="" class="table table-bordered table-striped"
                                style="overflow-x: auto; width:100%;">
                                <thead>
                                    <tr>
                                        
                                        <th class="text-center align-middle">ট্রানজেকশন নং</th>
                                        <th class="text-center align-middle">লাইসেন্সীর তথ্য</th>
                                        <th class="text-center align-middle">ট্রানজেকশন </th>
                                        <th class="text-center align-middle">স্টেশনের নাম</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                      <td>{{$details->trnx_info->mer_trnx_id}}</td>
                                      <td>
                                            <strong>নাম : </strong>{{$details->cust_info->cust_name}}<br>
                                            <strong>ইমেইল: </strong>{{$details->cust_info->cust_email}}<br>
                                            <strong>মোবাইল নং</strong>{{$details->cust_info->cust_mobo_no}}<br>
                                          
                                      </td>
                                      <td>
                                            <strong> ট্রানজেকশন  পরিমান: </strong>{{$details->trnx_info->trnx_amt}}<br>
                                            <strong>পিআই চার্জ: </strong>{{$details->trnx_info->pi_charge}}<br>
                                            <strong>মোট  পরিমান</strong>{{$details->trnx_info->total_pabl_amt}}<br>
                                          
                                      </td>

                                    </tr> 

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="clearfix mt-3">
                            <div class="d-inline-block float-right">
                               
                            </div>
                        </div>
                    </div>
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
