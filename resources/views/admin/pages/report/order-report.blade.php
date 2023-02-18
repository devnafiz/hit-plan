@extends('admin.layouts.master')
@section('title', 'All Order')
@section('content-header')
<h3 class="text-center">
  <a class="btn btn-info" href="{{url('invoice-pdf-show')}}"><i class="fa fa-folder-open"></i> ViewPDF</a>
  <a class="btn btn-info" href="{{url('invoice-pdf-show-large')}}"><i class="fa fa-folder-open"></i> ViewPDF-Large</a>
  Today Orders
  <a class="btn btn-info" href="{{url('invoice-pdf-download')}}"><i class="fa fa-download"></i> SavePDF</a>
</h3>
@endsection

@section('main-content')
<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <!-- <div class="x_title">
        <h2><a href="{{url('orders/create')}}"><i class="fa fa-plus"></i> Add New<span class="spinner-grow spinner-grow-sm text-success"></span></a></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div> -->
      <div class="x_content">
        <div class="row">
          <div class="col-sm-12">
            <div class="card-box table-responsive">
              <div id="datatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap no-footer">
                <div class="row">
                  <div class="col-sm-12">

                    <table id="datatable" class="table table-responsive table-striped table-bordered" style="width: 100%;" role="grid" aria-describedby="datatable_info">
                      <thead>
                        <tr role="row">
                          <th>#ID</th>
                          <th>Store ID</th>
                          <th>Marchant Order ID</th>
                          <th>Customer Name</th>
                          <th>Phone</th>
                          <th>Address</th>
                          <th>City</th>
                          <th>Zone</th>
                          <th>Area</th>
                          <th>Delivery Time</th>
                          <th>Item Type</th>
                          <th>Instraction</th>
                          <th>QTY</th>
                          <th>Weight(kg)</th>
                          <th>Price</th>
                          <th>Amount To Collect</th>
                          <th>Date</th>
                          <th>Status</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                      @foreach($orders as $order)
                      <tr role="row" class="odd">
                        <td>
                          <a href="{{ url('/single-sm-report/'.$order->id) }}" class="btn btn-primary btn-sm">{{$order->id}}</a>
                        </td>
                        <td>
                          @if($order->store_id==15)
                          Creation Edge Delivery Office
                          @else
                          {{$order->store_id}}
                          @endif
                        </td>
                        <td>{{$order->merchant_order_id}}</td>
                        <td>{{$order->recipient_name}}</td>
                        <td>{{$order->recipient_phone}}</td>
                        <td>{{$order->recipient_address}}</td>
                        <td>{{$order->recipient_city}}</td>
                        <td>{{$order->recipient_zone}}</td>
                        <td>{{$order->recipient_area}}</td>
                        <td>
                          @if($order->delivery_type==48)
                          Normal Delivery(48-72 hours)
                          @else
                          On Demand Delivery (same day)
                          @endif
                        </td>
                        <td>
                          @if($order->item_type==1)
                          Document
                          @elseif($order->item_type==2)
                          Parcel
                          @endif
                        </td>
                        <td>{{$order->special_instruction}}</td>
                        <td>{{$order->item_quantity}}</td>
                        <td>{{$order->item_weight}}</td>
                        <td>Tk.{{$order->price}}</td>
                        <td>{{$order->amount_to_collect}}</td>
                        <td>{{$order->created_at}}</td>
                        <td class="text-danger">Panding..</td>
                        <td>
                          @if(Auth::check() && Auth::user()->role->id==1)
                          <a href="{{ url('/orders/'.$order->id.'/edit') }}" class="text-primary"><i class="fa fa-edit fa-lg"></i> |</a>
                          <a class="text-danger" href="#" onclick="event.preventDefault(); document.getElementById('edit-form-{{$order->id}}').submit();"> <i class="fa fa-trash fa-lg"></i></a>

                          <form id="edit-form-{{$order->id}}" action="{{ url('/orders/'.$order->id) }}" method="POST" style="display: none;">
                            @method('delete')
                            @csrf
                          </form>
                          @endif
                          <a href="{{ url('/single-sm-report/'.$order->id) }}" class="btn btn-info btn-sm mt-2">ViewPDF</a>
                          <a href="{{ url('/single-l-report/'.$order->id) }}" class="btn btn-info btn-sm mt-2">Large</a>
                        </td>
                      </tr>
                      @endforeach
                    </table>
                  </div>
                </div>
                <div class="row">
                  {{$orders->links()}}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection