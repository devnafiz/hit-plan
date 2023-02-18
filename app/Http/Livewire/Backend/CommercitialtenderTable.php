<?php

namespace App\Http\Livewire\Backend;

use App\Models\Backend\AgricultureLicense;
use App\Models\Backend\CommercialLicense;
use App\Models\Backend\District;
use App\Models\Backend\Tender;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

/**
 * Class RolesTable.
 */
class CommercitialtenderTable extends DataTableComponent
{

  public array $perPageAccepted = [10, 20, 50, 100];
  public bool $perPageAll = false;

  public string $defaultSortColumn = 'id';
  public string $defaultSortDirection = 'desc';

  protected string $pageName = 'CommercitialtenderTable';
  protected string $tableName = 'CommercitialtenderTable';


  /**
   * @return Builder
   */
  public function query(): Builder
  {
    return Tender::with('divisionDetails', 'districtDetails', 'kachariDetails', 'stationDetails', 'upazilaDetails', 'tenderPublishedDate')->where('tender_type', 'commercial');
  }

  /**
   * @return array
   */

  public function columns(): array
  {
    return [
      Column::make(__('NO.'), 'id')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('দরপত্র নং'), 'tender_no')
        ->addClass('text-left')
        ->searchable()
        ->format(function ($value, $column, $row) {
          return '<a href="' . route('admin.commercial-tender.show', $row ? $row : "") . '">' . $value . '</a>';
        })
        ->asHtml(),
      Column::make(__('ডিমান্ড নোটিশ নং'), 'tenderPublishedDate.tender_online_rcv_date')
        ->addClass('text-left')
        ->searchable()
        ->format(function ($value, $row) {
          $date = date('F j, Y', strtotime($value));
          return  $date;
        }),
      Column::make(__('বিভাগ'), 'divisionDetails.division_name')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('জেলা'), 'districtDetails.district_name')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('উপজেলা'), 'upazilaDetails.upazila_name')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('কাচারী'), 'kachariDetails.kachari_name')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('স্টেশন'), 'stationDetails.station_name')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('অবস্থা'), 'status')
        ->addClass('text-left')
        ->searchable()
        ->format(function ($value, $row) {
          if ($value == 'pending') {
            return '<span class="badge badge-warning">Pending</span>';
          } elseif ($value == 'running') {
            return '<span class="badge badge-primary">Running</span>';
          } elseif ($value == 'expired') {
            return '<span class="badge badge-danger">Running</span>';
          } else {
            return '<span class="badge badge-light">Inactive</span>';
          }
        })
        ->asHtml(),
      Column::make('প্রক্রিয়া')
        ->addClass('text-left')
        ->format(function ($value, $column, $row) {
          return view('backend.content.commercial_tender.includes.actions')->with(['commerciallicense' => $row]);
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
