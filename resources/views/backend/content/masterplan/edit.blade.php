@extends('backend.layouts.app')

@section('title', __('মাস্টারপ্লান সংশোধন '))

@section('content')

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

<x-backend.card>
    <x-slot name="header">
        @lang('তথ্য সংশোধন ')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :href="route('admin.masterplan.index')" :text="__('Cancel')" />
    </x-slot>

    <x-slot name="body">
        @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
        @endif

        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" id="kachari" value="{{ route('admin.ledger.fetch-kachari') }}">
                    <input type="hidden" id="district" value="{{ route('admin.ledger.fetch-district') }}">
                    <input type="hidden" id="upazila" value="{{ route('admin.ledger.fetch-upazila') }}">
                    <input type="hidden" id="mouza" value="{{ route('admin.ledger.fetch-mouja') }}">
                    <input type="hidden" id="station" value="{{ route('admin.ledger.fetch-station') }}">
                    <input type="hidden" id="record" value="{{ route('admin.ledger.fetch-record') }}">
                    <input type="hidden" id="ledger" value="{{ route('admin.ledger.fetch-ledger') }}">
                    <input type="hidden" id="plot" value="{{ route('admin.ledger.fetch-plot') }}">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a href="#masterplan" class="nav-link active" style="text-decoration: none; color:black;" id="masterplan-tab" data-toggle="tab" role="tab" aria-controls="masterplan" aria-selected="true">মাস্টারপ্লান
                                সংক্রান্ত তথ্য</a>
                        </li>
                        <li class="nav-item">
                            <a href="#plots" class="nav-link" style="text-decoration: none; color:black;" id="plots-tab" data-toggle="tab" role="tab" aria-controls="plots" aria-selected="false">মাস্টারপ্লানের প্লট
                                সংক্রান্ত তথ্য</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="masterplan" role="tabpanel" aria-labelledby="masterplan-tab">
                            {{ html()->modelForm($masterplan, 'PUT', route('admin.masterplan.update', $masterplan))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}
                            <input type="hidden" name="stepper" value="step-two">
                            <div class="row mt-4">
                                <div class="col-md-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                <label for="masterplan_no">মাস্টারপ্লান নং:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" value="{{ $masterplan->masterplan_no }}" name="masterplan_no" placeholder="মাস্টারপ্লান নং">
                                            @if ($errors->has('masterplan_no'))
                                            <p class="text-danger">
                                                <small>{{ $errors->first('masterplan_no') }}</small>
                                            </p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                <label for="approval_date">অনুমোদন এর তারিখ:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime($masterplan->approval_date)) }}" name="approval_date">
                                            @if ($errors->has('approval_date'))
                                            <p class="text-danger">
                                                <small>{{ $errors->first('approval_date') }}</small>
                                            </p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                <label for="masterplan_name">মাস্টারপ্লান এর নাম :</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" value="{{ $masterplan->masterplan_name }}" name="masterplan_name" placeholder="প্লট সংখ্যা">
                                            @if ($errors->has('masterplan_name'))
                                            <p class="text-danger">
                                                <small>{{ $errors->first('masterplan_name') }}</small>
                                            </p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                <label for="division_id">বিভাগ:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <select required id="division_id" class="form-control division_id" name="division_id" required>
                                                <option value="" disabled selected>বাছাই করুন</option>
                                                @foreach ($data['division'] as $divisions_name)
                                                <option value="{{ $divisions_name->division_id }}" {{ $divisions_name->division_id == $masterplan->division_id ? 'selected' : '' }}>
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
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                <label for="kachari_id">কাচারী:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            {{ html()->select('kachari_id', collect($data['kachari']))->class('form-control')->id('kachari_id') }}
                                            @if ($errors->has('kachari_id'))
                                            <p class="text-danger">
                                                <small>{{ $errors->first('kachari_id') }}</small>
                                            </p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                <label for="district_id">জেলা:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            {{ html()->select('district_id', collect($data['district']))->class('form-control')->id('district_id') }}
                                            @if ($errors->has('district_id'))
                                            <p class="text-danger">
                                                <small>{{ $errors->first('district_id') }}</small>
                                            </p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                <label for="upazila_id">উপজেলা:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            {{ html()->select('upazila_id', collect($data['upazila']))->class('form-control')->id('upazila_id') }}
                                            @if ($errors->has('upazila_id'))
                                            <p class="text-danger">
                                                <small>{{ $errors->first('upazila_id') }}</small>
                                            </p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                <label for="station_id">স্টেশন:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            {{ html()->select('station_id', collect($data['station']))->class('form-control')->id('station_id') }}
                                            @if ($errors->has('station_id'))
                                            <p class="text-danger">
                                                <small>{{ $errors->first('station_id') }}</small>
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-6 mb-2">
                                    <button type="button" name="add2" id="addMasterplanMouja" class="btn btn-primary float-right"><i class="fa fa-plus" aria-hidden="true"></i>
                                        Add More</button>
                                </div>

                                <div class="col-md-12 col-sm-12" style="overflow: auto;">
                                    <table class="table table-bordered" id="masterplan_moujas" style="overflow-x: auto; width:100%;">
                                        <tr>
                                            <th>মৌজার নাম</th>
                                            <th>রেকর্ডের নাম</th>
                                            <th>খতিয়ান নম্বর</th>
                                            <th>দাগ নম্বর</th>
                                            <th>দাগে জমির পরিমাণ</th>
                                            <th>Action</th>
                                        </tr>
                                        @php
                                        $totalLandAmount = 0;
                                        @endphp

                                        @foreach ($masterplan->masterPlanMouja as $key => $miuja)
                                        <tr>
                                            <input type="hidden" name="mouja[{{ $key }}][plotId]" value="{{ $miuja->id }}">
                                            <td style="width: 15%">
                                                {{ html()->select('mouja[' . $key . '][mouja_id]', collect($data['moujas']), $miuja->mouja_id)->class('form-control mouja_id')->attribute('data-target', '#record_name_' . $key)->id('mouja_id_' . $key) }}
                                            </td>

                                            <td style="width: 15%">
                                                {{ html()->select('mouja[' . $key . '][record_name]', collect($data['record']), $miuja->record_name)->class('form-control record_name')->attribute('data-target', '#ledger_id_' . $key)->attribute('data-previous', 'mouja_id_' . $key)->id('record_name_' . $key) }}
                                            </td>

                                            <td style="width: 15%">
                                                {{ html()->select('mouja[' . $key . '][ledger_id]', collect($data['ledger']), $miuja->ledger_id)->class('form-control ledger_id')->attribute('data-target', '#plot_id_' . $key)->id('ledger_id_' . $key) }}
                                            </td>

                                            <td style="width: 35%">
                                                @php
                                                $moujaPlot = json_decode($miuja->plot_id, true);
                                                $totalLandAmount = 0;
                                                $ledgerPlots = $plots->where('ledger_id', $miuja->ledger_id);
                                                @endphp
                                                <select class="form-control js-example-basic-single plot_id" id="plot_id_{{ $key }}" name="mouja[{{ $key }}][plot_id][]" multiple data-target="#mouja_total_amount_{{ $key }}">
                                                    @foreach ($ledgerPlots as $plot)
                                                    @php
                                                    $totalLandAmount += $plot->land_amount;
                                                    @endphp
                                                    <option value="{{ $plot->plot_id }}" land-amount="{{ $plot->land_amount }}" {{ in_array($plot->plot_id, $moujaPlot) ? 'selected' : '' }}>
                                                        {{ $plot->plot_number }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td style="width: 15%">
                                                {{ html()->text('mouja[' . $key . '][property_amount]', $totalLandAmount)->class('form-control')->id('mouja_total_amount_' . $key) }}
                                            </td>

                                            <td style="width: 5%">
                                                <a href="{{ route('admin.masterplan.mouja.destroy', $miuja->id) }}" type="button" data-method="delete" class="btn btn-outline-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                <label for="exampleFormControlFile2">অনুমোদনের কপি:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            @if ($masterplan->masterplan_doc && file_exists(public_path('uploads/masterplan/' . $masterplan->masterplan_doc)))
                                            <a class=" text-black" href="{{ asset('uploads/masterplan/' . $masterplan->masterplan_doc) }}" download><i class="fa fa-file fa-3x" aria-hidden="true"></i></a>
                                            @else
                                            <h6><span class="badge badge-danger">no file</span></h6>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <div class="form-group">
                                                <label for="masterplan_doc">মাস্টারপ্লান আপলোড:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="file" class="form-control" name="masterplan_doc" id="masterplan_doc" />
                                            @if ($errors->has('masterplan_doc'))
                                            <p class="text-danger">
                                                <small>{{ $errors->first('masterplan_doc') }}</small>
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-lg btn-dark float-right">Update
                                    Masterplan</button>
                            </div>
                            {{ html()->closeModelForm() }}
                        </div>
                        <div class="tab-pane fade" id="plots" role="tabpanel" aria-labelledby="plots-tab">
                            {{ html()->modelForm($masterplan, 'PUT', route('admin.masterplan-plot.update', $masterplan))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}
                            <div class="row mt-4">
                                <div class="col-12">
                                    <button type="button" class="btn btn-outline-primary addMasterPlanPlot mb-2 float-right" data-key="{{ count($masterplan->masterPlanPlot) > 0 ? count($masterplan->masterPlanPlot) : 1 }}"><i class="fa fa-plus"></i> Add Plots</button>

                                    <input type="hidden" name="masterplan_id" value="{{ $masterplan->id }}">

                                    <table class="table table-bordered" id="mouja-plot">
                                        <tr>
                                            <td>
                                                <label for="plot_number">প্লট নম্বর:</label>
                                            </td>
                                            <td>
                                                <label for="plot_length">প্লটের দৈর্ঘ্য (ফুট) :</label>
                                            </td>
                                            <td>
                                                <label for="plot_width">প্লটের প্রস্থ (ফুট):</label>
                                            </td>
                                            <td>
                                                <label for="total_sft">প্লটের পরিমাপ(বর্গফুট):</label>
                                            </td>
                                            <td>
                                                <label for="plot_size">মন্তব্য:</label>
                                            </td>
                                            <td>
                                                <label for="action">প্রক্রিয়া</label>
                                            </td>
                                        </tr>
                                        @if ($masterplan->masterPlanPlot && count($masterplan->masterPlanPlot) > 0)
                                        @foreach ($masterplan->masterPlanPlot as $key => $plot)
                                        <input name="key" class="key" type="hidden" value="{{ count($masterplan->masterPlanPlot) > 0 ? $masterplan->masterPlanPlot->count() : 1 }}">
                                        <tr>
                                            <td>
                                                <input type="hidden" name="masterplan_id" value="{{ $masterplan->id }}">
                                                <input type="hidden" name="masterplan_plot[{{ $key }}][masterplanplot_id]" value="{{ $plot->id }}">
                                                <input type="text" class="form-control" name="masterplan_plot[{{ $key }}][plot_number]" id="plot_number_{{ $key }}" value="{{ $plot->plot_number }}" placeholder="প্লট নম্বর">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control mr-1 plot_length ledger_amount" name="masterplan_plot[{{ $key }}][plot_length]" data-target="#total_sft_{{ $key }}" id="plot_length_{{ $key }}" value="{{ $plot->plot_length }}" placeholder="প্লটের সাইজ(দৈর্ঘ্য)" data-height="#plot_width_{{ $key }}" data-target2="#plot_size_{{ $key }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control ledger_amount plot_width" name="masterplan_plot[{{ $key }}][plot_width]" id="plot_width_{{ $key }}" value="{{ $plot->plot_width }}" placeholder="প্লটের সাইজ(প্রস্থ)" data-target="#total_sft_{{ $key }}" data-target2="#plot_size_{{ $key }}" data-height="#plot_length_{{ $key }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="masterplan_plot[{{ $key }}][total_sft]" value="{{ $plot->total_sft }}" id="total_sft_{{ $key }}" placeholder="প্লটের সাইজ(স্কয়ারফিট)">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="masterplan_plot[{{ $key }}][plot_comments]" id="plot_comments_{{ $key }}" value="{{ $plot->plot_comments }}" placeholder="মন্তব্য">
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.masterplan-plot.destroy', $plot->id) }}" type="button" data-method="delete" class="btn btn-outline-danger"><i class="fa fa-minus"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td style="width: 15%;">
                                                <input type="text" class="form-control" name="masterplan_plot[0][plot_number]" id="plot_number_0" placeholder="প্লট নম্বর">
                                            </td>
                                            <td>
                                                <input type="test" class="form-control mr-1 plot_length numeric_number" name="masterplan_plot[0][plot_length]" id="plot_length_0" data-target="#total_sft_0" data-target2="#plot_size_0" placeholder="প্লটের সাইজ(দৈর্ঘ্য)" data-height="#plot_width_0">
                                            </td>
                                            <td>
                                                <input type="test" class="form-control plot_width numeric_number" name="masterplan_plot[0][plot_width]" id="plot_width_0" placeholder="প্লটের সাইজ(প্রস্থ)" data-target="#total_sft_0" data-target2="#plot_size_0" data-height="#plot_length_0">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="masterplan_plot[0][total_sft]" id="total_sft_0" placeholder="প্লটের সাইজ(স্কয়ারফিট)">
                                                <input type="hidden" class="form-control" name="masterplan_plot[0][plot_size]" id="plot_size_0" placeholder="মোট জমির পরিমান">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="masterplan_plot[0][plot_comments]" id="plot_comments_0" placeholder="মন্তব্য">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary addMasterPlanPlot" data-key="1"><i class="fa fa-plus"></i></button>
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary float-right">UPDATE
                                            NOW</button>
                                    </div>
                                </div>
                            </div>
                            {{ html()->closeModelForm() }}
                        </div>
                    </div>
                </div>
            </div>
    </x-slot>
</x-backend.card>

@endsection