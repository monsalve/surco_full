<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = 'modulos';

    protected $fillable = [
        'id_curso'
        , 'contenido'
        , 'modulo'
    ];
}
