<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyBalam extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'agency_balam';
    protected $guarded = [];

    public function agencyOwner()
    {
        return $this->belongsTo(AgencyOwner::class, 'owner_id', 'id');
    }

    public function agencyLicense()
    {
        return $this->belongsTo(AgencyLicense::class, 'license_no', 'generated_id');
    }

    public function dd()
    {
        return $this->hasMany(AgencyDDInfo::class, 'balam_agency_id', 'id');
    }
}
