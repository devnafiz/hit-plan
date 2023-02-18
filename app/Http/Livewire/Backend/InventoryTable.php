<?php

namespace App\Http\Livewire\Backend;

use App\Models\Backend\InventoryDetails;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

/**
 * Class RolesTable.
 */
class InventoryTable extends DataTableComponent
{

  public array $perPageAccepted = [10, 20, 50, 100];
  public bool $perPageAll = false;

  public string $defaultSortColumn = 'inventory_id';
  public string $defaultSortDirection = 'desc';

  protected string $pageName = 'inventory';
  protected string $tableName = 'inventory';


  /**
   * @return Builder
   */
  public function query(): Builder
  {
    return InventoryDetails::with('inventoryTypeDetails');
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
      Column::make(('ফাইল নং'), 'file_no')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('ফাইলের ধরণ'), 'inventoryTypeDetails.type')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('সেল্ফ'), 'self')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('কলাম'), 'file_column')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('রো'), 'row')
        ->addClass('text-left')
        ->searchable(),
      Column::make('প্রক্রিয়া')
        ->addClass('text-left')
        ->format(function ($value, $column, $row) {
          return view('backend.content.inventory.includes.feeactions')->with(['inventory' => $row->inventory_id]);
        }),
    ];
  }

  public function setTableRowClass($value)
  {
    return $value->inventory_id;
  }

  public function setTableRowId($value)
  {
    return $value->inventory_id;
  }
}
