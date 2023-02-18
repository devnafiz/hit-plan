@extends('backend.layouts.app')

@section('title', __('বকেয়া লাইসেন্স ফি’র তালিকা'))

@section('content')

    <x-backend.card xmlns:livewire="">
        <x-slot name="header">
            @lang('বকেয়া লাইসেন্স ফি’র তালিকা')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link-header icon="fas fa-plus" class="btn btn-sm btn-tool btn-primary" :href="route('admin.commercial-fees.create')"
                :text="__('ফি আদায় করুন')" />
        </x-slot>

        <x-slot name="body">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif

            <div class="row">
                @php
                    $license_type = [
                        'agriculture' => 'কৃষি',
                        'commercial' => 'বাণিজ্যিক',
                        'pond' => 'জলাশয়',
                        'agency' => 'সংস্থা',
                    ];
                    
                    $fee_type = [
                        'license_fee' => 'লাইসেন্স ফি',
                        'license_vat' => 'ভ্যাট',
                        'license_tax' => 'উৎস কর',
                    ];
                @endphp

                <div class="col-md-12 col-sm-12">
                    <form action="{{ route('admin.all.license.due') }}" method="GET">
                        <div class="row">
                            <input type="hidden" id="kachari" value="{{ route('admin.ledger.fetch-kachari') }}">
                            <input type="hidden" id="district" value="{{ route('admin.ledger.fetch-district') }}">
                            <input type="hidden" id="upazila" value="{{ route('admin.ledger.fetch-upazila') }}">
                            <input type="hidden" id="mouza" value="{{ route('admin.ledger.fetch-mouja') }}">
                            <input type="hidden" id="station" value="{{ route('admin.ledger.fetch-station') }}">
                            <input type="hidden" id="record" value="{{ route('admin.ledger.fetch-record') }}">

                            <div class="col-md-2 col-sm-12">
                                <label for="station_id" style="">লাইসেন্সর ধরণ:</label>
                                {{ html()->select('license_type', collect($license_type), request()->get('license_type'))->class('form-control')->id('license_type') }}
                            </div>

                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label for="division_id">বিভাগ:</label>
                                    {{ html()->select('division_id', collect($division)->prepend('বাছাই করুন', ''), request()->get('division_id'))->class('form-control')->id('division_id') }}
                                    <p class="text-danger error mt-2"></p>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label for="kachari_id">কাচারী:</label>
                                    {{ html()->select('kachari_id', collect($kachari)->prepend('বাছাই করুন', ''), request()->get('kachari_id'))->class('form-control')->id('kachari_id') }}
                                    <p class="text-danger error mt-2"></p>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label for="district_id">জেলা:</label>
                                    {{ html()->select('district_id', collect($district)->prepend('বাছাই করুন', ''), request()->get('district_id'))->class('form-control')->id('district_id') }}
                                    <p class="text-danger error mt-2"></p>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label for="upazila_id">উপজেলা:</label>
                                    {{ html()->select('upazila_id', collect($upazila)->prepend('বাছাই করুন', ''), request()->get('upazila_id'))->class('form-control')->id('upazila_id') }}
                                    <p class="text-danger error mt-2"></p>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <label for="station_id">স্টেশন:</label>
                                    {{ html()->select('station_id', collect($station)->prepend('বাছাই করুন', ''), request()->get('station_id'))->class('form-control')->id('station_id') }}
                                    <p class="text-danger error mt-2"></p>
                                </div>
                            </div>

                            {{-- <div class="col-md-2 col-sm-12">
                                <label for="station_id" style="">ফি'র ধরণ:</label>
                                {{ html()->select('fee_type ', collect($fee_type)->prepend('বাছাই করুন', ''), request()->get('fee_type '))->class('form-control')->id('fee_type ') }}
                    </div> --}}

                            <!-- <div class="col-md-2 col-sm-12">
                                                                                                                                                                                                                                                        <label for="month" style="">মাসের নাম (হতে):</label>
                                                                                                                                                                                                                                                        <input type="date" class="form-control" name="month-from" value="{{ request('month-from') ? date('Y-m-d', strtotime(request('month-from'))) : '' }}">
                                                                                                                                                                                                                                                    </div> -->

                            <div class="col-md-2 col-sm-12">
                                <label for="month" style="">মাসের নাম (পর্যন্ত):</label>
                                <input type="date" class="form-control" name="month-to"
                                    value="{{ request('month-to') ? date('Y-m-d', strtotime(request('month-to'))) : '' }}">
                            </div>
                            {{--
                            <div class="col-md-2 col-sm-12">
                                <label for="station_id" style="">দপ্তরের নাম:</label>
                                {{ html()->select('station_id', collect($station)->prepend('বাছাই করুন', ''), request()->get('station_id'))->class('form-control')->id('station_id') }}
            </div> --}}

                            <div class="col-md-2 col-sm-12 mt-4" style="padding-top: 5px;">
                                <button type="submit" name="next" class="btn btn-block btn-outline-primary">
                                    <i class="fa fa-search" aria-hidden="true"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </x-slot>
    </x-backend.card>
    @if ($searchResult)
        <x-backend.card xmlns:livewire="">
            <x-slot name="body">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 mt-5">
                        <h4 class="text-bold text-center">বকেয়া লাইসেন্স ফি’র তালিকা</h4>
                        <div class="text-center text-bold" style="font-size: 17px;">লাইসেন্সর ধরণ:
                            @if (request('license_type', null) == 'agriculture')
                                কৃষি,
                            @elseif (request('license_type', null) == 'commercial')
                                বাণিজ্যিক,
                            @elseif (request('license_type', null) == 'pond')
                                জলাশয়,
                            @elseif (request('license_type', null) == 'agency')
                                সংস্থা,
                            @else
                            @endif
                            সময়
                            {{ request('month-from', null) }} - {{ request('month-to', null) }} পর্যন্ত ,
                            {{ request('station_id') ? $station_name[0] : '' }} দপ্তর
                        </div>
                        <div style="overflow: auto;">
                            <table class="table table-bordered table-striped responsive_table mt-3"
                                style="overflow-x: auto; width:100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">নং</th>
                                        <th class="text-center align-middle">লাইসেন্স নং</th>
                                        <th class="text-center align-middle">লাইসেন্সীর তথ্য</th>
                                        <th class="text-center align-middle">কাচারী নাম</th>
                                        <th class="text-center align-middle">স্টেশনের নাম</th>
                                        {{-- <th class="text-center align-middle">বকেয়া তথ্য</th> --}}
                                        <th class="text-center align-middle">তফসিল</th>
                                        <th class="text-center align-middle">সর্বশেষ পরিশোধের সময়কাল</th>
                                        <th class="text-center align-middle">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($searchResult as $key => $serValue)
                                        @php
                                            $request = request('license_type', []);
                                            $licenseOwners = [];
                                            $dd_info = null;
                                            $license = null;
                                            $license_dd = null;
                                            $license_date_from = null;
                                            $license_date_to = null;
                                            
                                            if ($request == 'agriculture') {
                                                $license = $serValue->agriLicense;
                                                $license_date_from = date_en_to_bn($serValue->from_date);
                                                $license_date_to = date_en_to_bn($serValue->to_date);
                                                $licenseOwners = $license ? $license->agriOwner : [];
                                                $dd_info = $dd_information->where('balam_agriculture_id', $serValue->id);
                                                $license_dd = dd_info($dd_info);
                                            }
                                            if ($request == 'commercial') {
                                                $license = $serValue->commercialLicense;
                                                $licenseOwners = $license ? $license->commercialOwner : [];
                                                $dd_info = $dd_information->where('balam_commercial_id', $serValue->id);
                                                $license_dd = dd_info($dd_info);
                                                $license_date_from = date('F j, Y', strtotime($serValue->from_date));
                                                $license_date_to = date('F j, Y', strtotime($serValue->to_date));
                                            }
                                            if ($request == 'pond') {
                                                $license = $serValue->pondLicense;
                                                $licenseOwners = $license ? $license->pondOwner : [];
                                                $dd_info = $dd_information->where('balam_pond_id', $serValue->id);
                                                $license_dd = dd_info($dd_info);
                                                $license_date_from = date_en_to_bn($serValue->from_date);
                                                $license_date_to = date_en_to_bn($serValue->to_date);
                                            }
                                            if ($request == 'agency') {
                                                $license = $serValue->agencyLicense;
                                                $licenseOwners = $license ? $license->agencyOwner : [];
                                                $dd_info = $dd_information->where('balam_agency_id', $serValue->id);
                                                $license_dd = dd_info($dd_info);
                                                $license_date_from = date('F j, Y', strtotime($serValue->from_date));
                                                $license_date_to = date('F j, Y', strtotime($serValue->to_date));
                                            }
                                        @endphp

                                        <tr>
                                            <td class="text-center align-middle">{{ $key + 1 }}</td>

                                            <td class="text-center align-middle">
                                                @if ($request == 'agriculture')
                                                    @if ($license)
                                                        <a class="text-danger"
                                                            href="{{ route('admin.agriculture.show', $license ? $license->id : '#') }}">{{ $serValue->license_no }}</a>
                                                    @else
                                                        <label for="">{{ $serValue->license_no }}</label>
                                                    @endif
                                                @elseif($request == 'commercial')
                                                    @if ($license)
                                                        <a class="text-danger"
                                                            href="{{ route('admin.commercial.show', $license ? $license->id : '#') }}">{{ $serValue->license_no }}</a>
                                                    @else
                                                        <label for="">{{ $serValue->license_no }}</label>
                                                    @endif
                                                @elseif($request == 'pond')
                                                    @if ($license)
                                                        <a class="text-danger"
                                                            href="{{ route('admin.pond-license.show', $license ? $license->id : '#') }}">{{ $serValue->license_no }}</a>
                                                    @else
                                                        <label for="">{{ $serValue->license_no }}</label>
                                                    @endif
                                                @elseif($request == 'agency')
                                                    @if ($license)
                                                        <a class="text-danger"
                                                            href="{{ route('admin.agency.show', $license ? $license->id : '#') }}">{{ $serValue->license_no }}</a>
                                                    @else
                                                        <label for="">{{ $serValue->license_no }}</label>
                                                    @endif
                                                @else
                                                @endif
                                            </td>

                                            <td class="">
                                                @foreach ($licenseOwners as $owner)
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
                                                        <strong>ঠিকানা: </strong>{!! $owner->address ? nl2br(e($owner->address)) : 'N/A' !!} <br>
                                                        <strong>মোবাইল: </strong>{{ $owner->phone }}<br>
                                                        <strong>এনআইডি: </strong>{{ $owner->nid }}<br>
                                                    </p>
                                                @endforeach
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ $license->kachari->kachari_name ?? 'N/A' }}
                                            </td>

                                            <td class="text-center align-middle">
                                                @if ($request == 'agency')
                                                    <?php $license_moujas = agency_license_moujas($license->agencyMoujas); ?>
                                                    {{ $license_moujas['stations'] ?? 'N/A' }}<br>
                                                @else
                                                    {{ $license->station->station_name ?? 'N/A' }}
                                                @endif
                                            </td>
                                            {{-- <td></td> --}}
                                            <td style="width:10%">
                                                @if ($request == 'agriculture' || $request == 'pond')
                                                    @if ($request == 'agriculture')
                                                        <?php $license_moujas = $license ? license_moujas($license->agriMoujas) : []; ?>
                                                    @else
                                                        <?php $license_moujas = $license ? license_moujas($license->pondMoujas) : []; ?>
                                                    @endif
                                                    <strong>মৌজা: </strong>{{ $license_moujas['moujas'] ?? 'N/A' }}<br>
                                                    <strong>খতিয়ান নং:
                                                    </strong>{{ $license_moujas['ledgers'] ?? 'N/A' }}<br>
                                                    <strong>রেকর্ড: </strong>{{ $license_moujas['records'] ?? 'N/A' }}<br>
                                                    <strong>দাগ: </strong>{{ $license_moujas['plots'] ?? 'N/A' }}
                                                @elseif ($request == 'agency')
                                                    <?php $license_moujas = agency_license_moujas($license->agencyMoujas); ?>
                                                    <strong>মৌজা: </strong>{{ $license_moujas['moujas'] ?? 'N/A' }}<br>
                                                    <strong>খতিয়ান নং:
                                                    </strong>{{ $license_moujas['ledgers'] ?? 'N/A' }}<br>
                                                    <strong>রেকর্ড: </strong>{{ $license_moujas['records'] ?? 'N/A' }}<br>
                                                    <strong>লাইসেন্সকৃত জমির পরিমান:
                                                    </strong>{{ $license_moujas['property_amount'] ?? 'N/A' }} বর্গফুট<br>
                                                @else
                                                    <?php $license_moujas = commercial_license_moujas($license->commercialMoujas); ?>
                                                    <strong>মাস্টারপ্ল্যান
                                                        নং:</strong>{!! $license_moujas['masterplan_no'] ? wordwrap($license_moujas['masterplan_no'], 50, '<br>') : 'N/A' !!}<br>
                                                    <strong>মাস্টারপ্ল্যানের প্লট নং:
                                                    </strong>{!! wordwrap($license_moujas['com_license_plots'], 50, '<br>') ?? 'N/A' !!}<br>
                                                    <strong>জমির পরিমান:
                                                    </strong>{{ $license_moujas['leased_area'] . ' বর্গফুট' ?? 'N/A' }}<br>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                @if ($license_date_from && $license_date_to)
                                                    {{ $license_date_from }}<strong> হইতে <br>
                                                    </strong>{{ $license_date_to }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td class="text-nowrap">
                                                @if ($request == 'agriculture')
                                                    <div class="btn-group btn-group-sm">
                                                        <button type="button" class="btn btn-default dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-cog nav-icon"></i>
                                                        </button>
                                                        <div class="dropdown-menu" role="menu" style="">
                                                            <a class="dropdown-item btnProcess"
                                                                href="{{ route('admin.agriculture.show', $license->id) }}"><i
                                                                    class="fas fa-eye"></i> View</a>
                                                            <a class="dropdown-item btnProcess"
                                                                href="{{ route('admin.agriculture.edit', $license->id) }}"><i
                                                                    class="ti-pencil-alt"></i> Edit</a>
                                                            <a class="dropdown-item" data-method="delete"
                                                                data-toggle="tooltip"
                                                                href="{{ route('admin.agriculture.destroy', $license->id) }}"><i
                                                                    class="fas fa-trash"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                @elseif($request == 'commercial')
                                                    <div class="btn-group btn-group-sm">
                                                        <button type="button" class="btn btn-default dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-cog nav-icon"></i>
                                                        </button>
                                                        <div class="dropdown-menu" role="menu" style="">
                                                            <a class="dropdown-item btnProcess"
                                                                href="{{ route('admin.commercial.show', $license->id) }}"><i
                                                                    class="fas fa-eye"></i> View</a>
                                                            <a class="dropdown-item btnProcess"
                                                                href="{{ route('admin.commercial.edit', $license->id) }}"><i
                                                                    class="ti-pencil-alt"></i> Edit</a>
                                                            <a class="dropdown-item" data-method="delete"
                                                                data-toggle="tooltip"
                                                                href="{{ route('admin.commercial.destroy', $license->id) }}"><i
                                                                    class="fas fa-trash"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                @elseif($request == 'pond')
                                                    <div class="btn-group btn-group-sm">
                                                        <button type="button" class="btn btn-default dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-cog nav-icon"></i>
                                                        </button>
                                                        <div class="dropdown-menu" role="menu" style="">
                                                            <a class="dropdown-item btnProcess"
                                                                href="{{ route('admin.pond-license.show', $license->id) }}"><i
                                                                    class="fas fa-eye"></i> View</a>
                                                            <a class="dropdown-item btnProcess"
                                                                href="{{ route('admin.pond-license.edit', $license->id) }}"><i
                                                                    class="ti-pencil-alt"></i> Edit</a>
                                                            <a class="dropdown-item" data-method="delete"
                                                                data-toggle="tooltip"
                                                                href="{{ route('admin.pond-license.destroy', $license->id) }}"><i
                                                                    class="fas fa-trash"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                @elseif($request == 'agency')
                                                    <div class="btn-group btn-group-sm">
                                                        <button type="button" class="btn btn-default dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-cog nav-icon"></i>
                                                        </button>
                                                        <div class="dropdown-menu" role="menu" style="">
                                                            <a class="dropdown-item btnProcess"
                                                                href="{{ route('admin.agency.show', $license->id) }}"><i
                                                                    class="fas fa-eye"></i> View</a>
                                                            <a class="dropdown-item btnProcess"
                                                                href="{{ route('admin.agency.edit', $license->id) }}"><i
                                                                    class="ti-pencil-alt"></i> Edit</a>
                                                            <a class="dropdown-item" data-method="delete"
                                                                data-toggle="tooltip"
                                                                href="{{ route('admin.agency.destroy', $license->id) }}"><i
                                                                    class="fas fa-trash"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-center">No DataFound</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="clearfix mt-3">
                            <div class="d-inline-block float-right">
                                {{-- {{ $searchResult->appends(request()->query())->links() }} --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <div class="clearfix float-right">
                            <div class="d-inline-block float-right">
                                {{ $searchResult->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </x-slot>
        </x-backend.card>
    @endif
@endsection

@push('after-styles')
    <livewire:styles />
@endpush

@push('after-scripts')
    <livewire:scripts />
@endpush
