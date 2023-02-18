@extends('admin.layouts.master')
@section('title', 'Agent List')
@section('content-header')
    <h3 class="text-center"> All Agent's</h3>
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div id="draggable-revert" class="x_title">
                    <!-- <h2><a href="{{ url('orders/create') }}"><i class="fa fa-plus"></i> Add New<span class="spinner-grow spinner-grow-sm text-success"></span></a></h2> -->
                    <!--<a class="btn btn-info ml-3" href="{{ url('report') }}">Today Report</a>-->
                    <!--<a class="btn btn-info" onclick="myFunction()" href="#">Date wise Report</a>-->
                    <!--<a class="btn btn-info ml-3" href="{{ url('excel-today') }}">Today Excel</a>-->
                    <!--<a class="btn btn-info ml-3" href="{{ url('excel-all-order') }}">All Excel</a>-->
                    <a class="btn" href="#" id="nameSearch">
                        <form action="{{ url('agent-search') }}" method="get">
                            <div class="input-group">
                                <input type="search" name="search" class="form-control" placeholder="Search..">
                                <span class="from-group-btn">
                                    <button type="submit" class="btn btn-info">Search</button>
                                </span>
                            </div>
                        </form>

                    </a>
                    <a class="btn w-25 show" href="#" id="dateSearch" style="margin-left:162px;">
                        <form action="{{ url('agent-search') }}" method="get">
                            <div class="input-group">
                                <input type="search" name="search" class="form-control datepicker"
                                    placeholder="Select Date">
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
                                <div id="datatable_wrapper"
                                    class="dataTables_wrapper container-fluid dt-bootstrap no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">

                                            <table id="datatable"
                                                class="table table-responsive table-striped table-bordered"
                                                style="width: 100%;" role="grid" aria-describedby="datatable_info">
                                                <thead class="table-info">
                                                    <tr role="row">
                                                        <th>#ID</th>
                                                        <th>Name</th>
                                                        <th>E-mail</th>
                                                        <th>Phone</th>
                                                        <th>District</th>
                                                        <th>Thana</th>
                                                        <th>Date</th>
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>
                                                @foreach ($agents as $agent)
                                                    <tbody id="">
                                                        <tr role="row" class="odd">
                                                            <td>
                                                                <a target="_blank" href=""
                                                                    class="btn btn-info btn-sm">{{ $agent->id }}</a>
                                                            </td>
                                                            <td>{{ $agent->user->name }}</td>
                                                            <td>{{ $agent->user->email }}</td>
                                                            <td>{{ $agent->user->phone }}</td>
                                                            <td>{{ $agent->district_present }}</td>
                                                            <td>{{ $agent->police_station_present }}</td>
                                                            <td>{{ $agent->created_at }}</td>
                                                            <td>
                                                                @if (Auth::check() && Auth::user()->role->id == 1)
                                                                    <a href="{{ url('/agents/' . $agent->id . '/edit') }}"
                                                                        class="text-primary"><i
                                                                            class="fa fa-edit fa-lg"></i> |</a>
                                                                    <a class="text-danger" href="#"
                                                                        onclick="event.preventDefault(); document.getElementById('edit-form-{{ $agent->user->id }}').submit();">
                                                                        <i class="fa fa-trash fa-lg"></i></a>

                                                                    <form id="edit-form-{{ $agent->user->id }}"
                                                                        action="{{ url('/agents/' . $agent->user->id) }}"
                                                                        method="POST" style="display: none;">
                                                                        @method('delete')
                                                                        @csrf
                                                                    </form>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>

                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">

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
