@extends('admin.layouts.master')
@section('title', 'Add Order')
@section('content-header')
<h3 class="text-center">Create Order Form</h3>
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2><a href="{{url('orders/')}}"><i class="fa fa-eye"></i> Preview</a></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <form role="form" action="{{ url('orders') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="form-row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="storeId">Store (*)</label>
                                <select class="form-control" name="storeId" id="storeId">
                                    <option value="Creation Edge Delivery Office">Creation Edge Delivery Office</option>
                                </select>
                                @if ($errors->has('storeId'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('storeId') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="itemType">Product Type (*)</label>
                                <select class="form-control" name="itemType" id="itemType">
                                    <option value="document">Document</option>
                                    <option value="parcel" selected>Parcel</option>
                                </select>
                                @if ($errors->has('itemType'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('itemType') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="merchantOrderId">Merchant Order Id</label>
                                <input type="text" name="merchantOrderId" class="form-control" value="{{ old('merchantOrderId')}}" id="merchantOrderId">
                                @if ($errors->has('merchantOrderId'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('merchantOrderId') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-7">
                            <h2 class="text-dark">Recipient Detail</h2>
                            <div class="form-row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="recipientName">Recipient Name (*)</label>
                                        <input type="text" name="recipientName" class="form-control" value="{{ old('recipientName')}}" id="recipientName">
                                        @if ($errors->has('recipientName'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('recipientName') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="phone">Recipient Phone (*)</label>
                                        <input type="number" name="phone" class="form-control" value="{{ old('phone')}}" id="phone">
                                        @if ($errors->has('phone'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('phone') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="address">Recipient Address (*)</label>
                                        <textarea rows="2" cols="50" placeholder="Recipient Address" class="form-control" name="address" id="address">{{ old('address')}}</textarea>
                                        <div><i>Only english character is allowed.</i></div>
                                        @if ($errors->has('address'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('address') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txtCity">Recipient City (*)</label>
                                        <select class="form-control" name="txtCity" id="txtCity">

                                            @foreach($cities as $city)
                                            @if($city->city_name == 'Dhaka')
                                            <option value="{{$city->city_id}}" selected>{{$city->city_name}}</option>
                                            @else
                                            <option value="{{$city->city_id}}">{{$city->city_name}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('txtCity'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('txtCity') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txtZone">Recipient Zone (*)</label>
                                        <select class="form-control" name="txtZone" id="txtZone">
                                        <option value="">Select...</option>
                                            @foreach($dhaka_zone as $zone)
                                            <option value="{{$zone->zone_id}}">{{$zone->zone_name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('txtZone'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('txtZone') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <h2 class="text-dark">Delivery Information</h2>
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="deliveryType">Delivery Time</label>
                                        <select class="form-control" name="deliveryType" id="deliveryType">
                                            <option value="Normal Delivery(48-72 hours)" selected>Normal Delivery(48-72 hours)</option>
                                            <option value="On Demand Delivery (same day)" disabled>On Demand Delivery (same day)</option>
                                        </select>
                                        @if ($errors->has('deliveryType'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('deliveryType') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="itemWeight">Total Weight (KG)</label>
                                        <select name="itemWeight" class="form-control custom-select" id="itemWeight">
                                            <option value="0.5">0-0.5</option>
                                            <option value="1">0.5-1</option>
                                            <option value="2">1-2</option>
                                            <option value="3">2-3</option>
                                            <option value="4">3-4</option>
                                            <option value="5">4-5</option>
                                            <option value="6">5-6</option>
                                            <option value="7">6-7</option>
                                            <option value="8">7-8</option>
                                            <option value="9">8-9</option>
                                            <option value="10">9-10</option>
                                            <option value="12">10-12</option>
                                            <option value="13">13-15</option>
                                        </select>
                                        @if ($errors->has('itemWeight'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('itemWeight') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="itemQty">Quantity (*)</label>
                                        <input type="number" name="itemQty" class="form-control" id="itemQty" value="1">
                                        @if ($errors->has('itemQty'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('itemQty') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txtPrice">Price</label>
                                        <input type="number" name="txtPrice" class="form-control" value="{{ old('txtPrice')}}" id="txtPrice" placeholder="Price">
                                        @if ($errors->has('txtPrice'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('txtPrice') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="amount">Amount To Collect ৳ (*)</label>
                                        <input type="number" name="amount" class="form-control" value="{{ old('amount')}}" id="amount">
                                        @if ($errors->has('amount'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('amount') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="spInstruction">Special Instraction</label>
                                        <textarea rows="2" cols="50" placeholder="Special Instraction" class="form-control" name="spInstruction" id="spInstruction">{{ old('spInstruction')}}</textarea>
                                        <div><i>Only english character is allowed.</i></div>
                                        @if ($errors->has('spInstruction'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('spInstruction') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="itemDesc">Item Description & Item Price</label>
                                        <textarea rows="2" cols="50" placeholder="Item Description & Item Price" class="form-control" name="itemDesc" id="itemDesc"></textarea>
                                        <div><i>Only english character is allowed.</i></div>
                                        @if ($errors->has('itemDesc'))
                                        <p class="text-danger">
                                            <small>{{ $errors->first('itemDesc') }}</small>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="submit" name="saveRole" class="btn btn-primary" value="Save">
                                <a href="{{ url('orders/create')}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </div>





                </form><!-- end form -->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // JSON For Subjects
        $("#txtCity").on("change", function() {
            var city_id = $(this).val();
            //alert(city_id);
            var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

            $.getJSON('{{ URL::to("/getzone") }}', {
                _token: CSRF_TOKEN,
                id: city_id
            }, function(res, status, xhr) {
                console.log(res);
                if (status == 'success') {
                    var zone = '';
                    var common = {
                        zone_id: '',
                        zone_name: 'Select...'
                    }
                    //res.splice(position, numberOfItemToRemove, item)
                    res.splice(0, 0, common); //Add array object
                    $.each(res, function(index, row) {
                        zone += '<option value="' + row.zone_id + '">' + row.zone_name + '</option>';
                    });
                    $('#txtZone').empty().append(zone);
                }
            })


        });


    });
</script>

@endsection