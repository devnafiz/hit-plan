@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('নতুন সংস্থা লাইসেন্স যুক্ত করুন'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('নতুন সংস্থা লাইসেন্স যুক্ত করুন')
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

        
        {{ html()->modelForm($license, 'PUT', route('admin.agency.update', $license))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}
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
            <div class="col-md-12">
                <div class="col-md-12 bg-light text-justify mb-3">
                    <label class="mt-1">লাইসেন্সীর তথ্য</h6>
                </div>
                @foreach ($license->agencyOwner as $key=>$owner)
                <input type="hidden" value="{{ $owner->id }}" name="owner[{{ $key }}][id]" />
                <div class="row" id="license_owner_repeat_item_0">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="owner_name_0">সংস্থার নাম</label>
                            <input type="text" id="owner_name_0" class="form-control"  name="owner[0][name]"  value="{{ $owner->name }}"  required />
                        </div>

                        <div class="form-group">
                           

                            <div class="form-group mt-1">
                            <label class="form-check-label" for="fatherName">
                                 পদবী
                                </label>
                                <input type="text" id="agency_position" class="form-control" name="owner[0][agency_position]" value="{{ $owner->agency_position }}"  />
                            </div>

                        </div>
                       
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mobile_0">মোবাইল নং</label>
                            <input type="number" id="mobile_0"  name="owner[0][phone]"  class="form-control" value="{{ $owner->phone }}"  maxlength="15" />
                        </div>
                        <div class="form-group">
                            <label for="address_0">ঠিকানা</label>
                            <textarea name="owner[0][address]" id="address_0" class="form-control" cols="30" rows="5"> {{ $owner->address }}</textarea>
                        </div>
                    </div>

                    <!-- <div class="col-md-2 mt-4">
                        <button type="button" id="license-owner" class="btn btn-primary">Add more</button>
                    </div> -->

                </div>

               @endforeach


               <div class="col-md-12 bg-light text-justify mt-4 mb-3">
                    <label class="mt-1">সর্বশেষ লাইসেন্স ফি পরিশোধের সময়কাল</h6>
                </div>

                @php
                $last_from_day = null;
                $last_from_month = null;
                $last_from_year = null;
                $last_to_day = null;
                $last_to_month = null;
                $last_to_year = null;
                $balam_id = null;

                if ($last_payment_date) {
                $balam_id = $last_payment_date['balam_id'];
                if (array_key_exists('from_date', $last_payment_date) && $last_payment_date['from_date']) {
                $last_from_day = $last_payment_date['from_date']['day'] ?? null;
                $last_from_month = $last_payment_date['from_date']['month'] ?? null;
                $last_from_year = $last_payment_date['from_date']['year'] ?? null;
                }
                if (array_key_exists('to_date', $last_payment_date) && $last_payment_date['to_date']) {
                $last_to_day = $last_payment_date['to_date']['day'] ?? null;
                $last_to_month = $last_payment_date['to_date']['month'] ?? null;
                $last_to_year = $last_payment_date['to_date']['year'] ?? null;
                }
                }

                @endphp

                <div class="col-12">
                    <input type="hidden" name="balam_id" value="{{ $balam_id }}">
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="demand_notice_number">হতে:</label>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="hidden" id="type" value="1">
                                <select class="form-control" name="from_date[license_fee_from_dd]" id="license_fee_from_dd">
                                    <option value="">তারিখ</option>
                                    @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}" @if ($last_from_day==$i) selected @endif>{{ $i }}
                                        </option>
                                        @endfor
                                </select>
                            </div>
                            @if ($errors->has('license_fee_from_dd'))
                            <p class="text-danger">
                                <small>{{ $errors->first('license_fee_from_dd') }}</small>
                            </p>
                            @endif
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="hidden" id="type" value="1">
                                <select class="form-control" name="from_date[license_fee_from_mm]" id="license_fee_from_mm">
                                    <option value="">মাস</option>
                                    @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}" @if ($last_from_month==$i) selected @endif>
                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                        @endfor
                                </select>
                            </div>
                            @if ($errors->has('license_fee_from_mm'))
                            <p class="text-danger">
                                <small>{{ $errors->first('license_fee_from_mm') }}</small>
                            </p>
                            @endif
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="hidden" id="type" value="1">
                                <select class="form-control" name="from_date[license_fee_from_yy]" id="license_fee_from_yy">
                                    <option value="">বছর</option>
                                    @for ($i = date('Y'); $i >= 1893; $i--)
                                    <option value="{{ $i }}" @if ($last_from_year==$i) selected @endif>
                                        {{ $i }}
                                    </option>
                                    @endfor
                                </select>
                            </div>
                            @if ($errors->has('license_fee_from_yy'))
                            <p class="text-danger">
                                <small>{{ $errors->first('license_fee_from_yy') }}</small>
                            </p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="demand_notice_date">পর্যন্ত:</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control" name="to_date[license_fee_to_dd]" id="license_fee_to_mm">
                                    <option value="">তারিখ</option>
                                    @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}" @if ($last_to_day==$i) selected @endif>{{ $i }}
                                        </option>
                                        @endfor
                                </select>
                            </div>
                            @if ($errors->has('license_fee_to_mm'))
                            <p class="text-danger">
                                <small>{{ $errors->first('license_fee_to_mm') }}</small>
                            </p>
                            @endif
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control" name="to_date[license_fee_to_mm]" id="license_fee_to_mm">
                                    <option value="">মাস</option>
                                    @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}" @if ($last_to_month==$i) selected @endif>
                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                        @endfor
                                </select>
                            </div>
                            @if ($errors->has('license_fee_to_mm'))
                            <p class="text-danger">
                                <small>{{ $errors->first('license_fee_to_mm') }}</small>
                            </p>
                            @endif
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="to_date[license_fee_to_yy]" id="license_fee_to_yy">
                                    <option value="">বছর</option>
                                    @for ($i = date('Y'); $i >= 1893; $i--)
                                    <option value="{{ $i }}" @if ($last_to_year==$i) selected @endif>
                                        {{ $i }}
                                    </option>
                                    @endfor
                                </select>
                            </div>
                            @if ($errors->has('license_fee_to_yy'))
                            <p class="text-danger">
                                <small>{{ $errors->first('license_fee_to_yy') }}</small>
                            </p>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="col-md-12 bg-light text-justify mt-4 mb-3">
                    <label class="mt-1">ফি সংক্রান্ত তথ্য</h6>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="demand_notice_number">ডিমান্ড নোটিশের নং এবং নোটিশের তারিখ :</label>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <textarea cols="100" rows="5" type="text" class="form-control"name="demand_notice_number" id="demand_notice_number">{{ $license->demand_notice_number }} </textarea>
                        </div>
                    </div>
 
                </div>

                <div class="col-md-12 bg-light text-justify mt-2 mb-3">
                    <label class="mt-1">এলাকা সংক্রান্ত তথ্য</h6>
                </div>

                <!-- division-->

            @foreach ($agencyMoujas as $key => $agmouja)      
                
            <div class="col-12">
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="division_id">বিভাগের নাম:</label>
                            </div>
                        </div>
                       
                        <div class="col-md-3">
                            <select required id="division_id_" class="form-control division_id" name="mouja[{{$key}}][division_id]" data-target="#kachari_id_{{$key}}" required>
                                <option value="" disabled selected>বাছাই করুন</option>
                                @foreach ($division as $divisions_name)
                                <option value="{{ $divisions_name->division_id }}" {{($agmouja->division_id==$divisions_name->division_id )?'selected':''}}>
                                    {{ $divisions_name->division_name }}
                                </option>
                                @endforeach
                            </select>
                          </div>
                        <div class="col-md-2 ">
                        <a href="{{route('admin.agency.division.delete',$agmouja->id)}}"  data-method="delete-post" class="btn btn-outline-danger"><i class="fa fa-trash"></i></a> 
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
                        {{ html()->select('mouja[' . $key . '][kachari_id]', $kacharis->pluck('kachari_name', 'kachari_id'), $agmouja->kachari_id)->class('form-control kachari_id')->attribute('data-target', '#district_id_' . $key)->id('kachari_id_' . $key) }}
                        </div>
                    </div>
                 

                <div class="row">
                    <div class="col-md-2 text-right">
                        <div class="form-group">
                            <label for="district_id">জেলার নাম:</label>
                        </div>
                    </div>    
                        <div class="col-md-3">
                        {{ html()->select('mouja[' . $key . '][district_id]', $districtes->pluck('district_name', 'district_id'), $agmouja->district_id)->class('form-control district_id')->attribute('data-target', '#upazila_id_' . $key)->id('district_id_' . $key) }}
                        </div>
                    
                </div>

                


                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="upazila_id">উপজেলার নাম:</label>
                            </div>
                        </div>
                        <?php //echo $agmouja->upazila_id;?>
                        <div class="col-md-3">
                        {{ html()->select('mouja[' . $key . '][upazila_id]', $upazila->pluck('upazila_name', 'upazila_id'), $agmouja->upazila_id)->class('form-control upazila_id')->attribute('data-target', '#station_id_' . $key)->id('upazila_id_' . $key) }}
                        <!-- <select required id="upazila_id_{{ $key }}" class="form-control upazila_id" name="mouja[0][upazila_id]" data-target="#upazila_id_{{$key}}" required>
                                <option value="" disabled selected>বাছাই করুন</option>
                                @foreach ($upazila as $u)
                                <option value="{{$u->upazila_id}}" {{($agmouja->upazila_id==$u->upazila_id )?'selected':''}}>
                                    {{ $u->upazila_name }}
                                </option>
                                @endforeach
                            </select> -->
                       
                        </div>
                    </div>
                   
               

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="station_id">স্টেশনের নাম:</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                        {{ html()->select('mouja[' . $key . '][station_id]', $stations->pluck('station_name', 'station_id'), $agmouja->station_id)->class('form-control station_id')->attribute('data-target', '#mouja_id_' . $key)->id('station_id_' . $key) }}
                            <!-- <select required class="form-control station_id" id="station_id_0" name="mouja[0][station_id]" data-target="#mouja_id_0" required>
                                <option selected disabled>স্টেশন বাছাই করুন</option>
                            </select> -->
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
                        <th>লীজকৃত জমির পরিমাণ (বর্গফুট)</th>


                    </tr>
                    <tr>
                        <td style="width: 10%;">
                            <!-- <select class="form-control mouja_id" id="mouja_id_0" data-target="#record_name_0" name="mouja[0][mouja_id]" required>
                                <option selected disabled>মৌজা</option>
                            </select> -->
                            {{ html()->select('mouja[' . $key . '][mouja_id]', $mouja->pluck('mouja_name', 'mouja_id'), $agmouja->mouja_id)->class('form-control mouja_id2')->attribute('data-target', '#record_name_' . $key)->id('mouja_id_' . $key) }}
                        </td>

                        <td style="width: 10%;">
                        {{ html()->select('mouja[' . $key . '][record_name]', collect($records), $agmouja->record_name)->class('form-control record_name')->attribute('data-target', '#ledger_id_' . $key)->attribute('data-previous', 'mouja_id_' . $key)->id('id', 'record_name_' . $key) }}
                        </td>

                        <td style="width: 10%;">

                           @php
                            $ledgeres = App\Models\Backend\ledger::where('station_id',$agmouja->station_id)->where('mouja_id',$agmouja->mouja_id)->get();
                            
                           @endphp

                           <select class="form-control ledger_id" id="ledger_id_{{ $key }}"
                                                data-target="#plot_id_{{ $key }}"
                                                name="mouja[{{ $key }}][ledger_id]">
                                                <option disabled>খতিয়ান নম্বর</option>
                                                @foreach ($ledgeres as $ledger)
                                                    @if ($ledger != null)
                                                   
                                                        <option value="{{ $ledger->id }}"
                                                            @if ($ledger && $ledger->id == $agmouja->ledger_id) selected @endif>
                                                            {{ $ledger->ledger_number }}  
                                                        </option>
                                                    @endif
                                               
                                                @endforeach
                            </select>
                            <!-- <select class="form-control ledger_id" id="ledger_id_0" data-target="#plot_id_0" name="mouja[0][ledger_id]">
                                <option selected disabled>খতিয়ান নম্বর</option>
                            </select> -->
                        </td>

                        <td style="width: 20%;">
                        @php
                                                $moujaPlot = json_decode($agmouja->plot_id, true);
                                                $totalLandAmount = 0;
                                                $ledgerPlots = $plots->where('ledger_id', $agmouja->ledger_id);
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
                           <input type="text" name="mouja[{{$key}}][property_amount]" id="mouja_total_amount1_{{$key}}" placeholder="জমির পরিমাণ" class="form-control" value="{{ $agmouja->property_amount }}" />
                        </td>




                    </tr>

                </table>
            </div>
                
                  


        </div>
       @endforeach 
        <div class="col-md-12">
            <div id="dynamic-wholedivision"></div>
        </div>

                <!-- end-- division-->


                <div class="col-md-12 bg-light text-justify mt-4 mb-3">
                    <label class="mt-1">চৌহদ্দি সংক্রান্ত তথ্য</h6>
                </div>

                <div class="col-12">
                   <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="demand_notice_number">নকসা নং এবং তারিখ :</label>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <textarea cols="100" rows="5" type="text" class="form-control"  name="design_and_date" id="design_and_date" placeholder="নকসা নং এবং তারিখ">{{ $license->design_and_date}}</textarea>
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="demand_notice_number">অন্যান্য :</label>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <textarea cols="100" rows="5" type="text" class="form-control"  name="others" id="others">{{ $license->others}}</textarea>
                        </div>
                    </div>
                   
                    <br/>
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="form-group">
                                <label for="exampleFormControlFile2">অনুমোদনের কপি আপলোড করুন: </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="file" class="form-control" name="land_map_certificate" id="exampleFormControlFile2" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-lg btn-dark float-right">Update New License</button>
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