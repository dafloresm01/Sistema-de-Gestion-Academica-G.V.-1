<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesempenoNotificacion extends Model
{
    protected $fillable = [
        "desempeno_id",
        "fecha",
        "hora",
        "desempeno",
        "valoracion",
        "fecha_registro",
        "user_id",
        "visto"
    ];
}
