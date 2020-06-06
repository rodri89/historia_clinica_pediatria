
@extends('plantillas/plantilla_medico')

@section('title_header','Listado Pacientes')

@section('contenedor')

<div class="table-responsive" style="height:500px; overflow-y: scroll;">
    <table class="table table-condensed tabla_con_borde" id="tabla_pacientes" name="tabla_pacientes">
     <thead>
        <tr>
          <th class="editText rodri_th letra_size_1rem" scope="col">#</th>
          <th class="editText rodri_th letra_size_1rem" scope="col">Horario</th>
          <th class="editText rodri_th letra_size_1rem" scope="col">Paciente</th>
          <th class="editText rodri_th letra_size_1rem" scope="col">DNI</th> 
          <th class="editText rodri_th letra_size_1rem" scope="col">Telefono</th>                                 
          <th class="editText rodri_th letra_size_1rem" scope="col">Primer Consulta</th>
          <th class="editText rodri_th letra_size_1rem" scope="col">Sobreturno</th>                        
          <th class="editText rodri_th letra_size_1rem" scope="col">Ingresar</th>                     
        </tr>
      </thead>
      <tbody id="pacientes-list" name="pacientes-list">
        <?php $cont = 1 ?>
        @foreach($listadoPacientes as $lp)
        <tr>
          <th scope="row" class="editText letra_size_1rem">{{$cont++}}</th>
          <td class="letra_size_1rem">{{'0'.$cont.':00'}}</td>
          <td class="letra_size_1rem">{{$lp->apellido.', '.$lp->nombre}}</td>          
          <td class="letra_size_1rem">{{$lp->dni}}</td>
          <td class="letra_size_1rem">{{$lp->telefono}}</td>
          <td class="letra_size_1rem">{{'SI'}}</td>
          <td class="letra_size_1rem">{{'NO'}}</td>
          <td>
	          <form method="POST" action="{{ route('nuevaconsulta') }}">
	          	@csrf	          	
	          	<input type="hidden" id="paciente_id" name="paciente_id" value="{{$lp->id}}"/> 
	          	<button type="submit" class="rodri_button_aceptar_si">></button>
	      	  </form>
      	  </td>
      	</tr>
      	@endforeach
    </tbody>
  </table>
  </div>
@endsection