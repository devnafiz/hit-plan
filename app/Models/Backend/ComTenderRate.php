<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComTenderRate extends Model
{
  use HasFactory;

  public $timestamps = true;
  protected $guarded = [];
  protected $table = 'com_rates';

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function station()
  {
    return $this->belongsTo(Station::class, 'station_id', 'station_id');
  }
}
