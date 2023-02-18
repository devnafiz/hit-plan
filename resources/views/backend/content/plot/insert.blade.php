<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 8 Add/Remove Multiple Input Fields Example</title>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 600px;
        }
    </style>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</div>
<div class="container">
    <form action="{{ url('store-input-fields') }}" method="POST">
        @csrf
        <input type="hidden" name="addMoreInputFields[0][ledger_id]"
               @foreach($ledger_number as $ledger)
               value="{{ $ledger->ledger_id }}"
        @endforeach" class="form-control"
        />
        <input type="hidden" name="addMoreInputFields[0][user_id]" value="{{ Auth::user()->id }}" class="form-control" />
        <input type="hidden" name="addMoreInputFields[0][user_status]" value="{{ Auth::user()->user_status }}" class="form-control" />
        <table class="table table-bordered" id="dynamicAddRemove">
            <tr>
            <tr>
                <th>Plot Number</th>
                <th>Land Type</th>
                <th>Land Apount</th>
                <th>Unit</th>
                <th action></th>
            </tr>
            <tr>
                <td><input type="text" name="addMoreInputFields[0][plot_number]" placeholder="Enter plot number" class="form-control" /></td>
                <td>
                    <select required  class="form-control" name="addMoreInputFields[0][land_type]" name="addMoreInputFields[0][land_type]">
                        <option value="" disabled selected>জমির ধরণ বাছাই করুন</option>
                        @foreach($land_type as $land)
                            <option value="{{ $land->land_type_id }}">{{ $land->land_type }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" name="addMoreInputFields[0][land_amount]" placeholder="Enter land amount" class="form-control" /></td>
                <td><input type="text" name="addMoreInputFields[0][land_amount_unit]" placeholder="Enter land amount unit" class="form-control" /></td>

                <td><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">+</button></td>
            </tr>
        </table>
        <button type="submit" class="btn btn-outline-success btn-block">Save</button>
    </form>
</div>
</body>
<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
    var i = 0;
    $("#dynamic-ar").click(function () {
        ++i;
        $("#dynamicAddRemove").append('<tr><td><input type="text" name="addMoreInputFields[' + i +
            '][plot_number]" placeholder="Enter plot number" class="form-control" /></td><td><select class="form-control" name="addMoreInputFields[0][land_type]" name="addMoreInputFields[0][land_type]"> <option value="" disabled selected>জমির ধরণ বাছাই করুন</option><option value="" >জমির ধরণ বাছাই করুন</option></select></td><td><input type="text" name="addMoreInputFields[' + i +
            '][land_amount]" placeholder="Enter subject" class="form-control" /></td><td><input type="text" name="addMoreInputFields[' + i +
            '][land_amount_unit]" placeholder="Enter subject" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">-</button></td></tr>'
        );
    });
    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });
</script>
</html>
