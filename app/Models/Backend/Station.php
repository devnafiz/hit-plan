<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;
    public $timestamps = false;


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
}
