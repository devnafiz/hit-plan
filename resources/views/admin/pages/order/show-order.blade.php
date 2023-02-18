@extends('admin.layouts.master')
@section('title', 'All Order')
@section('content-header')
<h3 class="text-center"> All Orders</h3>
@endsection

@section('main-content')
<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div id="draggable-revert" class="x_title">
        <h2><a href="{{url('orders/create')}}"><i class="fa fa-plus"></i> Add New<span class="spinner-grow spinner-grow-sm text-success"></span></a></h2>
        <a class="btn btn-info ml-3" href="{{url('report')}}">Today Report</a>
        <a class="btn btn-info" onclick="myFunction()" href="#">Date wise Report</a>
        <a class="btn btn-info ml-3" href="{{url('excel-today')}}">Today Excel</a>
        <a class="btn btn-info ml-3" href="{{url('excel-all-order')}}">All Excel</a>
        <a class="btn" href="#" id="nameSearch">
          <form action="{{url('search')}}" method="get">
            <div class="input-group">
              <input type="search" name="search" class="form-control" placeholder="Search..">
              <span class="from-group-btn">
                <button type="submit" class="btn btn-info">Search</button>
              </span>
            </div>
          </form>

        </a>
        <a class="btn w-25 show" href="#" id="dateSearch" style="margin-left:162px;">
          <form action="{{url('search')}}" method="get">
            <div class="input-group">
              <input type="search" name="search" class="form-control datepicker" placeholder="Select Date">
              <span class="from-group-btn">
                <button type="submit" class="btn btn-info">Search</button>
              </span>
            </div>
          </form>

        </a>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-sm-12">
            <div class="card-box">
              <div id="datatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap no-footer">
                <div class="row">
                  <div class="col-sm-2">

                  </div>
                  <div class="col-sm-6">

                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">

                    <table id="datatable" class="table table-responsive table-striped table-bordered" style="width: 100%;" role="grid" aria-describedby="datatable_info">
                      <thead class="table-info">
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
                      <tbody id="">
                        <tr role="row" class="odd">
                          <td>
                            <a target="_blank" href="{{ url('/single-l-report/'.$order->id) }}" class="btn btn-info btn-sm">{{$order->id}}</a>
                          </td>
                          <td>{{$order->store_id}} </td>
                          <td>{{$order->merchant_order_id}}</td>
                          <td>{{$order->recipient_name}}</td>
                          <td>{{$order->recipient_phone}}</td>
                          <td>{{$order->recipient_address}}</td>
                          <td>{{$order->city['city_name']}}</td>
                          <td>{{$order->city['zone_name']}}</td>
                          <td>{{$order->recipient_area}}</td>
                          <td>{{$order->merchant_order_id}}</td>
                          <td>{{$order->item_type}}</td>
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
                            <a target="_blank" href="{{ url('/single-sm-report/'.$order->id) }}" class="btn btn-info btn-sm mt-2">ViewPDF</a>
                            <a target="_blank" href="{{ url('/single-l-report/'.$order->id) }}" class="btn btn-info btn-sm mt-2">Large</a>
                          </td>
                        </tr>
                      </tbody>

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


<script>
  function myFunction() {
    $("#dateSearch").toggleClass("show");
  }
  $('#draggable-revert').draggable({
  revert: true
});
</script>




@endsection