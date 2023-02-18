<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('assets/backend/images/favi.png') }}" type="image/ico" />

    <title>@yield('title') | Tora</title>

    <!-- Bootstrap -->
    <link href="{{ asset('assets/backend/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('assets/backend/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('assets/backend/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('assets/backend/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="{{ asset('assets/backend/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}"
        rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ asset('assets/backend/vendors/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('assets/backend/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('assets/backend/build/css/custom.min.css') }}" rel="stylesheet">
    <!-- Jquery DatePicker -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://jqueryui.com/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .form-control {
            background: #f5f6f7;
        }

        ::selection {
            background: #FE5757;
            color: #fff;
            text-shadow: none;
        }

        .input-group {
            margin-bottom: 0px;
        }

        /* For Datepicker Toggle */
        .show {
            display: none;
        }

        /* message close */
        .custom-alert {
            position: fixed;
            top: 50px;
            right: 0;
            z-index: 99999;
            width: 300px;
            margin: 0;
            color: #fff;
            border: 0;
        }

        .btn-close {
            background: transparent;
            border: 0;
            float: left;
            font-size: 16px;
            padding: 0;
            color: #fff !important;
        }

        .bg-success {
            background: #52c234;
            background: -webkit-linear-gradient(to left, #061700, #52c234);
            background: linear-gradient(to left, #061700, #52c234);
        }

        .bg-danger {
            background: #DC2424;
            /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #4A569D, #DC2424);
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #4A569D, #DC2424);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }

        .moveIconstyle {
            font-size: 16px;
            margin: 2px 10px 2px 0;
        }

    </style>
    <script>
        jQuery(document).ready(function($) {
            $('.datepicker').datepicker({
                dateFormat: "yy-mm-dd"
            });
        });
    </script>
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">

            @include('admin.inc.sidebar')
            @include('admin.inc.navbar')

            <!-- page content -->
            <div class="right_col" role="main">
                <!-- top tiles -->
                @yield('content-header')
                <!-- /top tiles -->

                <!-- main content -->
                @include('admin.inc.messages')
                @yield('main-content')
                <!-- /main content -->
            </div>
            <!-- /page content -->

            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    Created by <a href="https://avanteca.com.bd/" target="_blank"><img style="width: 70px;"
                            src="https://avanteca.com.bd/wp-content/uploads/2020/12/smalllogo.png"
                            alt="Company logo"></a>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets/backend/vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assets/backend/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('assets/backend/vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('assets/backend/vendors/nprogress/nprogress.js') }}"></script>
    <!-- Chart.js')}} -->
    <script src="{{ asset('assets/backend/vendors/Chart.js') }}/dist/Chart.min.js')}}"></script>
    <!-- gauge.js')}} -->
    <script src="{{ asset('assets/backend/vendors/gauge.js/dist/gauge.min.js') }}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{ asset('assets/backend/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('assets/backend/vendors/iCheck/icheck.min.js') }}"></script>
    <!-- Skycons -->
    <script src="{{ asset('assets/backend/vendors/skycons/skycons.js') }}"></script>
    <!-- Flot -->
    <script src="{{ asset('assets/backend/vendors/Flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/backend/vendors/Flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('assets/backend/vendors/Flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('assets/backend/vendors/Flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('assets/backend/vendors/Flot/jquery.flot.resize.js') }}"></script>
    <!-- Flot plugins -->
    <script src="{{ asset('assets/backend/vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
    <script src="{{ asset('assets/backend/vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendors/flot.curvedlines/curvedLines.js') }}"></script>
    <!-- DateJS -->
    <script src="{{ asset('assets/backend/vendors/DateJS/build/date.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('assets/backend/vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
    <script src="{{ asset('assets/backend/vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('assets/backend/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{ asset('assets/backend/vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset('assets/backend/build/js/custom.min.js') }}"></script>


    <script>
        $(function() {

            //Initialize Select2 Elements

            $(".select2").select2();



            //Datemask dd/mm/yyyy

            $("#datemask").inputmask("dd/mm/yyyy", {

                "placeholder": "dd/mm/yyyy"

            });

            //Datemask2 mm/dd/yyyy

            $("#datemask2").inputmask("mm/dd/yyyy", {

                "placeholder": "mm/dd/yyyy"

            });

            //Money Euro

            $("[data-mask]").inputmask();



            //Date range picker

            $('#reservation').daterangepicker();

            //Date range picker with time picker

            $('#reservationtime').daterangepicker({

                timePicker: true,

                timePickerIncrement: 30,

                format: 'MM/DD/YYYY h:mm A'

            });

            //Date range as a button

            $('#daterange-btn').daterangepicker({

                    ranges: {

                        'Today': [moment(), moment()],

                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],

                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],

                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],

                        'This Month': [moment().startOf('month'), moment().endOf('month')],

                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,

                            'month').endOf('month')]

                    },

                    startDate: moment().subtract(29, 'days'),

                    endDate: moment()

                },

                function(start, end) {

                    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(

                        'MMMM D, YYYY'));

                }

            );



            //Date picker

            $('#datepicker').datepicker({

                autoclose: true

            });



            //iCheck for checkbox and radio inputs

            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({

                checkboxClass: 'icheckbox_minimal-blue',

                radioClass: 'iradio_minimal-blue'

            });

            //Red color scheme for iCheck

            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({

                checkboxClass: 'icheckbox_minimal-red',

                radioClass: 'iradio_minimal-red'

            });

            //Flat red color scheme for iCheck

            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({

                checkboxClass: 'icheckbox_flat-green',

                radioClass: 'iradio_flat-green'

            });



            //Colorpicker

            $(".my-colorpicker1").colorpicker();

            //color picker with addon

            $(".my-colorpicker2").colorpicker();



            //Timepicker

            $(".timepicker").timepicker({

                showInputs: false

            });



            //Timepicker

            $(document).on('click', '.btn-close', function() {

                //$('.custom-alert').hide();
                alert('ok');

            });

            setTimeout(function() {

                $('.custom-alert').hide();

            }, 3000);

        });
    </script>
    <!-- script for input image outo preview-->
    <script>
        // image preview 
        $("#s_photo").change(function() {
            readURL(this);
        });
        // image preview function
        function previewFile() {
            var preview = document.querySelector('#s_photo'); //selects the query named img
            var file = document.querySelector('input[type=file]').files[0]; //sames as here
            var reader = new FileReader();
            reader.onloadend = function() {
                preview.src = reader.result;
            }
            if (file) {
                reader.readAsDataURL(file); //reads the data as a URL
            } else {
                file.preview.src = '<img src="assets/backend/users/noimage.jpg" />';
            }
        }
        previewFile(); //calls the function named previewFile()
    </script>

</body>

</html>
