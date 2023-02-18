<!DOCTYPE html>
<html lang="en">

<head>
  <title>CMIS | Invoice</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="{{asset('assets/backend/pdf/bootstrap.min.css')}}" rel="stylesheet">
  <script src="{{asset('assets/backend/pdf/jquery.min.js')}}"></script>
  <script src="{{asset('assets/backend/pdf/bootstrap.min.js')}}"></script>
  <style>
    .border {
      border: 1px dashed gray;
      margin-left: 20px;
    }

    img {
      margin-top: 10px;
      margin-bottom: 10px;
    }

    p {
      margin: 0px;
    }

    .content {
      margin-bottom: 10px;
    }
  </style>
</head>

<body>

  <div class="container">
    <div class="row">
      <div class="col-xs-3 border" style="margin-bottom:40px;">
        <div style="width: 20%; margin-left:35%;">
          <img width="50" src="{{url('uploads/logo.jpg')}}" alt="Company logo">
        </div>
        <div class="text-left content">
          <p><strong>Name: {{$order->recipient_name}}</strong></p>
          <p>Address: {{$order->recipient_address}}</p>
          <p>Phone: {{$order->recipient_phone}}</p>
          <p>MOID: {{$order->merchant_order_id}}</p>
          <p>Amount: {{$order->amount_to_collect}} BDT</p>
        </div>
      </div>
    </div>
  </div>

</body>

</html>