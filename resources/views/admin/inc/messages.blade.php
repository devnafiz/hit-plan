
@if(session('success'))

<div class="alert custom-alert bg-success text-center text-light">

    <button class="btn btn-close" title="close message"><i class="fa fa-times" aria-hidden="true"></i></button>

    {{session('success')}}

</div>

@endif



@if(session('error'))

<div class="alert custom-alert bg-danger text-center text-light">

    <button class="btn btn-close" title="close message"><i class="fa fa-times" aria-hidden="true"></i></button>

    {{session('error')}}

</div>

@endif

<script>
  $(function() {
    $(document).on('click', '.btn-close', function() {

     $('.custom-alert').hide();
   

    });

    setTimeout(function() {

      $('.custom-alert').hide();

    }, 3000);
  });

 
</script>
