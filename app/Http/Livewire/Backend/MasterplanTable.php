<?php

namespace App\Http\Livewire\Backend;

use App\Models\Backend\MasterPlan;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

/**
 * Class RolesTable.
 */
class MasterplanTable extends DataTableComponent
{

  public array $perPageAccepted = [10, 20, 50, 100];
  public bool $perPageAll = false;

  public string $defaultSortColumn = 'id';
  public string $defaultSortDirection = 'desc';

  protected string $pageName = 'masterplans';
  protected string $tableName = 'masterplans';


  /**
   * @return Builder
   */
  public function query(): Builder
  {
    return MasterPlan::with('division', 'district', 'kachari', 'station', 'upazila');
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
          return '<a href="' . route('admin.masterplan.show', $row) . '">' . $value . '</a>';
        })
        ->asHtml(),
      Column::make(__('মাস্টারপ্লান এর নাম '), 'masterplan_name')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('অনুমোদন এর তারিখ'), 'approval_date')
        ->addClass('text-left')
        ->searchable()
        ->format(function ($value, $row) {
          $date = date('F j, Y', strtotime($value));
          return  $date;
        }),
      Column::make(__('বিভাগ'), 'division.division_name')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('জেলা'), 'district.district_name')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('উপজেলা'), 'upazila.upazila_name')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('কাচারী'), 'kachari.kachari_name')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('স্টেশন'), 'station.station_name')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('মাস্টারপ্লান কপি'), 'masterplan_doc')
        ->addClass('text-left')
        ->searchable()
        ->format(function ($value, $row) {
          if ($value) {
            return '<a href="' . asset('uploads/masterplan/' . $value) . '" download>Download</icon></a>';
          }
          return '<h6><span class="badge badge-danger">no file</span></h6>';
        })
        ->asHtml(),
      Column::make('প্রক্রিয়া')
        ->addClass('text-left')
        ->format(function ($value, $column, $row) {
          return view('backend.content.masterplan.includes.actions')->with(['masterplan' => $row]);
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
