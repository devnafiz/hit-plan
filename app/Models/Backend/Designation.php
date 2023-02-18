<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     * 
     */
    protected $table = 'designation';
    protected $fillable = [
        
        'name',
        'details',
        'status',
    ];
}
