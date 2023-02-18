<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="{{url('dashboard')}}" class="site_title text-center">TORA</a>
    </div>

    <div class="clearfix"></div>



    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      
      @if(Auth::check() && Auth::user()->role->id==1)
      <div class="menu_section">
        <!-- <h3>Live On</h3> -->
        <ul class="nav side-menu">
          <li><a><i class="fa fa-cart-plus"></i>Agent Manage<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{url('agents')}}">Agent's</a></li>
            </ul>
          </li>
          
        </ul>
      </div>
      <div class="menu_section">
        <ul class="nav side-menu">
          <li><a><i class="fa fa-cogs"></i>Manage <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a><i class="fa fa-users"></i>User Management<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  <li class="sub_menu"><a href="{{url('users/create')}}">Add User</a>
                  </li>
                  <li><a href="{{url('users')}}">View User</a>
                  </li>
                </ul>
              </li>
              <li><a>Role Management<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  <li class="sub_menu"><a href="{{url('roles/create')}}">Add User Role</a>
                  </li>
                  <li><a href="{{url('roles')}}">View User Role</a>
                  </li>
                </ul>
              </li>
              <li><a>Location Management<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  <li class="sub_menu"><a href="{{url('locations/create')}}">Add Location</a>
                  </li>
                  <li><a href="{{url('locations')}}">View Location</a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      @endif
    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <!--<div class="sidebar-footer hidden-small">-->
    <!--  <a data-toggle="tooltip" data-placement="top" title="Settings">-->
    <!--    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>-->
    <!--  </a>-->
    <!--  <a data-toggle="tooltip" data-placement="top" title="FullScreen">-->
    <!--    <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>-->
    <!--  </a>-->
    <!--  <a data-toggle="tooltip" data-placement="top" title="Lock">-->
    <!--    <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>-->
    <!--  </a>-->
    <!--  <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('logout') }}" onclick="event.preventDefault();-->
    <!--                 document.getElementById('logout-form').submit();">-->
    <!--    <span class="glyphicon glyphicon-off" aria-hidden="true"></span>-->
    <!--  </a>-->
    <!--</div>-->
    <!-- /menu footer buttons -->
  </div>
</div>