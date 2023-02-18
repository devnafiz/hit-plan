<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgriMouja extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    public $table = "agri_moujas";

    public function record()
    {
        return $this->belongsTo(Record::class, 'record_id', 'id');
    }

    public function mouja()
    {
        return $this->belongsTo(Mouja::class, 'mouja_id', 'mouja_id');
    }

    public function ledger()
    {
        return $this->belongsTo(ledger::class, 'ledger_id', 'id');
    }
}
