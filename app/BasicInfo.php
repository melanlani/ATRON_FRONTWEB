<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class BasicInfo extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'basic_info';

}
