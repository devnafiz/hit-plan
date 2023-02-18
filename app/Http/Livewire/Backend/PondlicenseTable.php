<?php

namespace App\Http\Livewire\Backend;


use App\Models\Backend\PondLicense;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;


/**
 * Class RolesTable.
 */
class PondlicenseTable extends DataTableComponent
{

  public array $perPageAccepted = [10, 20, 50, 100];
  public bool $perPageAll = false;

  public string $defaultSortColumn = 'id';
  public string $defaultSortDirection = 'desc';

  protected string $pageName = 'pond_license';
  protected string $tableName = 'pond_license';


  /**
   * @return Builder
   */
  public function query(): Builder
  {
    return PondLicense::with('division', 'district', 'kachari', 'station', 'upazila');
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
      Column::make(__('লাইসেন্স নং'), 'generated_id')
        ->addClass('text-left')
        ->searchable()
        ->format(function ($value, $row) {
          return '<a href="' . route('admin.pond-license.show', $row ? $row : "#") . '">' . $value . '</a>';
        })
        ->asHtml(),
      Column::make(__('ডিমান্ড নোটিশ নং'), 'demand_notice_number')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('নোটিশের তারিখ'), 'demand_notice_date')
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
      Column::make('প্রক্রিয়া')
        ->addClass('text-left')
        ->format(function ($value, $column, $row) {
          return view('backend.content.pond.includes.actions')->with(['pond_license' => $row]);
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
