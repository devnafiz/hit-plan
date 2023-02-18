<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPlanMouja extends Model
{
    use HasFactory;
    protected $table = 'masterplan_moujas';
    protected $guarded = [];

    public function masterPlan()
    {
        return $this->belongsTo(MasterPlan::class, 'masterplan_id', 'id');
    }

    public function mouja()
    {
        return $this->belongsTo(Mouja::class, 'id', 'mouja_id');
    }

    public function ledger()
    {
        return $this->belongsTo(ledger::class, 'ledger_id', 'id');
    }

    public function record()
    {
        return $this->belongsTo(Record::class, 'record_name', 'id');
    }
}
