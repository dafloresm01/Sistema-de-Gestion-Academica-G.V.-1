<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesempenoEstudiante extends Model
{
    protected $fillable = [
        "inscripcion_id",
        "materia_id",
        "estudiante_id",
        "desempeno",
        "valoracion",
        "fecha",
        "observacion",
        "user_id",
        "materia_profesor",
        "fecha_registro",
    ];

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class, 'incripcion_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function desempeno_notificacions()
    {
        return $this->hasMany(DesempenoNotificacion::class, 'desempeno_id');
    }

    public function chat_desempenos()
    {
        return $this->hasMany(ChatDesempeno::class, 'desempeno_id');
    }
}
