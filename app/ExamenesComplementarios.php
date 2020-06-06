<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamenesComplementarios extends Model
{
     protected $fillable = ['paciente_id','consulta_id', 'numero', 'solicito', 'fechaSolicitud', 'respuesta','activo'];
}
           