<?php

namespace App\Http\Livewire\Backend;

use App\Models\Backend\AgricultureLicense;
use App\Models\Backend\AgriBalam;
use App\Models\Backend\District;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

/**
 * Class RolesTable.
 */
class AgrfeescollectionTable extends DataTableComponent
{

  public array $perPageAccepted = [10, 20, 50, 100];
  public bool $perPageAll = false;

  public string $defaultSortColumn = 'id';
  public string $defaultSortDirection = 'desc';

  protected string $pageName = 'balam_agricultures';
  protected string $tableName = 'balam_agricultures';


  /**
   * @return Builder
   */
  public function query(): Builder
  {
    return AgriBalam::with('agriOwner');
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
      Column::make(__('লাইসেন্স নং'), 'license_no')
        ->addClass('text-left')
        ->searchable()
        ->format(function ($value, $column, $row) {
          return '<h5 style="margin:0;">' . $value . '</h5><small>ধরন: ' . $row->license_type . ' | সময়কাল: ' . $row->license_date . '</small>';
        })
        ->asHtml(),
      Column::make(__('লাইসেন্সের তথ্য'), 'agriOwner')
        ->addClass('text-left')
        ->searchable()
        ->format(function ($value, $column, $row) {
          return '<p><label>নাম: ' . $value ?? $value->name . '</label>
                    <br><small>মোবাইল: ' . $value ?? $value->phone . '</small>
                    <br><small>ঠিকানা: ' . $value ?? $value->address . '</small></p>';
        })
        ->asHtml(),
      Column::make(__('লাইসেন্স ফি/ভ্যাট/ট্যাক্স'))
        ->addClass('text-left')
        ->searchable()
        ->format(function ($value, $column, $row) {
          return '<p><label>লাইসেন্স ফি: ' . $row->license_fee . '</label>
                    <br><span>ভ্যাট: ' . $row->vat . '</span>
                    <br><span>ট্যাক্স: ' . $row->tax . '</span>
                </p>';
        })
        ->asHtml(),
      Column::make(__('লাইসেন্স মোট ফি'), 'total_fee')
        ->addClass('text-left')
        ->searchable()
        ->format(function ($value, $row) {
          return '<h5>' . $value . '</h5>';
        })
        ->asHtml(),

      Column::make('প্রক্রিয়া')
        ->addClass('text-left')
        ->format(function ($value, $column, $row) {
          return view('backend.content.agriculture.includes.feeactions')->with(['agriculture_license_fee_collection' => $row]);
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
