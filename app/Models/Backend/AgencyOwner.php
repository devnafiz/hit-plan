<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PharIo\Manifest\License;

class AgencyOwner extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    public $table = 'agency_owners';

    public function agencyLicense()
    {
        return $this->belongsToMany(AgencyLicense::class, 'agency_license_owner', 'owner_id', 'license_id');
    }
}
