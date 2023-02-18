<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommercialLicenseOwner extends Model
{
    use HasFactory;
    protected $table = 'commercial_license_owner';
    protected $guarded = [];

    public function record()
    {
        return $this->belongsTo(Record::class, 'record_id', 'id');
    }

    public function mouja()
    {
        return $this->belongsTo(Mouja::class, 'mouja_id', 'mouja_id');
    }

    public function owner()
    {
        return $this->belongsTo(CommercialOwner::class, 'owner_id', 'id');
    }
}
