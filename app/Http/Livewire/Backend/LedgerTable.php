<?php

namespace App\Http\Livewire\Backend;

use App\Models\Backend\Browsinginformation;
use App\Models\Backend\ledger;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

/**
 * Class RolesTable.
 */
class LedgerTable extends DataTableComponent
{
  /**
   * @return Builder
   */
  protected $index = 0;
  public int $perPage = 20;
  public string $defaultSortColumn = 'id';
  public string $defaultSortDirection = 'desc';

  protected string $pageName = 'ledger';
  protected string $tableName = 'ledger';

  public function query(): Builder
  {
    return ledger::with('district', 'division', 'kachari', 'landType', 'mouja', 'plot', 'record', 'section', 'station', 'upazila');
  }

  /**
   * @return array
   */
  public function columns(): array
  {
    $this->index = ($this->page > 1 ? ($this->page - 1) * $this->perPage : 0);

    return [
      Column::make(__('নং.'), 'no')
        ->addClass('text-left')
        ->format(function () {
          return ++$this->index;
        }),
      Column::make(__('খতিয়ান নম্বর'), 'ledger_number')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('বিভাগ'), 'division.division_name')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('কাচারীর'), 'kachari.kachari_name')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('জেলা'), 'district.district_name')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('উপজেলা'), 'upazila.upazila_name')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('স্টেশন'), 'station.station_name')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('মৌজা'), 'mouja.mouja_name')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('রেকর্ড'), 'record.record_name')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('মোট জমির পরিমাণ'), 'plot')
        ->addClass('text-left')
        ->format(function ($value, $row) {
          return land_amount($value) . " " . "শতক";
        }),
      // Column::make(__('অবস্থা'), 'status')
      //   ->addClass('text-left')
      //   ->searchable()
      //   ->format(function ($value, $row) {
      //     if ($value == 'active') {
      //       return '<span class="badge badge-primary">Active</span>';
      //     }
      //     return '<span class="badge badge-danger">Inactive</span>';
      //   })
      //   ->asHtml(),

      Column::make('প্রক্রিয়া')
        ->addClass('text-center')
        ->format(function ($value, $column, $row) {
          return view('backend.content.ledger.includes.actions')->with(['ledger' => $row]);
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
