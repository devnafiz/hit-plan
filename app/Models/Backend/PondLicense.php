<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PondLicense extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;
    protected $dates = ['deleted_at'];
    protected $fillable = [];
    protected $guarded = [];
    protected $table = 'pond_licenses';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pondOwner()
    {
        return $this->belongsToMany(PondOwner::class, 'pond_license_owner', 'license_id', 'owner_id');
    }

    public function pondMoujas()
    {
        return $this->hasMany(PondMouja::class, 'license_id', 'id');
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

    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id', 'station_id');
    }

    public function upazila()
    {
        return $this->belongsTo(Upazila::class, 'upazila_id', 'upazila_id');
    }

    public function record()
    {
        return $this->belongsTo(Record::class, 'record_id', 'id');
    }

    public function balam()
    {
        return $this->hasMany(PondBalam::class, 'license_no', 'generated_id');
    }
}
