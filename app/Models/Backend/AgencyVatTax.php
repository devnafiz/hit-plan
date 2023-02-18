<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyVatTax extends Model
{
  use HasFactory;
  public $timestamps = false;
  protected $table = 'agency_vat_taxes';
  protected $guarded = [];
}
