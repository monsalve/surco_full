<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = 'preguntas';

    protected $fillable = [
        'id_evaluacion'
        , 'tipo'
        , 'pregunta'
        , 'a', 'b', 'c', 'd', 'e', 'f'
        , 'respuesta'
    ];
}
