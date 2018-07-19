<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilmGenre extends Model
{
    // table name
    protected $table = 'film_genres';
    protected $primaryKey = 'film_genre_id';
}