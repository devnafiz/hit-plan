@inject('carbon', '\Carbon\Carbon')

@extends('backend.layouts.app')

@section('title', __('লাইসেন্স ফি আদায় করুন'))

@php
$required = html()
->span(' *')
->class('text-danger');
@endphp

@section('content')

<x-backend.card>
  <x-slot name="header">
    @lang('লাইসেন্স ফি আদায় করুন')
  </x-slot>

  <x-slot name="headerActions">
    <x-utils.link-header class="btn btn-sm btn-tool btn-secondary" icon="fas fa-backspace" :text="__('Cancel')" />
  </x-slot>

  <x-slot name="body">

    <div class="midde_cont">
      <div class="container-fluid">
        <!-- row -->
        <div class="row">

          <div class="col-md-6">
            <div class="white_shd full margin_bottom_30">
              <div class="full graph_head">
                <div class="heading1 margin_0">
                  <h2>লাইসেন্স সংক্রান্ত তথ্য</h2>
                </div>
              </div>
              <div class="table_section padding_infor_info">
                <div class="form-group">
                  <label for="exampleFormControlInput1">ক্রমিক নং:</label>
                  <input type="text" class="form-control" id="exampleFormControlInput1" value="2">
                </div>

                <div class="form-group">
                  <label for="exampleFormControlInput1">লাইসেন্স নং:</label>
                  <input type="text" class="form-control" id="exampleFormControlInput1" value="100001">
                </div>

                <div class="form-group">
                  <label for="exampleFormControlInput2">সময়কাল: হতে:</label>
                  <input type="date" class="form-control" id="exampleFormControlInput2" value="2018-07-01">
                </div>

                <div class="form-group">
                  <label for="exampleFormControlInput4">সময়কাল: পর্যন্ত:</label>
                  <input type="date" class="form-control" id="exampleFormControlInput4" value="2019-06-30">
                </div>

              </div>
            </div>
          </div>


          <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
              <div class="heading1 margin_0">
                <h2>‘এ চালান’ সংক্রান্ত তথ্য</h2>
              </div>
            </div>
            <div class="table_section padding_infor_info">
              <div class="form-group">
                <label for="exampleFormControlInput6">লাইসেন্স ফি‘র ডিডি নং:</label>
                <input type="text" class="form-control" id="exampleFormControlInput6" value="22542545">
              </div>

              <div class="form-group">
                <label for="exampleFormControlInput7">ভ্যাটের ডিডি নং:</label>
                <input type="text" class="form-control" id="exampleFormControlInput7" value="545454545">
              </div>

              <div class="form-group">
                <label for="exampleFormControlInput8">ট্যাক্সের ডিডি নং:</label>
                <input type="text" class="form-control" id="exampleFormControlInput8" value="425423435">
              </div>

              <div class="form-group">
                <label for="exampleFormControlInput9">ব্যাংক ও শাখার নাম:</label>
                <input type="text" class="form-control" id="exampleFormControlInput9" value="Sonali Bank, Lalmonirhat">
              </div>

              <div class="form-group">
                <label for="exampleFormControlInput10">‘এ চালান’ এর তারিখ:</label>
                <input type="date" class="form-control" id="exampleFormControlInput10" value="2019-06-30">
              </div>

              <div class="form-group">
                <label for="exampleFormControlInput101">মোট টাকা:</label>
                <input type="text" class="form-control" id="exampleFormControlInput101" value="8500">
              </div>

              <div class="form-group">
                <label for="exampleFormControlInput102">জ১ রশিদ নং:</label>
                <input type="text" class="form-control" id="exampleFormControlInput102" value="543545">
              </div>

              <div class="form-group">
                <label for="exampleFormControlInput103">জ১ রশিদের তারিখ:</label>
                <input type="date" class="form-control" id="exampleFormControlInput103" value="2019-06-30">
              </div>

            </div>
          </div>
        </div>
        <!-- Form Section -->


        <!-- Form Section -->
        <div class="col-md-6">
          <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
              <div class="heading1 margin_0">
                <h2>বিভিন্ন ফি’র তথ্য
                </h2>
              </div>
            </div>
            <div class="table_section padding_infor_info">
              <div class="form-group">
                <label for="exampleFormControlInput15">লাইসেন্স ফি:</label>
                <input type="text" class="form-control" id="exampleFormControlInput15" value="8000">
              </div>

              <div class="form-group">
                <label for="exampleFormControlInput17">ভ্যাট:</label>
                <input type="text" class="form-control" id="exampleFormControlInput17" value="200">
              </div>

              <div class="form-group">
                <label for="exampleFormControlInput18">ট্যাক্স:</label>
                <input type="text" class="form-control" id="exampleFormControlInput18" value="100">
              </div>

              <div class="form-group">
                <label for="exampleFormControlInput19">জরিমানা:</label>
                <input type="text" class="form-control" id="exampleFormControlInput19" value="200">
              </div>

              <div class="form-group">
                <label for="exampleFormControlInput20">সিকিউরিটি:</label>
                <input type="text" class="form-control" id="exampleFormControlInput20" value="20">
              </div>

              <div class="form-group">
                <label for="exampleFormControlInput21">প্ল্যান ফি:</label>
                <input type="text" class="form-control" id="exampleFormControlInput21" value="20">
              </div>

              <div class="form-group">
                <label for="exampleFormControlInput211">আবেদন ফি:</label>
                <input type="text" class="form-control" id="exampleFormControlInput211" value="20">
              </div>

              <div class="form-group">
                <label for="exampleFormControlInput212">নবায়ন ফি:</label>
                <input type="text" class="form-control" id="exampleFormControlInput212" value="20">
              </div>

              <div class="form-group">
                <label for="exampleFormControlInput213">নামজারী ফি:</label>
                <input type="text" class="form-control" id="exampleFormControlInput213" value="0">
              </div>

              <div class="form-group">
                <label for="exampleFormControlInput214">মোট ফি:</label>
                <input type="text" class="form-control" id="exampleFormControlInput214" value="8500">
              </div>

            </div>
          </div>
        </div>
        <!-- Form Section -->


        <!-- Form Section -->
        <div class="col-md-12">
          <div class="white_shd full margin_bottom_30">
            <button type="submit" class="btn btn-primary" style="float:right; padding: 10px 35px;">সাবমিট</button>
          </div>
        </div>
        <!-- Form Section -->

      </div>

      <!-- table section -->

    </div>

    </div>

  </x-slot>

