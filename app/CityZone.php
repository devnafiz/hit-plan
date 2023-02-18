<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityZone extends Model
{
    // Table Name
    protected $table = 'city_zones';

    // Primary Key
    public $primaryKey = 'id';
    
    // Timestamps
    public $timestamps = true;

  
}
