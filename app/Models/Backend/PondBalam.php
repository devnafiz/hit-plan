<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PondBalam extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'pond_balam';
    protected $guarded = [];

    public function pondOwner()
    {
        return $this->belongsTo(PondOwner::class);
    }

    public function pondLicense()
    {
        return $this->belongsTo(PondLicense::class, 'license_no', 'generated_id');
    }

    public function dd()
    {
        return $this->hasMany(PondDDInfo::class, 'balam_pond_id');
    }
}
