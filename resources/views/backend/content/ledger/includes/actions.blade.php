<div class="btn-group btn-group-sm">
    <a href="{{ route('admin.ledger.show', $ledger) }}" class="btn btn-light" data-toggle="tooltip" title="View">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('admin.ledger.edit', $ledger) }}" class="btn btn-light" data-toggle="tooltip" title="Edit">
        <i class="ti-pencil-alt"></i>
    </a>
    <a href="{{ route('admin.ledger.destroy', $ledger) }}" class="btn btn-light" data-method="delete"
        data-toggle="tooltip" title="Delete">
        <i class="fas fa-trash"></i>
    </a>
</div>
