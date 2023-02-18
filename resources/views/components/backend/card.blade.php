<div class="card card-default">
  @if (isset($header))
  <div class="card-header">
    <h3 class="card-title">{{ $header }}</h3>
    @if (isset($headerActions))
    <div class="card-tools">
      {{ $headerActions }}
    </div> <!-- card-tools-->
    @endif
  </div> <!-- card-header-->
  @endif

  @if (isset($body))
  <div class="card-body">
    {{ $body }}
  </div>
  <!--card-body-->
  @endif

  @if (isset($footer))
  <div class="card-footer">
    {{ $footer }}
  </div>
  <!--card-footer-->
  @endif
</div>
<!--card-->