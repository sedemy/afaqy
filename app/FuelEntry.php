<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuelEntry extends Model
{
    protected $table = "fuel_entries";
    


    public function vehicle(){
        return $this->belongsTo('App\Vehicle','vehicle_id','id')->select('id','name','plate_number');
    }
}
