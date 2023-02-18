@extends('backend.layouts.app')

@section('title', __('Update Upazila'))

@section('content')

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

{{ html()->modelForm($upazilla, 'PUT', route('admin.upazilla.update', $upazilla->upazila_id))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}

<x-backend.card>
    <x-slot name="header">
        @lang('Update upazilla')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :href="route('admin.upazilla.index')" :text="__('Cancel')" />
    </x-slot>

    <x-slot name="body">
    <input type="hidden" id="kachari" value="{{ route('admin.ledger.fetch-kachari') }}">
        <input type="hidden" id="district" value="{{ route('admin.ledger.fetch-district') }}">
        <div class="row">
            <div class="col-md-9">
                <x-backend.card>
                    <div class="card-header with-border">
                        <h3 class="card-title">upazilla Management <small class="ml-2">Update
                                upazilla</small></h3>
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
                                            <label for="upazila_name">উপজেলার নাম:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" id="upazila_name" name="upazila_name" value="{{$upazilla->upazila_name}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </x-slot> <!--  .card-body -->
                    <x-slot name="footer">
                        <button class="btn btn-success" type="submit">@lang('Update')</button>
                        <a href="{{ route('admin.upazilla.index') }}" class="btn btn-danger" type="reset">@lang('Cancel')</a>
                    </x-slot>
                </x-backend.card>
            </div> <!-- .col-md-9 -->

            <div class="col-sm-3">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title">Publishing Tools</h3>
                    </div>
                    {{-- <div class="card-body p-3">
                                <div class="form-group">
                                    @php $status = old('status', $upazilla->status);@endphp
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="status" value="publish" id="publish"
                                            class="checking" checked>
                                        <label class="form-check-label" for="publish">Publish</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="status" value="draft" id="draft"
                                            class="checking" @if ($status === 'draft') checked @endif>
                                        <label class="form-check-label" for="draft">Draft</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="status" value="schedule"
                                            id="schedule" class="checking" @if ($status === 'schedule') checked @endif>
                                        <label class="form-check-label" for="schedule">Schedule</label>
                                    </div>
                                </div> <!-- form-group -->
                                <div class="form-group @if ($status !== 'schedule') d-none @endif" id="scheduleDate">
                                    <div class="form-group">
                                        <div class="input-group">
                                            {{ html()->text('schedule_time')->class('form-control')->id('datepicker-autoclose')->placeholder('dd-mm-yyyy')->attributes(['autoComplete' => 'off']) }}
                    <div class="input-group-append bg-custom b-0">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                    </div>
                </div><!-- input-group -->
            </div>
        </div> <!-- form-group -->
        <div class="row">
            <div class="card-title col">upazilla Image (694x500)</div>
        </div> <!-- row -->
        <hr class="mt-0">
        <div class="form-group">
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" name="is_picture" value="{{ now() }}" id="new" class="checking" checked>
                <label class="form-check-label" for="new">Upload Image</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" name="is_picture" value="" id="off" class="checking">
                <label class="form-check-label" for="off">Image Off</label>
            </div>
        </div> <!-- form-group -->
        <div class="form-group" id="for_New_upload">
            @php
            $image = $upazilla->is_picture ? $upazilla->picture : 'img/backend/no-image.gif';
            @endphp
            <label for="image">
                <img src="{{ asset($image) }}" class="img-fluid" id="holder" alt="Image upload">
            </label>
            {{ html()->file('picture')->id('image')->class('d-none')->acceptImage() }}
        </div> <!-- form-group -->
        </div> <!--  card-body --> --}}
        </div> <!-- /.card -->
        </div> <!-- .col-md-3 -->
        </div> <!-- .row -->
    </x-slot>

</x-backend.card>

{{ html()->closeModelForm() }}

@endsection