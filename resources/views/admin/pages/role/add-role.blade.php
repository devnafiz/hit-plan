@extends('admin.layouts.master')
@section('title', 'Add New User Role')
@section('content-header')
<h3>User Role</h3>
@endsection

@section('main-content')
<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Add New User Role <small><a href="{{url('roles/')}}">Preview</a></small></h2>
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
        <form method="POST" action="{{ url('roles') }}" id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
          @csrf
          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="role_name">Status <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <div class="checkbox">
                <label class="">
                  <div class="icheckbox_flat-green checked" style="position: relative;">
                    <input type="checkbox" class="flat" name="active" value="1" checked="checked" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                  </div> Checked
                </label>
              </div>
            </div>
          </div>
          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="roleName">Role Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <input type="text" id="roleName" name="roleName" required="required" value="{{ old('roleName')}}" class="form-control" placeholder="Role Name">

            </div>
          </div>
          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align">Role Description <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <textarea id="roleDescription" required="required" class="form-control" name="roleDescription" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="item form-group">
            <div class="col-md-6 col-sm-6 offset-md-3">
              <button class="btn btn-primary" type="reset">Reset</button>
              <button type="submit" class="btn btn-success">Add Role</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection