<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{

   // public $timestamps = true;
   // define camps collection fields
   protected $fillable = [
    'email','deviceName	','minTemperature','maxTemperature',
    'minMoisture','maxMoisture','minLight','maxLight','minFertility','maxFertility',

];
}
