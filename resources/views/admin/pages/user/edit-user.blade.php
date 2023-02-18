@extends('admin.layouts.master')
          @section('title', 'Update User')
          @section('content-header')
          <h3>Update User Form</h3>
          @endsection

          @section('main-content')
          <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Update User <small><a href="{{url('users/')}}">Preview</a></small></h2>
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
                    <form role="form" action="{{ url('users/'.$user->id) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                @method('put')
                @csrf
                <div class="form-row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <?php $checked = $user->block_status == 1 ? 'checked' : '' ?>
                            <label>
                                <input type="checkbox" class="minimal" name="active" value="1" {{$checked}}> Active
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-sm-3">
						 <div class="form-group">
                                <label for="image">
                                    <img src="{{ asset('uploads/users/'.$user->picture) }}" id="s_photo" class="img-responsive border"
                                    style="height: 180px; display: inline;">
                                </label>
                                <input type="file" onchange="previewFile()" name="image" id="image" class="position-absolute invisible">
                            </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <label for="niceName">Nice name</label>
                            <input type="text" name="niceName" class="form-control" value="{{ $user->nice_name }}" id="niceName" placeholder="Nice name">
                            @if ($errors->has('niceName'))
                            <p class="text-danger">
                                <small>{{ $errors->first('niceName') }}</small>
                            </p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" id="email" placeholder="Email address">
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
                            <input type="text" name="UserName" class="form-control" value="{{ $user->name }}" id="UserName" placeholder="Username">
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
                            <input type="text" name="phone" value="{{ $user->phone }}" class="form-control form-control-sm" id="phone"
                                placeholder="Phone number">
                             @if ($errors->has('phone'))
                            <p class="text-danger">
                                <small>{{ $errors->first('phone') }}</small>
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?php 
                                $male = $user->gender == 'Male' ? 'checked' : '';
                                $female = $user->gender == 'Female' ? 'checked' : '';
                            ?>
                            <br>
                            <label><input type="radio" name="gender" class="minimal" value="Male" {{$male}}> Male </label>
                            <label><input type="radio" name="gender" class="minimal" value="Female" {{$female}}> Female </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="userRole">Role</label>
                            <select class="form-control select2" name="userRole" id="userRole">
                                @foreach($roles as $role)  
                                    @if( $user->role_id == $role->id )
                                    <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                    @endif
                                @endforeach
                                <option value="0">None</option>
                                @foreach($roles as $role)  
                                    @if( $user->role_id !== $role->id )
                                    <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                    @endif
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
                            <input type="submit" name="saveRole" class="btn btn-primary" value="update user">
                            <a href="{{ url('user/'.$user->id.'/edit')}}" class="btn btn-danger">Reset</a>
                        </div>
                    </div>
                </div>
                
            </form><!-- end form -->
                  </div>
                </div>
              </div>
            </div>
         
         
         
         
         
         
          @endsection

          
        
