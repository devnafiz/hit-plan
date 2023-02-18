<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="{{asset('assets/plugins/print/order_print.css')}}" type="text/css" />

  <title>Patient Invoice no : {{$patient->patient_id}}</title>

</head>

<body>


  <div id="wrapper">
    <div id="receiptData">
      <div style="padding-bottom: 30px; border-bottom: 2px solid #444;">
        <div class="receipt-data">
          <div class="logo_header">
            <img style="width: 50%" src="{{asset("img/brand/logo.png")}}">
          </div> <!-- logo_header -->
          <div class="header_content ">
            <div class="content_left">
              <h3 class="site_title">CCCL Limited</h3>
              <p class=" paragraph">Business Name, 4th Floor. </p>
              <p class=" paragraph">Office full address </p>
              <p class=" paragraph">Office Location, Dhaka-1000, Bangladesh </p>
              <p class=" paragraph">Mobile +880178400000, +880185744444 </p>
              <p class=" paragraph">web: http://websiteurl.com </p>
            </div>
          </div> <!-- header_content -->

          <div class="header_right_content">
            <span class="Invoice_copy_name">Customer Copy</span>
          </div>

        </div>

        <div>

          <table class="table table-borderless table-sm">
            <tr class="border-bottom">
              <td><b>Invoice No:</b>{{$patient->patient_id}}</td>
              <td></td>
              <td><b>Invoice Date:</b>{{date('d/m/Y', strtotime($patient->updated_at))}}</td>
            </tr>
            <tr>
              <td><b>Lab ID:</b>{{$patient->patient_id}}</td>
              <td><b>Name:</b>{{$patient->patient_name}}</td>
              <td><b>Age:</b>{{$patient->age}}</td>
            </tr>
            <tr>
              <td><b>Address:</b>{{$patient->present_address}}</td>
              <td><b>Contact No:</b>{{$patient->phone}}</td>
              <td><b>E-mail:</b>{{$patient->email}}</td>
            </tr>
            <tr class="border-bottom">
              <td><b>NID:</b>{{$patient->nid_no ? $patient->nid_no : 'N/A'}}</td>
              <td><b>Passport:</b>{{$patient->passport_no ? $patient->passport_no : 'N/A'}}</td>
              <td></td>
            </tr>
          </table>

          <table class="table table-borderless table-sm">
            <tr>
              <td><b>1. Covid Test</b></td>
              <td class="text-right border-bottom"><b>Charge: {{$patient->amount}} BDT</b></td>
              <td><b>{{ucfirst($patient->payment_method)}} -</b></td>
            </tr>
            <tr>
              <td></td>
              <td class="text-right border-bottom">
                <b>Total Charge: {{$patient->amount}} BDT</b> <br>
                <b>Registration Fee: 0.00 BDT</b> <br>
                <b>Other: 0.00 BDT</b> <br>
                <b>Discount: {{$patient->discount ? $patient->discount : '0.00'}} BDT</b> <br>
                <b>Sub Total: {{$patient->amount - $patient->discount}} BDT</b>
              </td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td class="text-right" style="width:200px">
                <b>Gross Total: {{$patient->amount - $patient->discount}} BDT</b> <br>
              </td>
              <td></td>
            </tr>
          </table>

        </div>
      </div>

      <div style="margin-top: 30px">
        <div class="receipt-data">
          <div class="logo_header">
            <img style="width: 50%" src="{{asset("img/brand/logo.png")}}">
          </div> <!-- logo_header -->
          <div class="header_content ">
            <div class="content_left">
              <h3 class="site_title">CCCL Limited</h3>
              <p class=" paragraph">Business Name, 4th Floor. </p>
              <p class=" paragraph">Office full address </p>
              <p class=" paragraph">Office Location, Dhaka-1000, Bangladesh </p>
              <p class=" paragraph">Mobile +880178400000, +880185744444 </p>
              <p class=" paragraph">web: http://websiteurl.com </p>
            </div>
          </div> <!-- header_content -->

          <div class="header_right_content">
            <span class="Invoice_copy_name">Office Copy</span>
          </div>

        </div>

        <div>

          <table class="table table-borderless table-sm">
            <tr class="border-bottom">
              <td><b>Invoice No:</b>{{$patient->patient_id}}</td>
              <td></td>
              <td><b>Invoice Date:</b>{{date('d/m/Y', strtotime($patient->updated_at))}}</td>
            </tr>
            <tr>
              <td><b>Lab ID:</b>{{$patient->patient_id}}</td>
              <td><b>Name:</b>{{$patient->patient_name}}</td>
              <td><b>Age:</b>{{$patient->age}}</td>
            </tr>
            <tr>
              <td><b>Address:</b>{{$patient->present_address}}</td>
              <td><b>Contact No:</b>{{$patient->phone}}</td>
              <td><b>E-mail:</b>{{$patient->email}}</td>
            </tr>
            <tr class="border-bottom">
              <td><b>NID:</b>{{$patient->nid_no ? $patient->nid_no : 'N/A'}}</td>
              <td><b>Passport:</b>{{$patient->passport_no ? $patient->passport_no : 'N/A'}}</td>
              <td></td>
            </tr>
          </table>

          <table class="table table-borderless table-sm">
            <tr>
              <td><b>1. Covid Test</b></td>
              <td class="text-right border-bottom"><b>Charge: {{$patient->amount}} BDT</b></td>
              <td><b>{{ucfirst($patient->payment_method)}} -</b></td>
            </tr>
            <tr>
              <td></td>
              <td class="text-right border-bottom">
                <b>Total Charge: {{$patient->amount}} BDT</b> <br>
                <b>Registration Fee: 0.00 BDT</b> <br>
                <b>Other: 0.00 BDT</b> <br>
                <b>Discount: {{$patient->discount ? $patient->discount : '0.00'}} BDT</b> <br>
                <b>Sub Total: {{$patient->amount - $patient->discount}} BDT</b>
              </td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td class="text-right" style="width:200px">
                <b>Gross Total: {{$patient->amount - $patient->discount}} BDT</b> <br>
              </td>
              <td></td>
            </tr>
          </table>

        </div>
      </div>
    </div> <!-- receiptData -->




    <div style="margin-top: 30px ">
      <div class="clear-both">
        <div class="text-right">
          <small>Generated Date: {{date('d/m/Y')}}</small>
        </div>
      </div>
    </div>

    <div style="margin-top: 40px ">
      <img class="w-100" src="{{asset('img/invoice/comments.png')}}">
      <img class="w-100" src="{{asset('img/invoice/qrcode.png')}}">
    </div>




  </div> <!-- wrapper -->







  <div class="p_txt_16 no_print">
    <hr>
    <span class="pull-right col-xs-12">
      <button onclick="window.print();" class="btn btn-block btn-primary">Print</button> </span>
    <div class="clear_both"></div>
    <div class="p_txt_17">
      <div class="p_txt_18">
        Please follow these steps before you print for first tiem:
      </div>
      <p class="p_txt_19">
        1. Disable Header and Footer in browser's print setting<br>
        For Firefox: File &gt; Page Setup &gt; Margins &amp; Header/Footer &gt; Headers & Footers &gt; Make all
        --blank--<br>
        For Chrome: Menu &gt; Print &gt; Uncheck Header/Footer in More Options
      </p>
      <p class="p_txt_19">
        2. Set margin 0.5<br>
        For Firefox: File &gt; Page Setup &gt; Margins &amp; Header/Footer &gt; Headers & Footers &gt; Margins
        (inches) &gt; set all margins
        0.5<br>
        For Chrome: Menu &gt; Print &gt; Set Margins to Default
      </p>
    </div>
    <div class="clear_both"></div>
  </div>
  </div>




  <script src="{{asset("assets/plugins/print/print/jquery-2.0.3.min.js") }}"></script>
  {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" ></script> --}}
  <script src="{{asset("assets/plugins/print/print/custom.js") }}"></script>

  <script>
    // (function($){
    //   $(window).load(function () {
    //       window.print();
    //       return false;
    //   });
    // })(jQuery);

  </script>


</body>

</html>