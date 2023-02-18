<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PondVatTax extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "pond_vat_taxes";
    protected $guarded = [];
}
