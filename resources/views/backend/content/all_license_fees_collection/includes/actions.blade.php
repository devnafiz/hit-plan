<div class="btn-group btn-group-sm">
    <a href="{{ route('admin.agriculture.show', $agriculture_license) }}" class="btn btn-light m-1"
        data-toggle="tooltip" title="View">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('admin.agriculture.edit', $agriculture_license) }}" class="btn btn-light m-1"
        data-toggle="tooltip" title="Edit">
        <i class="ti-pencil-alt"></i>
    </a>
    <a href="{{ route('admin.agriculture.destroy', $agriculture_license) }}" class="btn btn-light m-1"
        data-method="delete" data-toggle="tooltip" title="Delete">
        <i class="fas fa-trash"></i>
    </a>
</div>
