<?php

namespace App\Models;

use Jenssegers\Model\Model;

class Character extends Model {

    protected $fillable = ['id', 'name', 'status', 'species', 'type', 'gender', 'origin', 'location', 'image', 'episode', 'url', 'created'];

}
