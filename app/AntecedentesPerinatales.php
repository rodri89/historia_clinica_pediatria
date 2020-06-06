<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AntecedentesPerinatales extends Model
{
    protected $fillable = ['consulta_id','paciente_id','embarazo','embarazo_controles','patologias','patologias_detalle','parto','parto_detalle','eg','peso','talla','pc','apgar','caida_cordon','meconio','gyf','fei','fei_anormal_detalle','oea','activo'];
}
