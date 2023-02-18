@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('Create New Mouja'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

{{ html()->form('POST', route('admin.mouja.store'))->attribute('enctype', 'multipart/form-data')->open() }}

<x-backend.card>
    <x-slot name="header">
        @lang('Create New mouja')
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
                                        <select required id="division_id" class="form-control division_id" name="division_id" required>
                                            <option value="" disabled selected>বাছাই করুন</option>
                                            @foreach ($division as $divisions_name)
                                            <option value="{{ $divisions_name->division_id }}">
                                                {{ $divisions_name->division_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 text-right">
                                        <div class="form-group">
                                            <label for="kachari_id">কাচারীর নাম:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <select required id="kachari_id" class="form-control" name="kachari_id" required>
                                            <option selected disabled>কাচারী বাছাই করুন</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 text-right">
                                        <div class="form-group">
                                            <label for="district_id">জেলার নাম:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <select required class="form-control" id="district_id" name="district_id" required>
                                            <option selected disabled>জেলা বাছাই করুন</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 text-right">
                                        <div class="form-group">
                                            <label for="upazila_id">উপজেলার নাম:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <select required class="form-control" id="upazila_id" name="upazila_id" required>
                                            <option selected disabled>উপজেলা বাছাই করুন</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 text-right">
                                        <div class="form-group">
                                            <label for="station_id">স্টেশনের নাম:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <select required class="form-control" id="station_id" name="station_id" required>
                                            <option selected disabled>স্টেশন বাছাই করুন</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 text-right">
                                        <div class="form-group">
                                            <label for="mouja_id">মৌজার নাম:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" id="mouja_name" name="mouja_name" placeholder="মৌজার নাম">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-slot> <!--  .card-body -->
                    <x-slot name="footer">
                        <a href="{{ route('admin.district.index') }}" class="btn btn-danger col-2" type="reset">@lang('Cancel')</a>
                        <button class="btn btn-success col-2" type="submit">@lang('Create')</button>
                    </x-slot>
                </x-backend.card>
            </div> <!-- .col-md-9 -->
        </div> <!-- .row -->
    </x-slot>

</x-backend.card>

{{ html()->form()->close() }}

@endsection