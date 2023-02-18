<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PharIo\Manifest\License;

class PondOwner extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    public $table = 'pond_owners';

    public function pondLicense()
    {
        return $this->belongsToMany(PondLicense::class, 'pond_license_owner', 'owner_id', 'license_id');
    }
}
