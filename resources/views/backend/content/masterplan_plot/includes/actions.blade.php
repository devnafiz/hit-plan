<div class="btn-group btn-group-sm">
    <!-- <a href="{{ route('admin.masterplan-plot.show', $masterplan_plot) }}" class="btn btn-light m-1"
        data-toggle="tooltip" title="View">
        <i class="fas fa-eye"></i>
    </a> -->
    <a href="{{ route('admin.masterplan-plot.edit', $masterplan_plot) }}" class="btn btn-light m-1"
        data-toggle="tooltip" title="Edit">
        <i class="ti-pencil-alt"></i>
    </a>
    <a href="{{ route('admin.masterplan-plot.destroy', $masterplan_plot) }}" class="btn btn-light m-1"
        data-method="delete" data-toggle="tooltip" title="Delete">
        <i class="fas fa-trash"></i>
    </a>
</div>
