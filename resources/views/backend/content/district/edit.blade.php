@extends('backend.layouts.app')

@section('title', __('Update district'))

@section('content')

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

{{ html()->modelForm($district, 'PUT', route('admin.district.update', $district->district_id))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}
<x-backend.card>
    <x-slot name="header">
        @lang('Update district')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :href="route('admin.district.index')" :text="__('Cancel')" />
    </x-slot>

    <x-slot name="body">
        <div class="row">
            <div class="col-md-9">
                <x-backend.card>
                    <div class="card-header with-border">
                        <h3 class="card-title">District Management <small class="ml-2">Update
                                district</small>
                        </h3>
                    </div>
                    <x-slot name="body">
                    <div class="row mb-3 px-4">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-2 text-right">
                                        <div class="form-group">
                                            <label for="division_id">বিভাগের নাম:  </label>
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
                                    {{ html()->select('kachari_id', collect($kachari))->class('form-control')->attribute('data-target', '#district_id')->id('kachari_id') }}
                                    </div>
                                </div>
       

                                <div class="row">
                                    <div class="col-md-2 text-right">
                                        <div class="form-group">
                                            <label for="upazila_name">জেলার নাম:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" id="district_name" name="district_name" value="{{$district->district_name}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-slot> <!--  .card-body -->
                    <x-slot name="footer">
                        <button class="btn btn-success" type="submit">@lang('Update')</button>
                        <a href="{{ route('admin.district.index') }}" class="btn btn-danger" type="reset">@lang('Cancel')</a>
                    </x-slot>
                </x-backend.card>
            </div> <!-- .col-md-9 -->

        </div> <!-- .row -->
    </x-slot>

</x-backend.card>

{{ html()->closeModelForm() }}

@endsection