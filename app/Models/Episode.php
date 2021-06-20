<?php

namespace App\Models;

use Jenssegers\Model\Model;

class Episode extends Model {

    protected $fillable = ['id', 'name', 'air_date', 'episode', 'characters', 'url', 'created'];

}
