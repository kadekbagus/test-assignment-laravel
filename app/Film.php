<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    // table name
    protected $table = 'films';
    protected $primaryKey = 'film_id';
}