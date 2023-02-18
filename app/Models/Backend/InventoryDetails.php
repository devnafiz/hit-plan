<?php

namespace App\Models\Backend;

use App\Models\Backend\plot as BackendPlot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class InventoryDetails extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'inventory';

    public function inventoryTypeDetails()
    {
        return $this->belongsTo(InventoryType::class, 'file_type', 'file_id');
    }
}
