<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseDate extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    public $table = "case_date";

    
}
