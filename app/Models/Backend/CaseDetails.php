<?php

namespace App\Models\Backend;

use App\Models\Backend\plot as BackendPlot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class CaseDetails extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'cases';

    public function divisionDetails()
    {
        return $this->belongsTo(Division::class, 'division', 'division_id');
    }

    public function districtDetails()
    {
        return $this->belongsTo(District::class, 'district', 'district_id');
    }

    public function kachariDetails()
    {
        return $this->belongsTo(Kachari::class, 'kachari', 'kachari_id');
    }

    public function upazilaDetails()
    {
        return $this->belongsTo(Upazila::class, 'upazila', 'upazila_id');
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
        return $this->belongsTo(Station::class, 'station', 'station_id');
    }

    public function sectionDetails()
    {
        return $this->belongsTo(Section::class, 'section', 'section_id');
    }
}
