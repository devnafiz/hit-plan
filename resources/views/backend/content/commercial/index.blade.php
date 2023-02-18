@extends('backend.layouts.app')

@section('title', __('বাণিজ্যিক লাইসেন্স তৈরি'))

@section('content')

<x-backend.card xmlns:livewire="">
    <x-slot name="header">
        @lang('বাণিজ্যিক লাইসেন্স সমূহ')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header icon="fas fa-plus" class="btn btn-sm btn-tool btn-primary" :href="route('admin.commercial.create')" :text="__('লাইসেন্স তৈরি')" />
    </x-slot>

    <x-slot name="body">
        <div class="row report-params p-3" style="border: solid #d9d9d9 3px;">
            <form action="{{ route('admin.commercial.index') }}" method="GET">
                <input type="hidden" id="kachari" value="{{ route('admin.ledger.fetch-kachari') }}">
                <input type="hidden" id="district" value="{{ route('admin.ledger.fetch-district') }}">
                <input type="hidden" id="upazila" value="{{ route('admin.ledger.fetch-upazila') }}">
                <input type="hidden" id="mouza" value="{{ route('admin.ledger.fetch-mouja') }}">
                <input type="hidden" id="station" value="{{ route('admin.ledger.fetch-station') }}">
                <input type="hidden" id="record" value="{{ route('admin.ledger.fetch-record') }}">

                <div class="row">
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="division_id">বিভাগের নাম:</label>
                            {{ html()->select('division_id', collect($division)->prepend('বাছাই করুন', ''), request()->get('division_id'))->class('form-control')->id('division_id') }}
                            <p class="text-danger error mt-2"></p>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="kachari_id">কাচারীর নাম:</label>
                            {{ html()->select('kachari_id', collect($kachari)->prepend('বাছাই করুন', ''), request()->get('kachari_id'))->class('form-control')->id('kachari_id') }}
                            <p class="text-danger error mt-2"></p>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="district_id">জেলার নাম:</label>
                            {{ html()->select('district_id', collect($district)->prepend('বাছাই করুন', ''), request()->get('district_id'))->class('form-control')->id('district_id') }}
                            <p class="text-danger error mt-2"></p>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="upazila_id">উপজেলার নাম:</label>
                            {{ html()->select('upazila_id', collect($upazila)->prepend('বাছাই করুন', ''), request()->get('upazila_id'))->class('form-control')->id('upazila_id') }}
                            <p class="text-danger error mt-2"></p>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="station_id">স্টেশনের নাম:</label>
                            {{ html()->select('station_id', collect($station)->prepend('বাছাই করুন', ''), request()->get('station_id'))->class('form-control')->id('station_id') }}
                            <p class="text-danger error mt-2"></p>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="license_no">লাইসেন্স নং:</label>
                            <input type="text" class="form-control" id="license_no" name="license_no" placeholder="লাইসেন্স নং" />
                            <p class="text-danger error mt-2"></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <button type="submit" name="next" class="btn btn-block btn-primary">
                                <i class="fa fa-search" aria-hidden="true"></i> Search
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <br>
        @if ($searchResult)
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">Select<input type="checkbox" id="allSelectCheckbox" name="allSelectCheckbox"></th>
                            <th class="w-10 text-center align-middle">নং</th>
                            <th class="text-center align-middle">লাইসেন্স নং</th>
                            <th class="text-center align-middle">লাইসেন্সীর তথ্য</th>
                            <th class="text-center align-middle">কাচারী নাম</th>
                            <th class="text-center align-middle">স্টেশনের নাম</th>
                            <th class="text-center align-middle">তফসিল</th>
                            <th class="text-center align-middle">সর্বশেষ লাইসেন্স ফি পরিশোধের সময়কাল</th>
                            <th class="text-center align-middle">অনুমোদনর তারিখ</th>
                            <th class="text-center align-middle">চৌহদ্দি সংক্রান্ত তথ্য</th>
                            <!-- <th class="text-center align-middle">লাইসেন্স অনুমোদনর কপি</th> -->
                            <th class="text-center align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($searchResult as $key => $serValue)
                        @php
                        $sr_no = $key + $searchResult->firstItem();
                        $balam = balam_year($serValue->balam, 'commercial');
                        $license_date_from = $balam['from_date'];
                        $license_date_to = $balam['to_date'];
                        @endphp
                        <tr>
                            <td class="text-center align-middle"><input type="checkbox" class="checkboxItem" name="checkboxItem" id="checkboxItem"></td>
                            <td class="text-center align-middle">{{ $sr_no }}</td>
                            <td class="text-center align-middle"><a href="{{ route('admin.commercial.show', $serValue) }}">{{ $serValue->generated_id ?? 'N/A' }}</a>
                            </td>
                            <td class="w-25">
                                @foreach ($serValue->commercialOwner as $owner)
                                <p>
                                    <strong>লাইসেন্সীর নাম:
                                    </strong>{{ $owner->name ?? 'N/A' }}<br>
                                    @if ($owner->father_name)
                                    <strong>পিতার নাম:
                                    </strong>{{ $owner->father_name ?? 'N/A' }}<br>
                                    @endif
                                    @if ($owner->husband_name)
                                    <strong>স্বামীর নাম:
                                    </strong>{{ $owner->husband_name ?? 'N/A' }}<br>
                                    @endif
                                    <strong>ঠিকানা: </strong>{{ $owner->address }}<br>
                                    <strong>মোবাইল: </strong>{{ $owner->phone }}<br>
                                    <strong>এনআইডি: </strong>{{ $owner->nid }}<br>
                                </p>
                                @endforeach
                            </td>

                            <td class="text-center align-middle">
                                {{ $serValue->kachari->kachari_name ?? 'N/A' }}
                            </td>

                            <td class="text-center align-middle">
                                {{ $serValue->station->station_name ?? 'N/A' }}
                            </td>

                            <td class="w-25">
                                <?php $license_moujas = commercial_license_moujas($serValue->commercialMoujas); ?>
                                <strong>মৌজা: </strong>{{ $license_moujas['moujas'] ?? 'N/A' }}<br>
                                <strong>খতিয়ান নং: </strong>{{ $license_moujas['ledgers'] ?? 'N/A' }}<br>
                                <strong>রেকর্ড: </strong>{{ $license_moujas['records'] ?? 'N/A' }}<br>
                                <strong>মাস্টারপ্ল্যান নং:
                                </strong>{{ $license_moujas['masterplan_no'] ?? 'N/A' }}<br>
                                <strong>মাস্টারপ্ল্যানের প্লট নং:
                                </strong>{{ $license_moujas['com_license_plots'] ?? 'N/A' }}<br>

                                <strong>প্লটের সাইজ(দৈর্ঘ্য):
                                </strong>{{ $license_moujas['plot_length'] ?? 'N/A' }}<br>
                                <strong>প্লটের সাইজ(প্রস্থ):
                                </strong>{{ $license_moujas['plot_width'] ?? 'N/A' }}<br>
                                <strong>লাইসেন্সকৃত জমির পরিমান:
                                </strong>{{ $license_moujas['leased_area'] ?? 'N/A' }} বর্গফুট<br>
                            </td>

                            <td class="text-center align-middle">
                                <h6>
                                    @if ($license_date_from && $license_date_to)
                                    <strong>from </strong>{{ $license_date_from }}<strong> to
                                    </strong>{{ $license_date_to }}
                                    @else
                                    N/A
                                    @endif
                                </h6>
                            </td>
                            <td class="text-center align-middle">
                                <h6>{{ $balam['created_at'] ? $balam['created_at'] : 'N/A' }}
                                </h6>
                            </td>
                            <!-- <td class="text-center align-middle">
                                                @if ($serValue->land_map_certificate &&
                                                    file_exists(public_path('uploads/commercial/' . $serValue->land_map_certificate)))
                                                    <a class="text-black"
                                                        href="{{ asset('uploads/commercial/' . $serValue->land_map_certificate) }}"
                                                        download><i class="fa fa-file fa-2x" aria-hidden="true"></i></a>
                                                @else
                                                    <h6><span class="badge badge-danger">no file</span></h6>
                                                @endif
                                            </td> -->
                            <td class="text-center align-middle">
                                @php
                                $license = license_area($serValue);
                                @endphp
                                <strong>চৌহদ্দি উত্তর:</strong> {{ $license['land_map_north'] }}, <br>
                                <strong>দক্ষিণ:</strong> {{ $license['land_map_south'] }}, <br>
                                <strong>পূর্ব:</strong> {{ $license['land_map_east'] }}, <br>
                                <strong>পশ্চিম:</strong> {{ $license['land_map_west'] }}, <br>
                                <strong>কি.মি:</strong> {{ $license['land_map_kilo'] }}
                            </td>
                            <td class="text-nowrap">
                                @include('backend.content.commercial.includes.actions')
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="clearfix mt-3">
                <div class="d-inline-block float-right">
                    {{ $searchResult->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
        @endif
    </x-slot>
</x-backend.card>

@endsection

@push('after-styles')
<livewire:styles />
@endpush

@push('after-scripts')
<livewire:scripts />
@endpush