<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommercialVatTax extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'commercial_vat_taxes';
    protected $guarded = [];
}
