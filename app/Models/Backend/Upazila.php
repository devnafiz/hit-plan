<?php

namespace App\Models\Backend;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Upazila extends Model
{
  use HasFactory;
  

  protected $table = 'upazilas';
  public $timestamps = false;
  protected $guarded = [];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function district()
  {
    return $this->belongsTo(District::class, 'district_id', 'district_id');
  }
  public function division()
  {
      return $this->belongsTo(Division::class, 'division_id', 'division_id');
  }

  

  public function kachari()
  {
      return $this->belongsTo(Kachari::class, 'kachari_id', 'kachari_id');
  }

  public function upazila()
  {
      return $this->belongsTo(Upazila::class, 'upazila_id', 'upazila_id');
  }
}