</x-backend.card>


@endsection

@push('after-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endpush

@push('after-scripts')
<script type="text/javascript">
  var i = 0;

  $("#add").click(function() {
    ++i;
    $("#dynamicTable").append('<tr><td><input type="text" name="addmore[' + i + '][owner_name]" placeholder="লাইসেন্সীর নাম" class="form-control" /></td><td><input type="text" name="addmore[' + i + '][owner_father]" placeholder="পিতার নাম/স্বামীর নাম" class="form-control" /></td><td><input type="text" name="addmore[' + i + '][owner_address]" placeholder="ঠিকানা" class="form-control" /></td> <td><input type="text" name="addmore[' + i + '][owner_nid]" placeholder="জাতীয় পরিচয়পত্র নং" class="form-control" /></td><td><input type="text" name="addmore[' + i + '][owner_number]"  placeholder="Phone Number" class="form-control" /></td> <td><input type="file" name="addmore[' + i + '][owner_photo]" class="form-control-file"></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
  });
  $(document).on('click', '.remove-tr', function() {
    $(this).parents('tr').remove();
  });
</script>








var j = 0;

$("#add2").click(function() {

++j;

$("#dynamicTable2").append('<tr>
  <td><select class="form-control section" name="addMoreInputFields[0][section_id]" id="addMoreInputFields[0][section_id]">
      <option value="" disabled selected>সেকশনের নাম:</option>@foreach ($section as $section_val)<option value="{{ $section_val->section_id }}">{{ $section_val->section_name }}</option>@endforeach
    </select>
    <p class="text-danger error mt-2"></p>
  </td>
  <td><input type="text" name="addMoreInputFields[0][acq_case]" placeholder="Enter case number" class="form-control" />
    <p class="text-danger error mt-2"></p>
  </td>
  <td><input type="text" name="addMoreInputFields[0][gadget]" placeholder="Enter gadget name" class="form-control" />
    <p class="text-danger error mt-2"></p>
  </td>
  <td><input type="text" name="addMoreInputFields[0][page_no]" placeholder="Enter page no" class="form-control agriculture_validation " />
    <p class="text-danger error mt-2"></p>
  </td>
  <td><input type="date" name="addMoreInputFields[0][gadget_date]" placeholder="Enter gadget name" class="form-control" />
    <p class="text-danger error mt-2"></p>
  </td>
  <td><button type="button" class="btn btn-danger remove-tr2">Remove</button></td>
</tr>');
});
$(document).on('click', '.remove-tr2', function() {
$(this).parents('tr').remove();
});
</script>
@endpush