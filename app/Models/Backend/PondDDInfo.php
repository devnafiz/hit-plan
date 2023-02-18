<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PondDDInfo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    public $table = "pond_dd_infos";

    public function balam_agri()
    {
        return $this->belongsTo(BalamAgriculture::class, 'id');
    }
}
