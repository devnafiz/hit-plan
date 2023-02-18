<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PondLicenseFee extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'pond_license_fees';
    protected $guarded = [];
}
