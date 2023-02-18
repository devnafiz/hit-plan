<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyDDInfo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    public $table = "agency_dd_infos";
}
