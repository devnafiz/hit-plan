<?php

namespace App\Http\Livewire\Backend;

use App\Models\Backend\AgricultureLicense;
use App\Models\Backend\District;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

/**
 * Class RolesTable.
 */
class AgriculturelicenseTable extends DataTableComponent
{

  public array $perPageAccepted = [10, 20, 50, 100];
  public bool $perPageAll = false;

  public string $defaultSortColumn = 'id';
  public string $defaultSortDirection = 'desc';

  protected string $pageName = 'agriculture_license';
  protected string $tableName = 'agriculture_license';


  /**
   * @return Builder
   */
  public function query(): Builder
  {
    return AgricultureLicense::with('division', 'district', 'kachari', 'station', 'upazila');
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
        ->format(function ($value, $column, $row) {
          return '<a href="' . route('admin.agriculture.show', $row ? $row : "#") . '">' . $value . '</a>';
        })
        ->asHtml(),
      Column::make(__('ডিমান্ড নোটিশ নং'), 'demand_notice_number')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('নোটিশের তারিখ'), 'demand_notice_date')
        ->addClass('text-left')
        ->searchable()
        ->format(function ($value, $column, $row) {
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
      Column::make(__('অনুমোদনের কপি'), 'land_map_certificate')
        ->addClass('text-left')
        ->searchable()
        ->format(function ($value, $column, $row) {
          if ($value) {
            return '<a href="' . asset('uploads/agriculture/' . $value) . '" download>Download</a>';
          }
          return '<h6><span class="badge badge-danger">no file</span></h6>';
        })
        ->asHtml(),
      Column::make('প্রক্রিয়া')
        ->addClass('text-left')
        ->format(function ($value, $column, $row) {
          return view('backend.content.agriculture.includes.actions')->with(['agriculture_license' => $row]);
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
