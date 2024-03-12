<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatDesempeno extends Model
{
    protected $fillable = [
        "desempeno_id",
        "emisor_id",
        "receptor_id",
        "mensaje",
        "visto",
    ];

    public function desempeno()
    {
        return $this->belongsTo(DesempenoEstudiante::class, 'desempeno_id');
    }
    public function emisor()
    {
        return $this->belongsTo(User::class, 'emisor_id');
    }
    public function receptor()
    {
        return $this->belongsTo(User::class, 'receptor_id');
    }
}
