@extends('admin.layouts.master')
@section('title', 'Add New User')
@section('content-header')
<h3>User Registration Form</h3>
@endsection

@section('main-content')
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Add New User <small><a href="{{url('users/')}}">Preview</a></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a class="dropdown-item" href="#">Settings 1</a>
                            </li>
                            <li><a class="dropdown-item" href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <form role="form" action="{{ url('users') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" class="minimal" name="active" value="1" checked> Active
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="image">
                                    <img src="{{ asset('assets/backend/users/noimage.jpg')}}" id="s_photo" class="img-responsive border" style="height:180px; display: inline;">
                                </label>
                                <input type="file" onchange="previewFile()" name="image" id="image" class="position-absolute invisible">
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <label for="niceName">Nice name</label>
                                <input type="text" name="niceName" class="form-control" value="{{ old('niceName')}}" id="niceName" placeholder="Nice name">
                                @if ($errors->has('niceName'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('niceName') }}</small>
                                </p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email')}}" id="email" placeholder="Email address">
                                @if ($errors->has('email'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('email') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="UserName">Username</label>
                                <input type="text" name="UserName" class="form-control" value="{{ old('UserName')}}" id="UserName" placeholder="Username">
                                @if ($errors->has('UserName'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('UserName') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" class="form-control form-control-sm" id="phone" placeholder="Phone number">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <br>
                                <label><input type="radio" name="gender" class="minimal" value="Male"> Male </label>
                                <label><input type="radio" name="gender" class="minimal" value="Female"> Female </label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="userRole">Role</label>
                                <select class="form-control select2" name="userRole" id="userRole">
                                    <option value="">None</option>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id}}">{{ $role->role_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('userRole'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('userRole') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                                @if ($errors->has('password'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('password') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm Password">
                                @if ($errors->has('password_confirmation'))
                                <p class="text-danger">
                                    <small>{{ $errors->first('password_confirmation') }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="submit" name="saveRole" class="btn btn-primary" value="Add user">
                                <a href="{{ url('role/create')}}" class="btn btn-danger">Reset</a>
                            </div>
                        </div>
                    </div>

                </form><!-- end form -->
            </div>
        </div>
    </div>
</div>






@endsection