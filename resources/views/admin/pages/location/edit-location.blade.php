@extends('admin.layouts.master')
@section('title', 'Edit Order')
@section('content-header')
<h3 class="text-center">Edit Order</h3>
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2><a href="{{url('orders/')}}"><i class="fa fa-step-backward"></i> Back</a></h2>
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
                <form role="form" action="{{ url('orders/'.$order->id) }}" method="post" autocomplete="off">
                @method('put')   
                @csrf
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="itemType">Item Type</label>
                                <input type="text" name="itemType" class="form-control" value="{{ $order->item_type}}" id="itemType">
                                @if ($errors->has('itemType'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('itemType') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="storeName">Store Name</label>
                                <input type="text" name="storeName" class="form-control" value="{{$order->store_name}}" id="storeName" placeholder="Store Name">
                                @if ($errors->has('storeName'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('storeName') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="merchantOrderId">Merchant Order Id</label>
                                <input type="text" name="merchantOrderId" class="form-control" value="{{ $order->merchant_order_id}}" id="merchantOrderId" placeholder="Merchant Order Id">
                                @if ($errors->has('merchantOrderId'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('merchantOrderId') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" id="name" value="{{$order->name}}">
                                @if ($errors->has('name'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('name') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" class="form-control" id="phone" value="{{$order->phone}}">
                                @if ($errors->has('phone'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('phone') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" name="address" class="form-control" id="address" value="{{$order->address}}">
                                @if ($errors->has('address'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('address') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" name="amount" class="form-control" id="amount" value="{{$order->amount}}">
                                @if ($errors->has('amount'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('amount') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="submit" name="saveRole" class="btn btn-primary" value="Update Order">
                                <a href="{{ url('orders/'.$order->id.'/edit') }}" class="btn btn-danger">Reset</a>
                            </div>
                        </div>
                    </div>

                </form><!-- end form -->
            </div>
        </div>
    </div>
</div>






@endsection