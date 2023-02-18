{{-- <div class="btn-group btn-group-sm">
    <a href="{{ route('admin.masterplan.show', $masterplan) }}" class="btn btn-light m-1" data-toggle="tooltip"
title="View">
<i class="fas fa-eye"></i>
</a>
<a href="{{ route('admin.masterplan.edit', $masterplan) }}" class="btn btn-light m-1" data-toggle="tooltip" title="Edit">
    <i class="ti-pencil-alt"></i>
</a>
<a href="{{ route('admin.masterplan.destroy', $masterplan) }}" class="btn btn-light m-1" data-method="delete" data-toggle="tooltip" title="Delete">
    <i class="fas fa-trash"></i>
</a>
</div> --}}


<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-cog nav-icon"></i>
    </button>
    <div class="dropdown-menu" role="menu" style="">
        <a class="dropdown-item btnProcess" href="{{ route('admin.masterplan.show', $masterplan) }}"><i class="fas fa-eye"></i> View</a>
        <a class="dropdown-item btnProcess" href="{{ route('admin.masterplan.edit', $masterplan) }}"><i class="ti-pencil-alt"></i> Edit</a>
        <a class="dropdown-item" data-method="delete" data-toggle="tooltip" href="{{ route('admin.masterplan.destroy', $masterplan) }}"><i class="fas fa-trash"></i> Delete</a>
    </div>
</div>