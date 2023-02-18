@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('খতিয়ান ও দাগ খুজুন'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('খতিয়ান ও দাগ খুজুন')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :text="__('Cancel')" :href="route('admin.ledger.index')" />
    </x-slot>

    <x-slot name="body">
        <div class="report-params p-3" style="border: solid #d9d9d9 3px;">
            <form action="{{ route('admin.ledger.search-result') }}" method="GET">
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
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label for="record_name">রেকর্ডের নাম:</label>
                            {{ html()->select('record_name', collect($record)->prepend('বাছাই করুন', ''), request()->get('record_name'))->class('form-control record_name')->id('record_name') }}
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
        <table id="" class="table table-bordered table-striped" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center align-middle">no.</th>
                    <th class="text-center align-middle">খতিয়ান নং</th>
                    <th class="text-center align-middle">বিভাগ</th>
                    <th class="text-center align-middle">কাচার</th>
                    <th class="text-center align-middle">জেলা</th>
                    <th class="text-center align-middle">উপজেলা</th>
                    <th class="text-center align-middle">স্টেশনের নাম</th>
                    <th class="text-center align-middle">মৌজা</th>
                    <th class="text-center align-middle">রেকর্ডের নাম</th>
                    <th class="text-center align-middle">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($searchResult as $key => $serValue)
                <tr>
                    <td class="text-center align-middle">{{ $key + 1 }}</td>
                    <td class="text-center align-middle">{{ $serValue->ledger_number ?? "" }}</td>
                    <td class="text-center align-middle">{{ $serValue->division->division_name ?? "" }}</td>
                    <td class="text-center align-middle">{{ $serValue->kachari->kachari_name ?? "" }}</td>
                    <td class="text-center align-middle">{{ $serValue->district->district_name ?? "" }}</td>
                    <td class="text-center align-middle">{{ $serValue->upazila->upazila_name ?? "" }}</td>
                    <td class="text-center align-middle">{{ $serValue->station->station_name ?? "" }}</td>
                    <td class="text-center align-middle">{{ $serValue->mouja->mouja_name ?? "" }}</td>
                    <td class="text-center align-middle">{{ $serValue->record->record_name ?? "" }}</td>
                    <td class="text-nowrap">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.ledger.show', $serValue) }}" class="btn btn-light" data-toggle="tooltip" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.ledger.edit', $serValue) }}" class="btn btn-light" data-toggle="tooltip" title="Edit">
                                <i class="ti-pencil-alt"></i>
                            </a>
                            <a href="{{ route('admin.ledger.destroy', $serValue) }}" class="btn btn-light" data-method="delete" data-toggle="tooltip" title="Delete">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="clearfix mt-3">
            <div class="d-inline-block float-right">
                {{ $searchResult->appends(request()->query())->links() }}
            </div>
        </div>
        @endif
    </x-slot>
</x-backend.card>

@endsection

@push('after-scripts')
@endpush