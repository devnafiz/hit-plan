<div class="btn-group btn-group-sm">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
    <i class="fas fa-cog nav-icon"></i>
  </button>
  <div class="dropdown-menu" role="menu" style="">
    <a class="dropdown-item btnProcess" href="{{ route('admin.agri-license-fees.edit', $balam->id) }}"><i class="ti-pencil-alt"></i> Edit</a>
    <a class="dropdown-item" data-toggle="tooltip" href="{{ url('admin/invoice/agriculture/' . $balam->id) }}" target="_blank"><i class="fas fa-print"></i> Print</a>
    <a class="dropdown-item" data-method="delete" data-toggle="tooltip" href="{{ route('admin.agri-license-fees.destroy', $balam->id) }}"><i class="fas fa-trash"></i> Delete</a>
  </div>
</div>