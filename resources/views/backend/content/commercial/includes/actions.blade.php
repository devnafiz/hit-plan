<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-cog nav-icon"></i>
    </button>
    <div class="dropdown-menu" role="menu" style="">
        <a class="dropdown-item btnProcess" href="{{ route('admin.commercial.show', $serValue) }}"><i class="fas fa-eye"></i> View</a>
        <a class="dropdown-item btnProcess" href="{{ route('admin.commercial.edit', $serValue) }}"><i class="ti-pencil-alt"></i> Edit</a>
        <a class="dropdown-item" data-method="delete" data-toggle="tooltip" href="{{ route('admin.commercial.destroy', $serValue) }}"><i class="fas fa-trash"></i> Delete</a>
    </div>
</div>