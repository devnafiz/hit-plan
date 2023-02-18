@extends('backend.layouts.app')

@section('title', __('Update banner'))

@section('content')

@php
$required = html()->span(' *')->class('text-danger');
@endphp

{{ html()->modelForm($banner, 'PUT', route('admin.banner.update', $banner))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}

<x-backend.card>
  <x-slot name="header">
    @lang('Update Banner')
  </x-slot>

  <x-slot name="headerActions">
    <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace"
      :href="route('admin.banner.index')" :text="__('Cancel')" />
  </x-slot>

  <x-slot name="body">
    <div class="row">
      <div class="col-md-9">
        <x-backend.card>
          <div class="card-header with-border">
            <h3 class="card-title">Banner Management <small class="ml-2">Update Banner</small></h3>
          </div>
          <x-slot name="body">
            <div class="form-group">
              {{html()->text('name')->class('form-control cash')->placeholder('Banner Title')}}
              <p class="text-danger margin-bottom-none" id="post_error">
                @error('name'){{$message}}@enderror
              </p>
            </div> <!-- form-group -->

            <div class="form-group">
              {{html()->textarea('description')->class('editor form-control')->placeholder('Banner Description')}}
              @error('description')
              <p class="text-danger margin-bottom-none">{{$message}}</p>
              @enderror
            </div> <!-- form-group -->
          </x-slot> <!--  .card-body -->
          <x-slot name="footer">
            <button class="btn btn-success" type="submit">@lang('Update')</button>
            <a href="{{route('admin.banner.index')}}" class="btn btn-danger" type="reset">@lang('Cancel')</a>
          </x-slot>
        </x-backend.card>
      </div> <!-- .col-md-9 -->

      <div class="col-sm-3">
        <div class="card">
          <div class="card-header with-border">
            <h3 class="card-title">Publishing Tools</h3>
          </div>
          <div class="card-body p-3">
            <div class="form-group">
              @php $status = old('status', $banner->status);@endphp
              <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" name="status" value="publish" id="publish" class="checking"
                  checked>
                <label class="form-check-label" for="publish">Publish</label>
              </div>
              <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" name="status" value="draft" id="draft" class="checking"
                  @if($status==='draft' ) checked @endif>
                <label class="form-check-label" for="draft">Draft</label>
              </div>
              <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" name="status" value="schedule" id="schedule"
                  class="checking" @if($status==='schedule' ) checked @endif>
                <label class="form-check-label" for="schedule">Schedule</label>
              </div>
            </div> <!-- form-group -->
            <div class="form-group @if($status !=='schedule' ) d-none @endif" id="scheduleDate">
              <div class="form-group">
                <div class="input-group">
                  {{html()->text('schedule_time')->class('form-control')->id('datepicker-autoclose')->placeholder('dd-mm-yyyy')->attributes(['autoComplete' => 'off'])}}
                  <div class="input-group-append bg-custom b-0">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                  </div>
                </div><!-- input-group -->
              </div>
            </div> <!-- form-group -->
            <div class="row">
              <div class="card-title col">Banner Image (694x500)</div>
            </div> <!-- row -->
            <hr class="mt-0">
            <div class="form-group">
              <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" name="is_picture" value="{{now()}}" id="new"
                  class="checking" checked>
                <label class="form-check-label" for="new">Upload Image</label>
              </div>
              <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" name="is_picture" value="" id="off" class="checking">
                <label class="form-check-label" for="off">Image Off</label>
              </div>
            </div> <!-- form-group -->
            <div class="form-group" id="for_New_upload">
              @php
              $image = $banner->is_picture ? $banner->picture : 'img/backend/no-image.gif'
              @endphp
              <label for="image">
                <img src="{{asset($image)}}" class="img-fluid" id="holder" alt="Image upload">
              </label>
              {{html()->file('picture')->id('image')->class('d-none')->acceptImage()}}
            </div> <!-- form-group -->
          </div> <!--  card-body -->
        </div> <!-- /.card -->
      </div> <!-- .col-md-3 -->
    </div> <!-- .row -->
  </x-slot>

</x-backend.card>

{{ html()->closeModelForm() }}

@endsection
