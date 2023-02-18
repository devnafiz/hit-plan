@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
<x-backend.card>
    <x-slot name="body">
        <!-- Small boxes (Stat box) -->
        <h4>লাইসেন্স</h4>
        <hr class="mt-0">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <strong class="text-center">
                    <p>ভুমি</p>
                </strong>
                <div class="small-box bg-success">
                    <div class="inner">

                        <h6 class="text-decoration-underline">মোট ভূমি</h6>
                        <hr>
                        <h5>CS পরিমান : {{$data['cs_ledger_data'] }} একর</h5>
                        <h5>SA পরিমান : {{ $data['sa_ledger_data'] }} একর</h5>
                        <h5>RS পরিমান : {{$data['rs_ledger_data'] }} একর</h5>
                    </div>
                    <div class="icon">
                        <!-- <i class="ion ion-cash"></i> -->
                    </div>
                    <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                </div>

            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <strong class="text-center">
                    <p>স্টেশান</p>
                </strong>
                <div class="small-box bg-warning">
                    <div class="inner" style="height: 169px;">

                        <!-- <h6 class="text-decoration-underline">মোট ভূমি</h6> -->
                        <hr>
                        <h5>মোট : {{ $data['station'] }} টি</h5>
                        <!-- <h5>SA পরিমান : {{ $data['sa_ledger_data'] }}  একর</h5>
                            <h5>RS পরিমান : {{$data['rs_ledger_data'] }}  একর</h5> -->
                    </div>
                    <div class="icon">
                        <!-- <i class="ion ion-cash"></i> -->
                    </div>
                    <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                </div>

            </div>

            <div class="col-lg-3 col-md-3 col-sm-6">
                <strong class="text-center">
                    <p>মৌজা</p>
                </strong>
                <div class="small-box  bg-danger">
                    <div class="inner" style="height: 169px;">
                        <!-- <h6 class="text-decoration-underline">মোট ভূমি</h6> -->
                        <hr>
                        <h5>মোট মৌজা : {{ $data['mouja'] }} টি</h5>
                        <!-- <h5>SA পরিমান : {{ $data['sa_ledger_data'] }}  একর</h5>
                            <h5>RS পরিমান : {{$data['rs_ledger_data'] }}  একর</h5> -->
                    </div>
                    <div class="icon">
                        <!-- <i class="ion ion-cash"></i> -->
                    </div>
                    <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                </div>

            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <strong class="text-center">
                    <p>খতিয়ান</p>
                </strong>
                <div class="small-box  bg-warning">
                    <div class="inner" style="height: 169px;">
                        <h6 class="text-decoration-underline">মোট খতিয়ান:{{ $data['ledger'] }} টি</h6>
                        <hr>
                        <h5>CS : {{ $data['cs_ledger'] }} টি</h5>
                        <h5>SA : {{ $data['sa_ledger'] }} টি</h5>
                        <h5>RS : {{ $data['rs_ledger'] }} টি</h5>
                    </div>
                    <div class="icon">
                        <!-- <i class="ion ion-cash"></i> -->
                    </div>
                    <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                </div>

            </div>

        </div>

        <div class="row">
            <!-- ./col -->
            <div class="col-lg-6 col-md-6 col-sm-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <strong>
                            <p>কাচারীর </p>
                        </strong>
                        <h5>মোট : {{ $data['kachari'] }} টি</h5>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>



            <!-- ./col -->
            <div class="col-lg-6 col-md-6 col-sm-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <strong>
                            <p>মাস্টারপ্লান</p>
                        </strong>
                        <h5>মোট : {{ $data['masterplan'] }} টি</h5>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <h4>ভূমি সম্পর্কিত তথ্য</h4>
        <hr class="mt-0">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <strong>
                            <p>কৃষি লাইসেন্স</p>
                        </strong>
                        <h5>{{ $data['agri_license']; }} টি আদায় ({{$data['agri_leased']}} একর): {{number_format($data['agri_license_total']) }}/-</h5>
                    </div>
                    <!-- <div class="inner">
                        <strong>
                            <p>কৃষি আদায়েকৃত জমির পরিমাণ</p>
                        </strong>
                        <h5>{{ $data['agri_license']; }} টি আদায়: {{number_format($data['agri_license_total']) }}/-</h5>
                    </div> -->
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- ./col -->
            <div class="col-lg-3 col-md-3 col-sm-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <strong>
                            <p>বাণিজ্যিক লাইসেন্স</p>
                            <h5>{{ $data['commercial_license']; }} টি আদায় ({{ number_format((float)$data['commercial_leased']/43560, 3,)}} একর
                                ): {{number_format($data['commercial_license_total']) }}/-</h5>
                        </strong>
                    </div>

                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-md-3 col-sm-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <strong>
                            <p>জলাশয় লাইসেন্স</p>
                        </strong>
                        <h5>{{ $data['pound_license']; }} টি আদায় ({{$data['pond_leased']}} একর): {{number_format($data['pound_license_total']) }}/-</h5>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-md-3 col-sm-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <strong>
                            <p>সংস্থা লাইসেন্স</p>
                        </strong>
                        <h5>{{$data['agency_license']}} টি আদায় ({{ number_format((float)$data['agency_leased']/43560, 3,)}} একর): {{number_format($data['agency_license_total']) }}/- </h5>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <h4>রাজস্ব আদায় তথ্য</h4>
        <hr class="mt-0">
        <div class="row">
            <!-- ./col -->
            <div class="col-lg-4 col-md-4 col-sm-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner" style="height: 200px;">
                        <strong>
                            <p>লক্ষ্যমাত্রা</p>
                        </strong>
                        <h5>অর্থবছর : {{ \Carbon\Carbon::parse($data['financial_year']->from_date)->format('Y')}}-{{ \Carbon\Carbon::parse($data['financial_year']->to_date)->format('Y')}}</h5>
                        <h5>লক্ষ্যমাত্রা : {{ $data['financial_year']->amount }} টাকা</h5>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- ./col -->
            <div class="col-lg-4 col-md-4 col-sm-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner" style="height: 200px;">
                        <strong>
                            <p>আদায়</p>
                        </strong>
                        <h5>অর্থবছর : {{ \Carbon\Carbon::parse($data['financial_year']->from_date)->format('Y')}}-{{ \Carbon\Carbon::parse($data['financial_year']->to_date)->format('Y')}} </h5>
                        <h5>লক্ষ্যমাত্রা : {{ $data['total_amount_fyear'] }} টাকা</h5>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <!-- ./col -->
            <div class="col-lg-4 col-md-4 col-sm-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner" style="height: 200px;">
                        <strong>
                            <p>লাইসেন্স অনুযায়ী আদায়</p>
                        </strong>
                        <div class="row">
                            <div class="col-sm-6 col-lg-4 ">
                                <p>কৃষি </p>
                            </div>
                            <div class="col-sm-6 col-lg-2 ">
                                <p>: </p>
                            </div>
                            <div class="col-sm-6 col-lg-6 ">
                                <p>{{ $data['agriBalam_total'] }} টাকা</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p>বাণিজ্যিক </p>
                            </div>
                            <div class="col-md-2">
                                <p> :</p>
                            </div>
                            <div class="col-md-6">
                                <p> {{ $data['comBalam_total'] }} টাকা</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p>জলাশয় </p>
                            </div>
                            <div class="col-md-2">
                                <p> :</p>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $data['pondBalam_total'] }} টাকা</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p>সংস্থা </p>
                            </div>
                            <div class="col-md-2">
                                <p> :</p>
                            </div>
                            <div class="col-md-6">
                                <p>{{$data['agencyBalam_total'] }} টাকা</p>
                            </div>
                        </div>

                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>


        <h4>অপারেটর আদায়</h4>
        <hr class="mt-0">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
            
               
                <div class="small-box bg-info">
                
                    <div class="inner">
                    <strong>
                            <p>Operator One</p>
                    </strong>
                        <strong>
                           
                        </strong>
                        <h5>মোট খতিয়ান : {{ $data['kachari'] }} টি</h5>
                        <h5>মোট কৃষি: {{ $data['kishi_one'] }} টি</h5>
                        <h5>মোট বাণিজ্যিক: {{ $data['commer_one'] }} টি</h5>
                        <h5>মোট জলাশয়: {{ $data['pond_one'] }} টি</h5>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
           
            <div class="col-lg-6 col-md-6 col-sm-6">
               
             <div class="small-box bg-warning">
                    <div class="inner">
                    <strong>
                            <p>Operator Two</p>
                    </strong>
                        
                        <h5>মোট  খতিয়ান: {{$data['ledger_Two'] }} টি</h5>
                        <h5>মোট  কৃষি: {{  $data['kishi_two'] }} টি</h5>
                        <h5>মোট বাণিজ্যিক: {{ $data['commer_two'] }} টি</h5>
                        <h5>মোট জলাশয়: {{ $data['pond_two'] }} টি</h5>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div> 


        <!--
        <h4>মামলা ও ইনভেনটরী সম্পর্কিত তথ্য</h4>
        <hr class="mt-0">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
               
                <div class="small-box bg-info">
                    <div class="inner">
                        <strong>
                            <p>ইনভেনটরী</p>
                        </strong>
                        <h5>মোট : {{ $data['kachari'] }} টি</h5>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
           
            <div class="col-lg-6 col-md-6 col-sm-6">
               
                <div class="small-box bg-warning">
                    <div class="inner">
                        <strong>
                            <p>মামলা</p>
                        </strong>
                        <h5>মোট : {{ $data['case'] }} টি</h5>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <h4>দরপত্র সম্পর্কিত তথ্য</h4>
        <hr class="mt-0">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                
                <div class="small-box bg-danger">
                    <div class="inner">
                        <strong>
                            <p>বাণিজ্যিক দরপত্র</p>
                        </strong>
                        <h5>মোট : {{ $data['kachari'] }} টি</h5>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
           
            <div class="col-lg-6 col-md-6 col-sm-6">
               
                <div class="small-box bg-primary">
                    <div class="inner">
                        <strong>
                            <p>জলাশয় দরপত্র </p>
                        </strong>
                        <h5>মোট : {{ $data['case'] }} টি</h5>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>-->

    </x-slot>
</x-backend.card>

@endsection