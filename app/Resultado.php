<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    protected $table = 'resultados';

    protected $fillable = [
        'id_alumno'
        , 'id_curso'
        , 'id_evaluacion'
        , 'preguntas'
        , 'respondidas'
        , 'resultado'
        , 'estado_eva'
    ];
}
