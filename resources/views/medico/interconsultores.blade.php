
@extends('plantillas/plantilla_medico')

@section('title_header','Interconsultores')

@section('contenedor')

@include('modal.snackbar')

<div class="row">
	 <form class="card background_panel">
	 	 <div class="row margin_left_5px">
	 	 	<h4 class="letrasblancas"><b>Nuevo</b></h4> 
	 	 </div>
		 <div class="row margin_left_5px">                    
			  
			<div class="row">			  
				  <div class="margin_left_20px">
					  <small>Nombre</small>      
					  <input type="text" class="form-control input_width_250px" id="interconsultores_nombre" name="interconsultores_nombre"  placeholder="Nombre" value=""  />
				  </div>

				  <div class="margin_left_20px">
					  <small>Apellido</small>      
					  <input type="text" class="form-control input_width_250px" id="interconsultores_apellido" name="interconsultores_apellido"  placeholder="Apellido"  />
				  </div>

				  <div class="margin_left_20px">
				  	  <small>Especialidad</small>      
					  <input type="text" class="form-control input_width_350px" id="interconsultores_especialidad" name="interconsultores_especialidad"  placeholder="Especialidad"  />
				 </div>

			</div>

			<div class="row">
				 <div class="margin_left_20px">
				  	  <small>Direccion</small>      
					  <input type="text" class="form-control input_width_350px" id="interconsultores_direccion" name="interconsultores_direccion"  placeholder="Direccion"  />
				 </div>

				 <div class="margin_left_20px">
				  	  <small>TEL (Consultorio)</small>      
					  <input type="text" class="form-control input_width_150px" id="interconsultores_telefono_c" name="interconsultores_telefono_c"  placeholder="Tel Consultorio"  />
				 </div>

				 <div class="margin_left_20px">
				  	  <small>TEL (Particular)</small>      
					  <input type="text" class="form-control input_width_150px" id="interconsultores_telefono_p" name="interconsultores_telefono_p"  placeholder="Tel Particular"  />
				 </div>

			</div>
			<br>
	
		</div>
		<br>
		<div class="row contenedor3">
	   	<button type="button" onclick="guardarDatosInterconsultores()" class="rodri_button_aceptar contenido3">GUARDAR</button>
	</div>
	</form>
	
</div><br><br>
<div class="row">	

<input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}"/> 

  <div class="table-responsive" style="height:700px; overflow-y: scroll;">
  <table class="table table-striped" id="laravel_datatable"> 
               <thead class="fondoNav text-white">
                  <tr>
                    <th class="editText letra_size_1rem">Apellido</th>
                    <th class="editText letra_size_1rem">Nombre</th>
                    <th class="editText letra_size_1rem">Especialidad</th>
                    <th class="editText letra_size_1rem">Direccion</th>                      
                    <th class="editText letra_size_1rem">Tel Consultorio</th>
                    <th class="editText letra_size_1rem">Tel Particular</th>                                                       
                  </tr>
               </thead>
            </table>
         </div>

  </div>

   <script>
   
   $(document).ready( function () {
    $('#laravel_datatable').DataTable({
           language: {
              "decimal": "",
              "emptyTable": "No hay información",
              "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
              "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
              "infoFiltered": "(Filtrado de _MAX_ total entradas)",
              "infoPostFix": "",
              "thousands": ",",
              "lengthMenu": "Mostrar _MENU_ Entradas",
              "loadingRecords": "Cargando...",
              "processing": "Procesando...",
              "search": "Buscar:",
              "zeroRecords": "Sin resultados encontrados",
              "paginate": {
                  "first": "Primero",
                  "last": "Ultimo",
                  "next": "Siguiente",
                  "previous": "Anterior"
              },
           },
           processing: false,
           serverSide: false,           
           ajax: "{{ url('interconsultores_listado_buscar') }}",
           columns: [
                    { data: 'apellido', name: 'apellido', class:'letra_size_1rem' },
                    { data: 'nombre', name: 'nombre' , class:'letra_size_1rem'},
                    { data: 'especialidad', name: 'especialidad' , class:'letra_size_1rem'},
                    { data: 'direccion', name: 'direccion' , class:'letra_size_1rem'},                    
                    { data: 'telefono_consultorio', name: 'telefono_consultorio' , class:'letra_size_1rem'},
                    { data: 'telefono_particular', name: 'telefono_particular' , class:'letra_size_1rem'},
                 ]
        });
     });
    
    function optionModal(dni){     
      var user_id = document.getElementById("user_id").value; 

      $.ajax({
        type:'POST',
        dataType:'JSON',
        url:'/consultar_paciente',
        data:{dni_paciente :dni, user_id:user_id, _token: '{{csrf_token()}}'},
        success:function(data){      
          var paciente = data.paciente.apellido+", "+data.paciente.nombre;
          $('#pacienteSeleccionado').val(paciente);  
          $('#dniPacienteSeleccionado').val(data.paciente.dni);
          $('#pacienteAct').val(data.paciente.dni);
          $('#pacienteActId').val(data.paciente.id);
          $('#pacienteAsg').val(data.paciente.dni);
          $('#pacienteAsgId').val(data.paciente.id);          
          $('#optionsModal').modal();  
        }
      });
    }

  </script>


<script type="text/javascript">
	
	function guardarDatosInterconsultores() {
	var nombre = document.getElementById("interconsultores_nombre").value;
	var apellido = document.getElementById("interconsultores_apellido").value;
	var especialidad = document.getElementById("interconsultores_especialidad").value;
	var direccion = document.getElementById("interconsultores_direccion").value;
	var telefono_p = document.getElementById("interconsultores_telefono_p").value;
	var telefono_c = document.getElementById("interconsultores_telefono_c").value;
	$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_interconsultores',
           data:{nombre:nombre, apellido:apellido, especialidad:especialidad, direccion:direccion, telefono_p:telefono_p, telefono_c:telefono_c,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){           			
           			mostrarSnackbar("GUARDADO");            		
            	} else {
            		mostrarSnackbar("PANTALLAS FALLO");            		
            	}
            }
        });		
	}

</script>

@endsection