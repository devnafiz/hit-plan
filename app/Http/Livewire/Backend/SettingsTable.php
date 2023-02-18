<?php

namespace App\Http\Livewire\Backend;

use App\Models\Backend\Setting;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

/**
 * Class RolesTable.
 */
class SettingsTable extends DataTableComponent
{
  protected string $tableName = 'Member';

  /**
   * @return Builder
   */
  public function query(): Builder
  {
    return Setting::with('user');
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
      Column::make(__('Option name'), 'key')
        ->addClass('text-left')
        ->searchable(),
      Column::make(__('Option details'), 'value')
        ->addClass('text-center')
        ->searchable(),

      Column::make('Actions')
        ->addClass('text-center')
        ->format(function ($value, $column, $row) {
          return view('backend.content.settings.includes.actions')->with(['setting' => $row]);
        }),
    ];
  }

  public function setTableDataClass($attribute, $value): ?string
  {
    $array = ['user:email', 'user:name'];
    if (in_array($attribute->column, $array)) {
      return 'text-left';
    }
    return 'text-center';
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
