@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('মাস্টারপ্লান সমূহ'))

@section('content')

    <x-backend.card xmlns:livewire="">
        <x-slot name="header">
            @lang('মাস্টারপ্লান সমূহ')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link-header icon="fas fa-plus" class="btn btn-sm btn-tool btn-primary" :href="route('admin.masterplan.create')"
                :text="__('মাস্টারপ্লান তৈরি')" />
        </x-slot>

        <x-slot name="body">
            <div class="report-params p-3" style="border: solid #d9d9d9 3px;">
                <form action="{{ route('admin.masterplan.index') }}" method="GET">
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
                                <label for="mouja_id">মৌজার নাম:</label>
                                {{ html()->select('mouja_id', collect($mouja)->prepend('বাছাই করুন', ''), request()->get('mouja_id'))->class('form-control mouja_id')->id('mouja_id') }}
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

            <div class="row">
                <div class="col-md-12 col-sm-12" style="overflow: auto;">
                    <table class="table table-bordered table-striped text-center align-middle"
                        style="overflow-x: auto; width:100%;">
                        <thead>
                            <tr>
                                <th class="text-center align-middle">no.</th>
                                <th class="text-center align-middle">মাস্টারপ্লান নং</th>
                                {{-- <th class="text-center align-middle">মাস্টারপ্লান এর নাম</th> --}}
                                <th class="text-center align-middle">অনুমোদন এর তারিখ</th>
                                <th class="text-center align-middle">বিভাগ, জেলা ও উপজেলা</th>
                                <th class="text-center align-middle">মাস্টারপ্ল্যানের মোট প্লট সংখ্যা</th>
                                <th class="text-center align-middle">স্টেশনের নাম</th>
                                <th class="text-center align-middle">মৌজা</th>
                                <th class="text-center align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($masterplans as $key => $masterplan)
                                @php
                                    $masterplan_moujas = masterplan_moujas($masterplan->masterPlanMouja);
                                @endphp
                                <tr>
                                    <td class="">{{ $key + 1 }}</td>
                                    <td class="">
                                        <a href="{{ route('admin.masterplan.show', $masterplan->id) }}">
                                            {{ $masterplan->masterplan_no ?? 'N/A' }}
                                        </a>
                                    </td>
                                    {{-- <th class="">{{ $masterplan->masterplan_name }}</th> --}}
                                    <td class="">
                                        {{ date('F j, Y', strtotime($masterplan->approval_date)) }}
                                    </td>
                                    <td class="">
                                        <strong>বিভাগ: </strong>{{ $masterplan->division->division_name ?? 'N/A' }} <br>
                                        <strong>জেলা: </strong>{{ $masterplan->district->district_name ?? 'N/A' }} <br>
                                        <strong>উপজেলা: </strong>{{ $masterplan->upazila->upazila_name ?? 'N/A' }} <br>
                                    </td>
                                    <td class="">{{ $masterplan->masterPlanPlot->count() ?? 'N/A' }}</td>
                                    <td class="">{{ $masterplan->station->station_name ?? 'N/A' }}</td>
                                    <td class="text-left align-middle">
                                        @php
                                            $masterplan_moujas = masterplan_moujas($masterplan->masterPlanMouja);
                                        @endphp
                                        <strong>মৌজা: </strong>{{ $masterplan_moujas['moujas'] ?? 'N/A' }}<br>
                                        <strong>খতিয়ান নং: </strong>{{ $masterplan_moujas['ledgers'] ?? 'N/A' }}<br>
                                        <strong>রেকর্ড: </strong>{{ $masterplan_moujas['records'] ?? 'N/A' }}<br>
                                        <strong>দাগ: </strong>{{ $masterplan_moujas['masterplan_plots'] ?? 'N/A' }}<br>
                                        <strong>মোট জমির পরিমান:
                                        </strong>{{ $masterplan_moujas['masterplan_plot_total_area'] ?? 'N/A' }}
                                        বর্গফুট<br>
                                    </td>
                                    <td class="">@include('backend.content.masterplan.includes.actions')</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="clearfix mt-3">
                        <div class="d-inline-block float-right">
                            {{ $masterplans->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-backend.card>
@endsection

@push('after-scripts')
@endpush
