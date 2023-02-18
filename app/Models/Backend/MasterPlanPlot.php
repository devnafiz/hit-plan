<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPlanPlot extends Model
{
    use HasFactory;
    protected $table = 'masterplan_plot';
    protected $guarded = [];

    public function masterPlan(){
        return $this->belongsTo(MasterPlan::class, 'masterplan_id', 'id');
    }
}
