<?php

namespace App\Http\Livewire\Backend;

use App\Models\Backend\District;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

/**
 * Class RolesTable.
 */
class DistrictTable extends DataTableComponent
{
  public array $sortNames = [
    'email_verified_at' => 'Verified',
    'two_factor_secret' => '2FA',
  ];

  public array $perPageAccepted = [10, 20, 50, 100];
  public bool $perPageAll = false;

  public string $defaultSortColumn = 'district_id';
  public string $defaultSortDirection = 'desc';

  protected string $pageName = 'District';
  protected string $tableName = 'District';



  public function exportSelected()
  {
    // if ($this->selectedRowsQuery->count() > 0) {
    //   return (new CategoryExport($this->selectedRowsQuery))->download($this->tableName . '.xlsx');
    // }
    //   // Not included in package, just an example.
    // $this->notify(__('You did not select any users to export.'), 'danger');
  }

  /**
   * @return Builder
   */
  public function query(): Builder
  {
    return District::with('user');
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

      Column::make(__('District Name (Bangla)'), 'district_name')
        ->searchable(),
        Column::make(__('বিভাগ'), 'division.division_name')
        ->addClass('text-left')
        ->searchable(),
        Column::make(__('কাচারী'), 'kachari.kachari_name')
        ->addClass('text-left')
        ->searchable(),
      Column::make('Actions')
        ->addClass('text-left')
        ->format(function ($value, $column, $row) {
          return view('backend.content.district.includes.actions')->with(['district' => $row->district_id]);
        }),
    ];
  }

  // public function setTableDataClass($attribute, $value): ?string
  // {
  //   $array = ['user:email', 'user:name'];
  //   if (in_array($attribute->column, $array)) {
  //     return 'text-left';
  //   }
  //   return 'text-center';
  // }


  // public function setTableRowClass($value)
  // {
  //   return $value->id;
  // }

  public function setTableRowId($value)
  {
    return $value->id;
  }
}
