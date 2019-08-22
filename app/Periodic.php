<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Periodic extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'new_periodic_data';
}