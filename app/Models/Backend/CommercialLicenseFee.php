<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommercialLicenseFee extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'commercial_license_fees';
    protected $guarded = [];
}
