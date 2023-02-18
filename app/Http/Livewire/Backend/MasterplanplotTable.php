<?php

namespace App\Http\Livewire\Backend;

use App\Models\Backend\MasterPlan;
use App\Models\Backend\MasterPlanPlot;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

/**
 * Class RolesTable.
 */
class MasterplanplotTable extends DataTableComponent
{

  public array $perPageAccepted = [10, 20, 50, 100];
  public bool $perPageAll = false;

  public string $defaultSortColumn = 'id';
  public string $defaultSortDirection = 'desc';

  protected string $pageName = 'masterplan';
  protected string $tableName = 'masterplan';


  /**
   * @return Builder
   */
  public function query(): Builder
  {
    return MasterPlan::with('masterPlanPlot');
  }

  /**
   * @return array
   */
  public function columns(): array
  {
    $this->index = $this->page > 1 ? ($this->page - 1) * $this->perPage : 0;
    return [
      Column::make(__('NO.'), 'no')
        ->addClass('text-left')
        ->format(function () {
          return ++$this->index;
        }),
      Column::make(__('মাস্টারপ্লান নং'), 'masterplan_no')
        ->addClass('text-left')
        ->searchable()
        ->format(function ($value, $column, $row) {
          return '<a href="' . route('admin.masterplan-plot.show', $row ? $row : "#") . '">' . $value . '</a>';
        })
        ->asHtml(),
      Column::make(__('মাস্টারপ্লান নাম'), 'masterplan_name')
        ->addClass('text-left')
        ->searchable()
        ->format(function ($value, $row) {
          return $value;
        })
        ->asHtml(),
      Column::make(__('প্লট সংখ্যা'), 'masterPlanPlot')
        ->addClass('text-left')
        ->format(function ($value, $column, $row) {
          return count($value) == 0 ? '<span class="badge badge-danger">N/A</span>' : count($value);
        })
        ->asHtml(),
      Column::make('প্রক্রিয়া')
        ->addClass('text-left')
        ->format(function ($value, $column, $row) {
          return view('backend.content.masterplan_plot.includes.actions')->with(['masterplan_plot' => $row]);
        }),
    ];
  }

  public function setTableRowClass($value)
  {
    return $value->id;
  }

  public function setTableRowId($value)
  {
    return $value->id;
  }
}
