<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{

   protected $fillable = [
    'email','deviceName	','description','seen',

];
}
