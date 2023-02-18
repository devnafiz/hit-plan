@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('নতুন ইনভেনটরী তথ্য যুক্ত'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('ইনভেনটরী তথ্য যুক্ত করুন')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :text="__('Cancel')" />
    </x-slot>

    <x-slot name="body">
        @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
        @endif

        {{ html()->form('POST', route('admin.inventory.store'))->id('ownerForm')->attribute('enctype', 'multipart/form-data')->attribute('next', 'fee-tab')->open() }}
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">

                <div class="card">
                    <div class="card-header">
                        <h4>নতুন ইনভেনটরী তথ্য যুক্ত</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>ফাইল নং:</label>
                            <input type="text" class="form-control" name="file_no" placeholder="ফাইল নং" require>
                        </div>
                        <div class="form-group">
                            <label>ফাইলের ধরণ</label>
                            <select class="form-control" name="file_type" required>
                                <option selected>ফাইলের ধরণ বাছাই করুন</option>
                                @foreach ($data['inventory'] as $div)
                                <option value="{{ $div->file_id }}">{{ $div->type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                          <label>সেল্ফ</label>
                          <select class="form-control" name="self">
                            <option selected>সেল্ফ বাছাই করুন</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>কলাম</label>
                          <select class="form-control" name="file_column">
                            <option selected>কলাম বাছাই করুন</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>রো</label>
                          <select class="form-control" name="row">
                            <option selected>রো বাছাই করুন</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                          </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn btn-lg btn-dark float-right">সাবমিট</button>
                    </div>
                </div>
            </div>
        </div>


        {{ html()->form()->close() }}
    </x-slot>

</x-backend.card>

<script></script>
@endsection

@push('after-styles')
{{-- <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"> --}}
@endpush

@push('after-scripts')
@endpush