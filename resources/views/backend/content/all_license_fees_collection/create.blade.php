@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('লাইসেন্স ফি আদায় ফরম'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('লাইসেন্স খুজুন')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" :href="route('admin.all_license_fees.create')" icon="fas fa-backspace" :text="__('Back')" />
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

        {{ html()->form('GET', route('admin.find.license'))->id('ownerForm')->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}


        <div class="row justify-content-center align-center mb-0">
            <div class="col-md-6 mt-3">
                <input type="number" id="license_number" class="form-control" maxlength="11" name="license_number" placeholder="লাইসেন্স নং" />
            </div>
            <div class="col-md-3 mt-3">
                <button type="submit" class="btn btn-outline-primary btn-lg" id=""><i class="fa fa-search" aria-hidden="true"></i> চেক
                    করুন</button>
            </div>
        </div>

        {{ html()->form()->close() }}
    </x-slot>

</x-backend.card>


@endsection

@push('after-styles')
@endpush

@push('after-scripts')
@endpush