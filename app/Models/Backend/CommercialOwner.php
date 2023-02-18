<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommercialOwner extends Model
{
    use HasFactory;
    protected $table = 'commercial_owners';
    protected $guarded = [];

    public function commercialLicense()
    {
        return $this->belongsToMany(CommercialLicense::class, 'commercial_license_owner', 'owner_id', 'license_id');
    }
}
