<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Kachari extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kachari_id',
        'kachari_name',
        'division_id',
    ];
}
