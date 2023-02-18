<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plot extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "plots";

    public function landType()
    {
        return $this->belongsTo(LandType::class, 'land_type', 'land_type_id');
    }
}
