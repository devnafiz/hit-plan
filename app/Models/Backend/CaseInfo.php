<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseInfo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    public $table = "case_infos";


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
        return $this->belongsTo(Mouja::class, 'mouja', 'mouja_id');
    }

    public function plotDetails()
    {
        return $this->hasMany(BackendPlot::class);
    }

    public function plotsDetails()
    {
        return $this->hasMany(BackendPlot::class);
    }
    public function stationDetails()
    {
        return $this->belongsTo(Station::class, 'station_id', 'station_id');
    }

    public function caseDate()
    {
        return $this->hasMany(CaseDate::class,'case_id','id');
    }
    public function disMoujas()
    {
        return $this->hasMany(CaseDistrict::class, 'case_id', 'id');
    }

    
}
