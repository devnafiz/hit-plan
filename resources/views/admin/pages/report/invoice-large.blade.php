<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice</title>
  <link href="{{asset('assets/backend/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
  <style>
    body {
      background-color: #fff;
    }

    .page-break {
      page-break-after: always;
    }

    .hr {
      border-top: 1px dashed gray;
    }
  </style>
</head>

<body>

  <div class="content-wrapper mb-4">
    <div class="float-left">
      <img width="150" src="{{url('uploads/logo.jpg')}}" alt="Company logo">
    </div>
    <div class="float-right">
      <p class="m-0">Creation Edge</p>
      <p class="m-0">
        34/1-A Hatkhola Road
        Dhaka, Bangladesh
      </p>
      <p class="m-0">Dhaka 1203</p>
      <p class="m-0">Phone : 01755-616058</p>
      <p class="m-0">Email : omiointernational@gmail.com</p>
    </div>
    <div class="clearfix"></div>
    <h2 class="text-center bg-secondary text-light">Purchase Summary</h2>
    <div class="float-left">
      <p class="m-0">Invoice To</p>
      <p class="m-0"><strong>Rakib</strong></p>
      <p class="m-0">Address: Dhaka</p>
      <p class="m-0">Phone: 01311718302</p>
    </div>
    <div class="float-right">
      <p class="m-0">Order Date: 22.06.2022</p>
    </div>
    <div class="clearfix"></div>
    <h6 class="">Type of Supplay: Cash On Delivery</h6>
    <table class="table table-striped table-bordered mb-5">
      <thead class="bg-dark text-light">
        <tr role="row">
          <th class="align-middle">Merchant Order ID</th>
          <th class="align-middle">Name</th>
          <th class="align-middle">Phone</th>
          <th class="align-middle">Address</th>
          <th class="align-middle">Amount</th>
        </tr>
      </thead>
      <tr role="row" class="odd">
        <td>1</td>
        <td>Rakib</td>
        <td>01311718302</td>
        <td>Khilkhet, Dhaka</td>
        <td>100</td>
      </tr>
    </table>
    <div class="clearfix"></div>
    <div class="hr"></div>
  </div>

</body>

</html>