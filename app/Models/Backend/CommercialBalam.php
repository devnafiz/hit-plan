<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommercialBalam extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'commercial_balam';
    protected $guarded = [];

    public function commercialOwner()
    {
        return $this->belongsTo(CommercialOwner::class, 'owner_id', 'id');
    }

    public function commercialLicense()
    {
        return $this->belongsTo(CommercialLicense::class, 'license_no', 'generated_id');
    }

    public function dd()
    {
        return $this->hasMany(CommercialDdInfo::class, 'balam_commercial_id', 'id');
    }
}
