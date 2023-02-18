@extends('backend.layouts.app')

@section('title', __('কৃষি লাইসেন্স সমূহ'))

@section('content')

    <x-backend.card xmlns:livewire="">
        <x-slot name="header">
            @lang('কৃষি লাইসেন্স সমূহ')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link-header icon="fas fa-plus" class="btn btn-sm btn-tool btn-primary no-print" :href="route('admin.agriculture.create')"
                :text="__('কৃষি লাইসেন্স সমূহ')" />
        </x-slot>

        <x-slot name="body">
            {{-- <!-- <livewire:backend.agriculturelicense-table /> --> --}}
            <div class="report-params p-3 no-print" style="border: solid #d9d9d9 3px;">
                <form action="{{ route('admin.agriculture.index') }}" method="GET">
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
                                <input type="text" class="form-control" id="license_no" name="license_no"
                                    placeholder="" />
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
                @php
                    $full_path = request();
                    $download_path = $full_path->getRequestUri() . '&download=download';
                @endphp
                <div class="row justify-content-end">
                    <div class="btn-group mb-2" role="group" aria-label="header_button_group">
                        @if ($logged_in_user->isAdmin())
                            <button type="button" class="btn btn-outline-primary no-print" id="changeGroupStatusButton"
                                data-toggle="tooltip" disabled="true" title="@lang('Change Status')">
                                @lang('Change Status')
                            </button>
                        @endif
                        <a href="{{ route('admin.agriculture.index', ['download' => 'download']) }}" target="_blank"
                            class="float-right btn btn-outline-primary no-print">Print</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="table-responsive">
                            <table id="" class="table table-bordered table-striped" style="overflow: hidden;">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">Select<input type="checkbox"
                                                id="allSelectCheckbox" name="allSelectCheckbox"></th>
                                        <th class="text-center align-middle">নং</th>
                                        <th class="text-center align-middle">লাইসেন্স নং</th>
                                        <th class="text-center align-middle">লাইসেন্সীর তথ্য</th>
                                        <th class="text-center align-middle">কাচারী নাম</th>
                                        <th class="text-center align-middle">স্টেশনের নাম</th>
                                        <th class="text-center align-middle">তফসিল</th>
                                        <th class="text-center align-middle">সর্বশেষ লাইসেন্স ফি পরিশোধের সময়কাল</th>
                                        <th class="text-center align-middle">অনুমোদনর তারিখ</th>
                                        <!-- <th class="text-center align-middle">লাইসেন্স অনুমোদনর কপি</th> -->
                                        <th class="text-center align-middle">চৌহদ্দি সংক্রান্ত তথ্য</th>
                                        <th class="text-center align-middle">লাইসেন্সর অবস্থা</th>
                                        <th class="text-center align-middle">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($searchResult as $key => $serValue)
                                        <?php
                                        $sr_no = $key + $searchResult->firstItem();
                                        $balam = balam_year($serValue->balam, 'agriculture');
                                        $license_date_from = $balam['from_date'];
                                        $license_date_to = $balam['to_date'];
                                        ?>
                                        <tr>
                                            <td class="text-center align-middle"><input type="checkbox" class="checkboxItem"
                                                    name="checkboxItem" id="checkboxItem" value="{{ $serValue->id }}">
                                            </td>
                                            <td class="text-center align-middle">{{ $sr_no }}</td>
                                            <td class="text-center align-middle"><a
                                                    href="{{ route('admin.agriculture.show', $serValue) }}">{{ $serValue->generated_id }}</a>
                                            </td>
                                            <td class="" style="width: 100px;">
                                                @forelse ($serValue->agriOwner as $owner)
                                                    <p>
                                                        <strong>লাইসেন্সীর নাম: </strong>{{ $owner->name ?? 'N/A' }}<br>
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
                                                @empty
                                                @endforelse
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ $serValue->kachari->kachari_name ?? 'N/A' }}
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ $serValue->station->station_name ?? 'N/A' }}
                                            </td>

                                            <td>
                                                <strong>জেলা:
                                                </strong>{{ $serValue->district->district_name ?? 'N/A' }}<br>
                                                <?php $license_moujas = license_moujas($serValue->agriMoujas); ?>
                                                <strong>উপজেলা:
                                                </strong>{{ $serValue->upazila->upazila_name ?? 'N/A' }}<br>
                                                <strong>মৌজা: </strong>{{ $license_moujas['moujas'] ?? 'N/A' }}<br>
                                                <strong>খতিয়ান নং: </strong>{{ $license_moujas['ledgers'] ?? 'N/A' }}<br>
                                                <strong>দাগ নং: </strong>{{ $license_moujas['plots'] ?? 'N/A' }}<br>
                                                <strong>লাইসেন্সকৃত জমির পরিমান:
                                                </strong>{{ $license_moujas['leased_area'] . ' একর' ?? 'N/A' }}<br>
                                            </td>

                                            <td class="text-center align-middle">
                                                @if ($license_date_from && $license_date_to)
                                                    {{ $license_date_from }}<strong> হইতে
                                                    </strong>{{ $license_date_to }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>

                                            <td class="text-center align-middle">
                                                <h6>{{ $serValue->demand_notice_date ? date('F j, Y', strtotime($serValue->demand_notice_date)) : 'N/A' }}
                                                </h6>
                                            </td>
                                            <!--
                                                    <td class="text-center align-middle">
                                                        @if (
                                                            $serValue->land_map_certificate &&
                                                                file_exists(public_path('uploads/agriculture/' . $serValue->land_map_certificate)))
    <a class="text-black" href="{{ asset('uploads/agriculture/' . $serValue->land_map_certificate) }}" download><i class="fa fa-file fa-2x" aria-hidden="true"></i></a>
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

                                            <td class="text-center align-middle">
                                                @if ($serValue->status == 'waiting-for-approval')
                                                    <span
                                                        class="badge badge-danger">{{ $serValue->status ?? 'N/A' }}</span>
                                                @else
                                                    <span
                                                        class="badge badge-primary">{{ $serValue->status ?? 'N/A' }}</span>
                                                @endif
                                            </td>

                                            <td class="text-nowrap">
                                                @include('backend.content.agriculture.includes.actions')
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row no-print">
                    <div class="col-md-12 col-sm-12">
                        <div class="clearfix mt-3">
                            <div class="d-inline-block float-right">
                                {{ $searchResult->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                @include('backend.includes.status_update_model');
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
