<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyMouja extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    public $table = "agency_moujas";

    public function record()
    {
        return $this->belongsTo(Record::class, 'record_id', 'id');
    }

    public function mouja()
    {
        return $this->belongsTo(Mouja::class, 'mouja_id', 'mouja_id');
    }

    

    public function agencyLicense()
    {
        return $this->belongsToMany(AgencyLicense::class, 'agency_license_owner', 'owner_id', 'license_id');
    }


}
