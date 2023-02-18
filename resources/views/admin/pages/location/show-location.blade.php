@extends('admin.layouts.master')
@section('title', 'All Location')
@section('content-header')
<h3 class="text-center"> All Location</h3>
@endsection

@section('main-content')
<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2><a href="{{url('locations/create')}}"><i class="fa fa-plus"></i> Add New<span class="spinner-grow spinner-grow-sm text-success"></span></a></h2>

        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-sm-12">
            <div class="card-box table-responsive">
              <div id="datatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap no-footer">
                <div class="row">
                  <div class="col-sm-12">
                    <table id="datatable" class="table table-striped table-bordered dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="datatable_info">
                      <thead>
                        <tr role="row">
                          <th>#ID</th>
                          <th>City ID</th>
                          <th>City Name</th>
                          <th>Zone ID</th>
                          <th>Zone Name</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                      @foreach($city_zones as $city_zone)
                      <tr role="row" class="odd">
                        <td>{{$city_zone->id}}</td>
                        <td>{{$city_zone->city_id}}</td>
                        <td>{{$city_zone->city_name}}</td>
                        <td>{{$city_zone->zone_id}}</td>
                        <td>{{$city_zone->zone_name}}</td>
                        <td>
                        </td>
                      </tr>
                      @endforeach
                    </table>
                  </div>
                </div>
                <div class="row">
                  {{$city_zones->links()}}
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