<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mouja extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function ledger()
    {
        return $this->belongsTo(ledger::class, 'mouja_id', 'mouja_id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'division_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }

    public function kachari()
    {
        return $this->belongsTo(Kachari::class, 'kachari_id', 'kachari_id');
    }

    public function upazila()
    {
        return $this->belongsTo(Upazila::class, 'upazila_id', 'upazila_id');
    }

    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id', 'station_id');
    }

}
