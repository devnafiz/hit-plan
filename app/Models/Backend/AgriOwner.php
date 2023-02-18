<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PharIo\Manifest\License;

class AgriOwner extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    public $table = 'agri_owners';

    public function agriLicense()
    {
        return $this->belongsToMany(AgricultureLicense::class, 'agri_license_owner', 'owner_id', 'license_id');
    }
}
