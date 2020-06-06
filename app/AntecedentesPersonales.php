<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AntecedentesPersonales extends Model
{
     protected $fillable = ['consulta_id', 'paciente_id', 'enfermedad_actual','internaciones','internacion_motivo','internacion_lugar', 'internacion_duracion', 'internacion_indicacion_alta', 'alergias', 'alergia_detalle', 'qx', 'qx_detalle', 'traumatismos', 'traumatismos_detalle', 'transfusiones', 'transfusiones_detalle','activo'];
}
