<?php

namespace App\Models\Backend;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tender extends Model
{
  use HasFactory;

  protected $table = 'tenders';
  public $timestamps = true;
  protected $guarded = [];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function divisionDetails()
  {
    return $this->belongsTo(Division::class, 'division_id', 'division_id');
  }

  public function districtDetails()
  {
    return $this->belongsTo(District::class, 'district_id', 'district_id');
  }

  public function kachariDetails()
  {
    return $this->belongsTo(Kachari::class, 'kachari_id', 'kachari_id');
  }

  public function upazilaDetails()
  {
    return $this->belongsTo(Upazila::class, 'upazila_id', 'upazila_id');
  }

  public function moujaDetails()
  {
    return $this->belongsTo(Mouja::class, 'mouja_id', 'mouja_id');
  }

  public function plotsDetails()
  {
    return $this->hasMany(Plot::class);
  }

  public function stationDetails()
  {
    return $this->belongsTo(Station::class, 'station_id', 'station_id');
  }

  public function masterplanDetails()
  {
    return $this->belongsTo(MasterPlan::class, 'masterplan_id', 'id');
  }

  public function tenderPlotDetails()
  {
    return $this->hasMany(TenderPlot::class);
  }

  public function tenderPublishedDate()
  {
    return $this->hasMany(TenderPublish::class);
  }
}
