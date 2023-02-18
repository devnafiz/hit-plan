@extends('frontend.layouts.app')

@section('title', __('Url Shortner'))

@section('content')
<div class="container">
    <div class="row justify-content-center mt-3">
        <div class="col-md-9 col-sm-12 m-3" style="border-style: dotted;">
            <div class="tab-content" id="myTabContent">

                <div class="tab-pane {{ session()->get('stepper') == 'step-two' ? 'show active' : 'show active' }}" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                    <div class="mb-4 mt-2">
                        <h5 class="d-flex justify-content-center">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</h5>
                        <h5 class="d-flex justify-content-center">বিভাগীয় ভূ-সম্পত্তি কর্মকর্তার কার্যালয়</h5>
                        <h5 class="d-flex justify-content-center">বাংলাদেশ রেলওয়ে, লালমনিরহাট।</h5>
                        <h6 class="d-flex justify-content-center">
                            <b>দরপত্রের মাধ্যমে বাণিজ্যিক কাজের জন্য রেলভূমি
                                অস্থায়ী লাইসেন্স প্রাপ্তির দরপত্র সিডিউল।</b>
                        </h6>
                        <br>
                    </div>

                    {{ html()->form('POST', route('frontend.tender.applied'))->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}

                    <input type="hidden" id="plot-length-width" value="{{ route('frontend.tender.plot') }}">
                    <input type="hidden" id="tender_id" name="tender_id" value="{{ $tender->id }}">
                    <input type="hidden" id="stepper" name="stepper" value="step_one">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <label>১. দরপত্র দাতার নাম/প্রতিষ্ঠানের নাম:</label>
                            </div>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" value="{{ old('applicant_name') }}" name="applicant_name" aria-describedby="emailHelp" placeholder="দরপত্র দাতার নাম/প্রতিষ্ঠানের নাম" required>
                                @if ($errors->has('applicant_name'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('applicant_name') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-3">
                            <div class="row">
                                <div class="col-md-4 mb-0">
                                    <label for="">2.</label>
                                </div>
                                <div class="col-md-4 mb-0">
                                    <div class="form-group">
                                        <input class="form-check-input mt-0" type="radio" name="flexRadioDefault" value="father_name" id="flexCheckDefault" checked>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            পিতা
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-0">
                                    <div class="form-check">
                                        <input class="form-check-input mt-0" type="radio" name="flexRadioDefault" value="husband_name" id="flexCheckDefault2">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            স্বামী
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input mt-0" type="radio" name="flexRadioDefault" value="mother_name" id="flexCheckDefault3">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            মাতা
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input mt-0" type="radio" name="flexRadioDefault" value="propitor_name" id="flexCheckDefault4">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            প্রোপাইটার
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control" name="applicant_gadiant" aria-describedby="emailHelp" placeholder="পিতা/স্বামী/মাতা/প্রোপাইটার নাম">
                            @if ($errors->has('applicant_gadiant'))
                            <p class="text-danger">
                                <small>{{ $errors->first('applicant_gadiant') }}</small>
                            </p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <label>৩. বয়স:</label>
                            </div>
                            <div class="col-md-9 col-sm-12">
                                <input type="number" name="age" value="{{ old('age') }}" class="form-control" aria-describedby="emailHelp" placeholder="বয়স">
                                @if ($errors->has('age'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('age') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <label>৪. পেশা:</label>
                            </div>
                            <div class="col-md-9 col-sm-12">
                                <input type="text" name="profession" value="{{ old('profession') }}" class="form-control" aria-describedby="emailHelp" placeholder="পেশা">
                                @if ($errors->has('profession'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('profession') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <label>৫. বর্তমান ঠিকানা:</label>
                            </div>

                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 pr-1">
                                        <labe class="font-weight-light">গ্রাম/মহল্লা:</labe>
                                        <input type="text" value="{{ old('present_village') }}" name="present_village" class="form-control" placeholder="গ্রাম/মহল্লা">
                                        @if ($errors->has('present_village'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('present_village') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                    <div class="col-md-6 col-sm-12 pl-1">
                                        <labe class="font-weight-light">পো:</labe>
                                        <input type="text" value="{{ old('present_post') }}" name="present_post" class="form-control" placeholder="পো">
                                        @if ($errors->has('present_post'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('present_post') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6 col-sm-12 pr-1">
                                        <label class="font-weight-light">থানা:</label>
                                        <input type="text" value="{{ old('present_thana') }}" name="present_thana" class="form-control" aria-describedby="emailHelp" placeholder="থানা">
                                        @if ($errors->has('present_thana'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('present_thana') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                    <div class="col-md-6 col-sm-12 pl-1">
                                        <label class="font-weight-light">জেলা:</label>
                                        <input type="text" value="{{ old('present_district') }}" name="present_district" class="form-control" aria-describedby="emailHelp" placeholder="জেলা">
                                        @if ($errors->has('present_district'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('present_district') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <label>৬. স্থায়ী ঠিকানা:</label>
                            </div>

                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 pr-1">
                                        <labe class="font-weight-light">গ্রাম/মহল্লা:</labe>
                                        <input type="text" value="{{ old('permanent_village') }}" name="permanent_village" class="form-control" placeholder="গ্রাম/মহল্লা">
                                        @if ($errors->has('permanent_village'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('permanent_village') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                    <div class="col-md-6 col-sm-12 pl-1">
                                        <labe class="font-weight-light">পো:</labe>
                                        <input type="text" value="{{ old('permanent_post') }}" name="permanent_post" class="form-control" placeholder="পো">
                                        @if ($errors->has('permanent_post'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('permanent_post') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6 col-sm-12 pr-1">
                                        <label class="font-weight-light">থানা:</label>
                                        <input type="text" value="{{ old('permanent_thana') }}" name="permanent_thana" class="form-control" aria-describedby="emailHelp" placeholder="থানা">
                                        @if ($errors->has('permanent_thana'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('permanent_thana') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                    <div class="col-md-6 col-sm-12 pl-1">
                                        <label class="font-weight-light">জেলা:</label>
                                        <input type="text" value="{{ old('permanent_district') }}" name="permanent_district" class="form-control" aria-describedby="emailHelp" placeholder="জেলা">
                                        @if ($errors->has('permanent_district'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('permanent_district') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>৭. জাতীয় পরিচয়পত্র নং/জন্ম নিবন্ধন সনদ (সত্যায়িত কপি সংযুক্ত করতে হবে)।</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <input type="file" name="nid_copy" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <label>৮. আবেদনকৃত প্লটের তফসিল ও বিবরণ:</label>
                        </div>

                        <div class="col-md-9 col-sm-12">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 pr-1">
                                    <div class="form-group">
                                        <label class="font-weight-light">(ক) ষ্টেশন/এলাকা:</label>
                                        <input type="text" class="form-control pr-1" name="station" aria-describedby="emailHelp" value="{{ $tender->stationDetails->station_name }}" placeholder="ষ্টেশন/এলাকা" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12 pl-1">
                                    <div class="form-group">
                                        <label class="font-weight-light">(খ) মাষ্টারপ্ল্যান নং:</label>
                                        <input readonly type="text" class="form-control" name="masterplan_no" aria-describedby="emailHelp" value="{{ $tender->masterplanDetails->masterplan_no }}" placeholder="মাষ্টারপ্ল্যান নং">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="font-weight-light">(গ) প্লট নং:</label>
                                        <select class="form-control" name="plot_id" id="plot_length_width">
                                            <option value="">প্লট নং</option>
                                            @foreach ($tender->tenderPlotDetails as $plot)
                                            <option value="{{ $plot->id }}">{{ $plot->plot_number }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('plot_id'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('plot_id') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-12 pr-1">
                                    <div class="form-group">
                                        <label class="font-weight-light">(ঘ) দৈর্ঘ্য:</label>
                                        <div class="form-group">
                                            <input readonly type="text" class="form-control" placeholder="দৈর্ঘ্য" name="plot_length" id="plot_length">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sd-12 pl-1">
                                    <label class="font-weight-light">প্রস্থ:</label>
                                    <div class="form-group">
                                        <input readonly type="text" class="form-control" placeholder="প্রস্থ" name="plot_width" id="plot_width">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="font-weight-light">বর্গফুট:</label>
                                    <div class="form-group">
                                        <input readonly type="text" class="form-control" name="total_sft" id="total_sft" placeholder="বর্গফুট">
                                        <input type="hidden" id="total_sft_numeric">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <label>৯. প্লটের জন্য উদ্ধৃত দর:</label>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label>(ক) প্রতি বর্গফুটের জন্য এককালীন উদ্ধৃত দর <strong>(প্রতি বর্গফুটের
                                                সরকারি
                                                দর
                                                {{ $tender_rate->com_rate }} টাকা)</strong></label>
                                        <input type="hidden" value="{{ $tender_rate->com_rate }}" id="station_tender_rate">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 pr-1">
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">টাকা</span>
                                                    </div>
                                                    <input type="text" class="form-control transform_number_one" id="per_acore_amount" name="per_acore_amount" placeholder="(অংকে)">
                                                    @if ($errors->has('per_acore_amount'))
                                                    <p class="text-danger">
                                                        <small>{{ $errors->first('per_acore_amount') }}</small>
                                                    </p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 pl-1">
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">টাকা</span>
                                                    </div>
                                                    <input type="text" class="form-control transform_number_value_one" id="" placeholder="(কথায়)" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label>(খ) প্লটের জন্য এককালীন মোট উদ্ধৃত দর </label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 pr-1">
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">টাকা</span>
                                                    </div>
                                                    <input type="text" class="form-control transform_number_two" id="plot_total_onetimeamout" name="plot_total_onetimeamout" placeholder="(অংকে)" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 pl-1">
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">টাকা</span>
                                                    </div>
                                                    <input type="text" class="form-control transform_number_value_two" id="plot_total_onetimeInword" placeholder="(কথায়)" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <label>১0. জামানতের টাকার পরিমান ও বিবরন:</label>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label>(ক) মোট উদ্ধৃত দরের (ক্রমিক-৯ (খ) এর উপর) ২৫% (শতকরা পঁচিশ ভাগ) হিসাবে
                                            বায়নার পরিমান:
                                        </label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 pr-1">
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">টাকা</span>
                                                    </div>
                                                    <input type="text" class="form-control transform_number_three" name="per_acore_percentage" id="per_acore_percentage" placeholder="(অংকে)" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 pl-1">
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">টাকা</span>
                                                    </div>
                                                    <input type="text" class="form-control transform_number_value_three" name="per_acore_inword" id="per_acore_percentage_inword" placeholder="(কথায়)" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label>(খ) বায়নার টাকার ডিডি/পে-অর্ডার নং- </label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 pr-1">
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">টাকা</span>
                                                    </div>
                                                    <input type="text" class="form-control transform_number_four" id="payorder_no" name="payorder_no" placeholder="(অংকে)">
                                                    @if ($errors->has('payorder_no'))
                                                    <p class="text-danger">
                                                        <small>{{ $errors->first('payorder_no') }}</small>
                                                    </p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 pl-1">
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">টাকা</span>
                                                    </div>
                                                    <input type="text" name="advance_inword" id="advance_inword" class="form-control transform_number_value_four" placeholder="(কথায়)">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>১১. সংযুক্তির বিবরণ: </label>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        <input type="file" name="attachment_one" class="form-control custom-file-input" id="inputGroupFile01" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" name="terms_and_conditions" type="checkbox" id="flexCheckDefault" required>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        আমি এই মর্মে ঘোষণা করছি যে, উপরিল্লিখিত তথ্যাদি সত্য। এতে কোন তথ্য গোপন করি নাই,
                                        করলে আইনতঃ
                                        দায়ী থাকব।
                                        আমি
                                        অত্র দরপত্র দলিরের প্রতিটি শর্ত পড়েছি ও বুঝেছি। আমি বাংলাদেশ রেলওয়ের জমি-জমা
                                        সংক্রান্ত জারীকৃত
                                        ও
                                        জারীতব্য
                                        নীতিমালা এবং দরপত্রের শর্তবলী ও নির্দেশাবলী মেনে চলতে বাধ্য থাকবো। এ মর্মে
                                        অঙ্গীকার
                                        করে এ
                                        দরপত্র দাখিল
                                        করলাম।
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <p class="d-flex justify-content-center">(তারিখ)</p>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">তারিখ:</span>
                                    </div>
                                    <input type="date" name="application_date" class="form-control" placeholder="মোবাইল নম্বর" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <p class="d-flex justify-content-center">(দরপত্র দাতার স্বাক্ষর)</p>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">মোবাইল:</span>
                                    </div>
                                    <input type="text" value="{{ old('applicant_phone') }}" name="applicant_phone" class="form-control" placeholder="মোবাইল নম্বর" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group m-2">
                            <label class="form-check-label" for="flexCheckDefault">
                                বি:দ্র: প্রথম বৎসরের লাইসেন্স ফি গৃহীত দরে থোক পাকার ভিত্তিতে এককালীন পরিশোধ সাপেক্ষে
                                চুক্তিপত্র
                                সম্পাদন
                                করতে হবে। পরবর্তীতে সরকার কর্তৃক নির্ধারিত হারে লাইসেন্স ফি প্রদান করতে হবে। বর্তমানে
                                লালমনিরহাট
                                ষ্টেশন
                                এলাকায় বাণিজ্যিক ভূমির রাইসেন্স ফি সরকার কর্তৃক প্রতি বর্গপুট ১৫/- বার্ষিক নির্ধারিত আছে
                                এবং
                                কোন
                                অবস্থাতেই
                                ১৫/- টাকার কমে উদ্ধৃত দর গ্রহণযোগ্য হবেনা।
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group float-right">
                                <a href="#" type="submit" class="btn btn-primary">Apply Now</a>
                            </div>
                        </div>
                    </div>
                    {{ html()->form()->close() }}
                </div>

                <div class="tab-pane {{ session()->get('stepper') == 'step-two' ? 'show active' : 'fade' }}" </div>
                </div>

                <div class="tab-pane {{ session()->get('stepper') == 'step-two' ? 'show active' : 'fade' }}" </div>
                </div>
            </div>
        </div>
    </div>

    @endsection

    @push('after-styles')
    <livewire:styles />
    @endpush

    @push('after-scripts')
    <livewire:scripts />
    @endpush