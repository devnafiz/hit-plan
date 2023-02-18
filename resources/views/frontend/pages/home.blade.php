@extends('frontend.layouts.app')

@section('title', __('দরপত্র'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 col-sm-8">
            <div class="card">
                <img src="{{ asset('uploads/slide.jpg') }}" alt="">
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-3">
        <div class="col-md-11 col-sm-12">
            <div class="card">
                <div class="m-3">
                    <span>
                        <h2>দরপত্র</h2>
                    </span>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered responsive_table">
                            <thead>
                                <tr>
                                    <th>ক্রমিক</th>
                                    <th>দরপত্র নম্বর</th>
                                    <th>দরপত্র বিক্রয় শুরু</th>
                                    <th>দরপত্র বিক্রয়ের শেষ তারিখ</th>
                                    <th>অনলাইনে গ্রহনের তারিখ</th>
                                    <th>অনলাইনে গ্রহনের শেষ সময়</th>
                                    <th>বিস্তারিত</th>
                                    <th>ডাউনলোড</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($tender_data))
                                @foreach ($tender_data as $val => $tender)
                                <tr>
                                    <td>{{ $val + 1 }}</td>
                                    <td>{{ $tender->tender_no }} <img src="{{ asset('uploads/giphy.gif') }}" style="width: 45px;height: 52px;" alt=""></td>
                                    <td>{{ date('Y-m-d', strtotime($tender->tender_publish_date)) }}</td>
                                    <td>{{ date('Y-m-d', strtotime($tender->tender_closing_date)) }}</td>
                                    <td>{{ date('Y-m-d', strtotime($tender->tender_online_rcv_date)) }}</td>
                                    <td>{{ date('Y-m-d', strtotime($tender->tender_online_close_date)) }}</td>
                                    <td>
                                        <a href="{{ route('frontend.tender.applying-form', $tender->id)}}" class="btn btn-sm btn-primary">আবেদন করুন</a><br>
                                        <a href="{{ route('frontend.commercial-tender.show', $tender->id) }}">বিস্তারিত</a>
                                    </td>
                                    <td style="width:5%;">
                                        <img src="//www.bpsc.gov.bd/themes/responsive_npf/img/file-icons/32px/jpg.png" alt="">
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="col-md-3">
                <div class="card">
                    <h1>hello</h1>
                </div>
            </div> --}}
    </div> <!-- row-->
</div> <!-- container-->

@endsection

@push('after-styles')
<livewire:styles />
@endpush

@push('after-scripts')
<livewire:scripts />
@endpush