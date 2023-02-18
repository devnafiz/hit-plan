@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('মৌজা সংশোধন'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

{{ html()->modelForm($mouja, 'PUT', route('admin.mouja.update', $mouja->mouja_id))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}
<x-backend.card>
    <x-slot name="header">
        @lang('মৌজা সংশোধন')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :href="route('admin.mouja.index')" :text="__('Cancel')" />
    </x-slot>

    <x-slot name="body">
        <input type="hidden" id="kachari" value="{{ route('admin.ledger.fetch-kachari') }}">
        <input type="hidden" id="district" value="{{ route('admin.ledger.fetch-district') }}">
        <input type="hidden" id="upazila" value="{{ route('admin.ledger.fetch-upazila') }}">
        <input type="hidden" id="station" value="{{ route('admin.ledger.fetch-station') }}">
        <div class="row">
            <div class="col-md-9">
                <x-backend.card>
                    <div class="card-header with-border">
                        <h3 class="card-title">mouja Management <small class="ml-2">Create
                                mouja</small>
                        </h3>
                    </div>
                    <x-slot name="body">

                        <div class="row mb-3 px-4">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-2 text-right">
                                        <div class="form-group">
                                            <label for="division_id">বিভাগের নাম:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        {{ html()->select('division_id', collect($division), $division)->class('form-control')->id('division_id') }}
                                        <p class="text-danger error mt-2"></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 text-right">
                                        <div class="form-group">
                                            <label for="kachari_id">কাচারীর নাম:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        {{ html()->select('kachari_id', collect($kachari))->class('form-control')->id('kachari_id') }}
                                        <p class="text-danger error mt-2"></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 text-right">
                                        <div class="form-group">
                                            <label for="district_id">জেলার নাম:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        {{ html()->select('district_id', collect($district))->class('form-control')->id('district_id') }}
                                        <p class="text-danger error mt-2"></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 text-right">
                                        <div class="form-group">
                                            <label for="upazila_id">উপজেলার নাম:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        {{ html()->select('upazila_id', collect($upazila))->class('form-control')->id('upazila_id') }}
                                        <p class="text-danger error mt-2"></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 text-right">
                                        <div class="form-group">
                                            <label for="station_id">স্টেশনের নাম:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        {{ html()->select('station_id', collect($station))->class('form-control')->id('station_id') }}
                                        <p class="text-danger error mt-2"></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 text-right">
                                        <div class="form-group">
                                            <label for="mouja_id">মৌজার নাম:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        {{ html()->text('mouja_name')->class('form-control mouja_id')->id('mouja_name') }}
                                        <p class="text-danger error mt-2"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-slot> <!--  .card-body -->
                    <x-slot name="footer">
                        <a href="{{ route('admin.mouja.index') }}" class="btn btn-danger col-2" type="reset">@lang('Cancel')</a>
                        <button class="btn btn-success col-2" type="submit">@lang('Update')</button>
                    </x-slot>
                </x-backend.card>
            </div> <!-- .col-md-9 -->
        </div> <!-- .row -->
    </x-slot>

</x-backend.card>
{{ html()->closeModelForm() }}

@endsection

@push('after-styles')
@endpush

@push('after-scripts')
@endpush