<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenseIds extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $guarded = [];
    protected $table = 'license_ids';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
