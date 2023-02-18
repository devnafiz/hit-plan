<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgriBalam extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'agri_balam';
    protected $guarded = [];

    public function agriOwner()
    {
        return $this->belongsTo(AgriOwner::class);
    }

    public function agriLicense()
    {
        return $this->belongsTo(AgricultureLicense::class, 'license_no', 'generated_id');
    }

    public function dd()
    {
        return $this->hasMany(AgriDDInfo::class, 'balam_agriculture_id', 'id');
    }
}
