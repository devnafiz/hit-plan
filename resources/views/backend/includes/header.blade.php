<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fa fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
        </li>
    </ul>

    <input type="hidden" id="check-user" value="{{$logged_in_user->type}}">

    <!-- SEARCH FORM -->
    {{-- <form class="form-inline ml-3">
    <div class="input-group input-group-sm">
      <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
      <div class="input-group-append">
        <button class="btn btn-navbar" type="submit">
          <i class="fa fa-search"></i>
        </button>
      </div>
    </div>
  </form> --}}

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="icon-bell"></i>
                <span class="badge badge-warning navbar-badge">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">0 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 0 new messages
                    <span class="float-right text-muted text-sm">0 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <img src="{{ $logged_in_user->avatar }}" class="img-circle" style="width: 25px;">
                <span class="d-md-down-none">{{ $logged_in_user->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                @if ($logged_in_user->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="dropdown-item">Administration</a>
                @endif
                @if ($logged_in_user->isUser())
                <a href="{{ route('frontend.user.dashboard') }}" class="dropdown-item">Dashboard</a>
                @endif
                <a href="{{ url('dashboard#password') }}" class="dropdown-item">Change password</a>
                <a href="/logout" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item">@lang('Logout')</a>

                <form method="post" action="{{ route('frontend.auth.logout') }}" id="logout-form" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>