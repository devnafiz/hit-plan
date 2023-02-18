<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommercialMouja extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    public $table = "commercial_moujas";

    public function record()
    {
        return $this->belongsTo(Record::class, 'record_id', 'id');
    }

    public function masterPlan()
    {
        return $this->belongsTo(MasterPlan::class, 'masterplan_id', 'id');
    }
}
