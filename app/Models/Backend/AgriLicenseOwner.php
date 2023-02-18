<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgriLicenseOwner extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    public $table = "agri_license_owner";

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
        return $this->belongsTo(AgriOwner::class, 'owner_id', 'id');
    }
}
