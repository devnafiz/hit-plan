@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('Register new patient'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

{{ html()->form('POST', route('admin.upazilla.store'))->attribute('enctype', 'multipart/form-data')->open() }}

<x-backend.card>
    <x-slot name="header">
        @lang('Create New upazilla')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :href="route('admin.upazilla.index')" :text="__('Cancel')" />
    </x-slot>

    <x-slot name="body">
    <input type="hidden" id="kachari" value="{{ route('admin.ledger.fetch-kachari') }}">
        <input type="hidden" id="district" value="{{ route('admin.ledger.fetch-district') }}">
       
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
                                        <input class="form-control" id="upazila_id" name="upazila_name" placeholder="উপজেলার নাম">
                                    </div>
                                </div>
                            </div>
                        </div>
       
       
            <button class="btn btn-success" type="submit">@lang('Create')</button>
            <a href="{{ route('admin.upazilla.index') }}" class="btn btn-danger" type="reset">@lang('Cancel')</a>
        
    </x-slot> <!--  .card-body -->
</x-backend.card>

{{ html()->form()->close() }}

@endsection