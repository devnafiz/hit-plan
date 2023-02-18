<div class="btn-group btn-group-sm">
    <a href="{{ route('admin.inventory.show', $inventory) }}" class="btn btn-light m-1" data-toggle="tooltip" title="View">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('admin.inventory.edit', $inventory) }}" class="btn btn-light m-1" data-toggle="tooltip" title="Edit">
        <i class="ti-pencil-alt"></i>
    </a>
    <a href="{{ route('admin.inventory.destroy', $inventory) }}" class="btn btn-light m-1" title="Delete" onclick="return confirm('Are you sure you want to delete this?')">
        <i class="fas fa-trash"></i>
    </a>
</div>