@extends('backend.layouts.app')

@section('title', __('পেমেন্ট লাইসেন্স সমূহ'))

@section('content')

    <x-backend.card xmlns:livewire="">
        <x-slot name="header">
            @lang('পেমেন্ট লাইসেন্স সমূহ')
        </x-slot>

        <x-slot name="headerActions">
           
        </x-slot>

        <x-slot name="body">
           
            <div class="report-params p-3" style="border: solid #d9d9d9 3px;">
               
                   

                    
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div style="overflow: auto;">
                            <table id="" class="table table-bordered table-striped"
                                style="overflow-x: auto; width:100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">নং</th>
                                        <th class="text-center align-middle">লাইসেন্স নং</th>
                                        <th class="text-center align-middle">লাইসেন্স ধরন</th>
                                        <th class="text-center align-middle">ট্রানজেকশন আইডি</th>
                                        
                                        <th class="text-center align-middle">ট্রানজেকশন তারিখ</th>
                                        <!-- <th class="text-center align-middle">সর্বশেষ লাইসেন্স ফি পরিশোধের সময়কাল</th> -->
                                       
                                       
                                        <!-- <th class="text-center align-middle">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1100032</td>
                                        <td class="text-center align-middle">কৃষি</td>
                                        <td class="text-center align-middle">74848</td>
                                        <td class="text-center align-middle">2022-11-01</td>



                                    </tr>
                                    <tr>
                                        <td class="text-center align-middle">2</td>
                                        <td class="text-center align-middle">1100035</td>
                                        <td class="text-center align-middle">কৃষি</td>
                                        <td class="text-center align-middle">5434</td>
                                        <td class="text-center align-middle">2022-11-01</td>

                                    </tr>
                                    <tr>
                                        <td class="text-center align-middle">3</td>
                                        <td class="text-center align-middle">1100036</td>
                                        <td class="text-center align-middle">কৃষি</td>
                                        <td class="text-center align-middle">3342</td>
                                        <td class="text-center align-middle">2022-11-01</td>

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
