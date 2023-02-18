@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('নতুন বাণিজ্যিক দরপত্র যুক্ত'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('নতুন বাণিজ্যিক দরপত্র যুক্ত করুন')
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

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ session()->get('set_url') == 'step-one' ? 'active' : '' }}" style="text-decoration: none; color:black;" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" href="#home" aria-selected="true">দরপত্র তথ্য</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ session()->get('set_url') == 'step-two' ? 'active' : '' }}" id="profile-tab" style="text-decoration: none; color:black;" href="#profile" data-toggle="tab" role="tab" aria-controls="profile" aria-selected="false">দাগের
                    তথ্য</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ session()->get('set_url') == 'step-three' ? 'active' : '' }}" id="contact-tab" style="text-decoration: none; color:black;" href="#contact" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false">শর্তাবলি</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <input type="hidden" id="plot-length-width" value="{{ route('admin.tender.plot') }}">
            <div class="tab-pane {{ session()->get('set_url') == 'step-one' ? 'show active' : 'fade' }}" role="tabpanel" id="home" aria-labelledby="home-tab">
                {{ html()->form('POST', route('admin.commercial-tender.stepper', 'stepone'))->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}
                <input type="hidden" id="kachari" value="{{ route('admin.ledger.fetch-kachari') }}">
                <input type="hidden" id="district" value="{{ route('admin.ledger.fetch-district') }}">
                <input type="hidden" id="upazila" value="{{ route('admin.ledger.fetch-upazila') }}">
                <input type="hidden" id="station" value="{{ route('admin.ledger.fetch-station') }}">
                <input type="hidden" id="masterplan" value="{{ route('admin.ledger.fetch-masterplan') }}">
                <input type="hidden" id="masterplanplot" value="{{ route('admin.ledger.fetch-masterplan-plot') }}">
                <input type="hidden" id="mouza" value="{{ route('admin.ledger.fetch-mouja') }}">
                <input type="hidden" name="seturl" value="step-one" id="">
                <div class="row mt-3">
                    <div class="col-md-12 col-sm-12 justify-content-center">
                        <div class="row">
                            <div class="col-md-3 text-right">
                                <div class="form-group">
                                    <label for="division_id">বিভাগ:</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select required id="division_id" class="form-control division_id" name="division_id" required>
                                    <option value="" disabled selected>বাছাই করুন</option>
                                    @foreach ($division as $divisions_name)
                                    <option value="{{ $divisions_name->division_id }}">
                                        {{ $divisions_name->division_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('division_id'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('division_id') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 text-right">
                                <div class="form-group">
                                    <label for="kachari_id">কাচারী:</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select required id="kachari_id" class="form-control" name="kachari_id" required>
                                    <option selected disabled>কাচারী বাছাই করুন</option>
                                </select>
                                @if ($errors->has('kachari_id'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('kachari_id') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 text-right">
                                <div class="form-group">
                                    <label for="district_id">জেলা:</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select required class="form-control" id="district_id" name="district_id" required>
                                    <option selected disabled>জেলা বাছাই করুন</option>
                                </select>
                                @if ($errors->has('district_id'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('district_id') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 text-right">
                                <div class="form-group">
                                    <label for="upazila_id">উপজেলা:</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select required class="form-control" id="upazila_id" name="upazila_id" required>
                                    <option selected disabled>উপজেলা বাছাই করুন</option>
                                </select>
                                @if ($errors->has('upazila_id'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('upazila_id') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 text-right">
                                <div class="form-group">
                                    <label for="station_id">স্টেশন:</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select required class="form-control" id="station_id" name="station_id" data-key="masterplan" data-target="#masterplan_no_0" required>
                                    <option selected disabled>স্টেশন বাছাই করুন</option>
                                </select>
                                @if ($errors->has('station_id'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('station_id') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 text-right">
                                <div class="form-group">
                                    <label for="masterplan_id">মাস্টারপ্লান:</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control masterplan_no" id="masterplan_no_0" name="masterplan_id" data-target="#plot_id_0" required>
                                    <option selected disabled>মাস্টারপ্লান বাছাই করুন</option>
                                </select>
                                @if ($errors->has('masterplan_id'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('masterplan_id') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 text-right">
                                <div class="form-group">
                                    <label for="masterplan_id">অ্যাপ্লিকেশন ফি:</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" type="number" name="application_fee" id="application_fee" placeholder="অ্যাপ্লিকেশন ফি">
                                @if ($errors->has('application_fee'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('application_fee') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-sm-12 text-right">
                                <div class="form-group">
                                    <label for="masterplan_id">দরপত্র বিজ্ঞপ্তি নং:</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <input type="text" class="form-control" name="tender_no" placeholder="দরপত্র বিজ্ঞপ্তি নং">
                                @if ($errors->has('tender_no'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('tender_no') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>


                        <h4>ধাপ - 1</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="tender_online_rcv_date">দরপত্র অনলাইনে দাখিলের শুরুর তারিখ ও
                                    সময়:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" name="tender[0][tender_online_rcv_date]">
                                        @if ($errors->has('tender_online_rcv_date'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('tender_online_rcv_date') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" class="form-control" name="tender[0][tender_online_rcv_time]">
                                        @if ($errors->has('tender_online_closing_time'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('tender_online_closing_time') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-sm btn-primary add-step">Add
                                            more</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label for="tender_online_end_date">দরপত্র অনলাইনে দাখিলের শেষ তারিখ ও সময়:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" name="tender[0][tender_online_end_date]">
                                        @if ($errors->has('tender_online_end_date'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('tender_online_end_date') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" class="form-control" name="tender[0][tender_online_end_time]">
                                        @if ($errors->has('tender_online_end_time'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('tender_online_end_time') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label for="tender_dd_rcv_date">দরপত্র দাখিলের স্লিপ এবং জামানতের ডিডি অফিসে জমাদান
                                    এর শেষ তারিখ
                                    ও সময়:</label>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" name="tender[0][tender_dd_rcv_date]">
                                        @if ($errors->has('tender_dd_rcv_date'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('tender_dd_rcv_date') }}</small>
                                        </p>
                                        @endif
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="tender[0][tender_dd_rcv_time]">
                                            @if ($errors->has('tender_dd_rcv_time'))
                                            <p class="text-danger">
                                                <small>{{ $errors->first('tender_dd_rcv_time') }}</small>
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tender_open_date">দরপত্র খোলার তারিখ ও সময়:</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" name="tender[0][tender_open_date]">
                                        @if ($errors->has('tender_open_date'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('tender_open_date') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" class="form-control" name="tender[0][tender_open_time]">
                                        @if ($errors->has('tender_open_time'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('tender_open_time') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="stepper"></div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="published_newspaper_name">প্রকাশিত পত্রিকার নাম:</label>
                                    <input type="text" class="form-control" name="newspaper[0][published_newspaper_name]" placeholder="পত্রিকায় প্রকাশের তারিখ">
                                    @if ($errors->has('published_newspaper_name'))
                                    <p class="text-danger">
                                        <small>{{ $errors->first('published_newspaper_name') }}</small>
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="published_newspaper_date">পত্রিকায় প্রকাশের তারিখ:</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="date" class="form-control" name="newspaper[0][published_newspaper_date]">
                                            @if ($errors->has('published_newspaper_date'))
                                            <p class="text-danger">
                                                <small>{{ $errors->first('published_newspaper_date') }}</small>
                                            </p>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-sm btn-primary newspaper">Add
                                                More</button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div id="newspaper-content"></div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-lg btn-dark float-right">Save & Next</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{ html()->form()->close() }}

            </div>

            <div class="tab-pane {{ session()->get('set_url') == 'step-two' ? 'show active' : 'fade' }}" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                {{ html()->form('POST', route('admin.commercial-tender.stepper', 'steptwo'))->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}
                <input type="hidden" name="seturl" value="step-two" id="">
                <?php
                $plots = [];
                if (session()->get('land_details')) {
                    $masterplanid = session()->get('land_details');
                    if (!empty($masterplanPlot)) {
                        foreach ($masterplanPlot as $key => $value) {
                            $plots = $value->where('masterplan_id', $masterplanid['masterplan_id'])->get();
                        }
                    }
                }

                ?>
                <div class="row mt-3">
                    <table class="table table-bordered" id="mouja-plot">
                        <tr>
                            <td>
                                <label for="plot_number">সিলেক্ট প্লট:</label>
                            </td>
                            <td>
                                <label for="plot_length">প্লটের সাইজ (দৈর্ঘ্য):</label>
                            </td>
                            <td>
                                <label for="plot_width">প্লটের সাইজ (প্রস্থ):</label>
                            </td>
                            <td>
                                <label for="plot_width">মোট স্কয়ারফিট:</label>
                            </td>
                            <td>
                                <label for="plot_size">লীজের জমির পরিমান (একর):</label>
                            </td>
                            <td>
                                <label for="action">প্রক্রিয়া</label>
                            </td>
                        </tr>
                        <td>
                            <div class="form-group">
                                <select class="js-example-basic-single form-control plot_number" name="masterplan_plot[0][plot_number]" id="plot_number_0">
                                    <option value="">প্লট নম্বর</option>
                                    @foreach ($plots as $plot)
                                    <option value="{{ $plot->id }}">{{ $plot->plot_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="test" class="form-control mr-1 plot_length ledger_amount" name="masterplan_plot[0][plot_length]" id="plot_length_0" data-target="#total_sft_0" placeholder="প্লটের সাইজ(দৈর্ঘ্য)" data-height="#plot_width_0">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="test" class="form-control plot_width ledger_amount" name="masterplan_plot[0][plot_width]" id="plot_width_0" placeholder="প্লটের সাইজ(প্রস্থ)" data-target="#total_sft_0" data-height="#plot_length_0">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="number" class="form-control total_sft" name="masterplan_plot[0][total_sft]" id="total_sft_0" placeholder="মোট স্কয়ারফিট" readonly>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control ledger_validation" name="masterplan_plot[0][plot_size]" id="plot_size_0" placeholder="জমির পরিমান">
                            </div>
                        </td>

                        <td>
                            <div class="col-md-1 ">
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-primary addTenderPlot"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-lg btn-dark float-right">Save & Next</button>
                    </div>
                </div>
                {{ html()->form()->close() }}

            </div>

            <div class="tab-pane {{ session()->get('set_url') == 'step-three' ? 'show active' : 'fade' }}" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                {{ html()->form('POST', route('admin.commercial-tender.store'))->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">শর্তাবলি</label>
                            {{ html()->textarea('details')->class('editor form-control')->placeholder('status details') }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-lg btn-dark float-right">Save & Next</button>
                    </div>
                </div>
                {{ html()->form()->close() }}
            </div>
        </div>

    </x-slot>

</x-backend.card>

@endsection