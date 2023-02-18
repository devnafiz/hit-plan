<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArgiLicenseFee extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'agri_license_fees';
    protected $guarded = [];
}
