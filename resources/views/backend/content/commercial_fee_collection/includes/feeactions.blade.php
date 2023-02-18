<div class="btn-group btn-group-sm">
    <a href="{{ route('admin.commercial-fees.show', $commercial_license_fee_collection) }}" class="btn btn-light m-1" data-toggle="tooltip" title="View">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('admin.commercial-fees.edit', $commercial_license_fee_collection) }}" class="btn btn-light m-1" data-toggle="tooltip" title="Edit">
        <i class="ti-pencil-alt"></i>
    </a>
    <a href="{{ route('admin.commercial-fees.destroy', $commercial_license_fee_collection) }}" class="btn btn-light m-1" title="Delete" data-method="delete">
        <i class="fas fa-trash"></i>
    </a>
</div>