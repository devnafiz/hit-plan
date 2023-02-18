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
      <p class="m-0"><strong>{{$order->recipient_name}}</strong></p>
      <p class="m-0">Address:{{$order->recipient_address}}</p>
      <p class="m-0">Phone: {{$order->recipient_phone}}</p>
    </div>
    <div class="float-right">
      <p class="m-0">Order Date: {{$order->created_at}}</p>
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
        <td>{{$order->id}}{{$order->merchant_order_id}}</td>
        <td>{{$order->recipient_name}}</td>
        <td>{{$order->recipient_phone}}</td>
        <td>{{$order->recipient_address}}</td>
        <td>{{$order->amount_to_collect}}</td>
      </tr>
    </table>
    <div class="clearfix"></div>
    <div class="hr"></div>
  </div>
</body>

</html>