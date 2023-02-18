<?php

namespace App\Models\Backend;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
  use HasFactory, SoftDeletes;

  protected $table = 'settings';

  public $primaryKey = 'id';

  public $timestamps = true;

  protected $guarded = [];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public static function active_setting($active_key)
  {
    Setting::whereKey($active_key)->update([
      'active' => now(),
      'user_id' => auth()->id(),
    ]);
  }

  public static function save_settings(array $arras)
  {
    foreach ($arras as $key => $value) {
      Setting::updateOrCreate(
        ['key' => $key],
        [
          'value' => $value,
          'user_id' => auth()->id(),
        ]
      );
    }
  }
}
