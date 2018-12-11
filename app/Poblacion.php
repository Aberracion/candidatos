<?php

namespace Candidatos;

use Illuminate\Database\Eloquent\Model;

class Poblacion extends Model
{
    protected $fillable = ['provincia', 'poblacion','latitud', 'longitud'];
}
