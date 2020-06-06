<form class="card background_panel_consulta_actual">	
	<div class="row margin_left_5px">
		<h4><b><a onclick="clickInterconsulta()" type="button">Interconsulta</a></b></h4>
	</div>	
	
	<div id="seccion_interconsulta" hidden>		
		<input hidden id="interconsulta_numero" name="interconsulta_numero"/>
		<div>				
				<div class="row margin_left_5px margin_top_5px">			
					<label class="margin_top_5px input_width_110px" for="interconsulta_especialista">Especialista:</label>
					<input type="text" class="form-control input_width_350px" id="interconsulta_especialista" name="interconsulta_especialista"  placeholder=""/>
				</div>
				<div class="row margin_left_5px margin_top_5px">
					<label class="margin_top_5px input_width_110px" for="interconsulta_solicito">Solicito:</label>
			    	<input type="text" class="form-control input_width_350px" id="interconsulta_solicito" name="interconsulta_solicito"  placeholder=""/>
				</div>
				<div class="row margin_left_5px margin_top_5px">
					<label class="margin_top_5px input_width_110px" for="interconsulta_fecha_solicito">Fecha Solicitud:</label>
			    	<input type="text" class="form-control input_width_350px" id="interconsulta_fecha_solicito" name="interconsulta_fecha_solicito"  placeholder=""/>
				</div>
				<div class="row margin_left_5px">
					<label>Respuesta:</label>			
				</div>
				<textarea class="width200px margin_left_5px" id="interconsulta_respuesta" name="interconsulta_respuesta" rows="8" cols="60"></textarea>			
				
		</div>	

		<br>
		<div class="row contenedor3">
			<div class="contenido3">
		    	<button type="button" onclick="interconsultaAnteriorSiguiente(0)" class="rodri_button_aceptar"><</button>
		    	<input id="interconsulta_actual_cantidad" disabled class="input_width_50px sinBackground margin_left_20px" value="0/0"></input>
		    	<button type="button" onclick="interconsultaAnteriorSiguiente(1)" class="rodri_button_aceptar">></button>
		    	<button type="button" onclick="nuevaInterconsulta()" class="rodri_button margin_left_20px">NUEVA</button>
		    	<button type="button" onclick="guardarDatosInterconsulta()" class="rodri_button margin_left_20px">GUARDAR</button>
			</div>
		</div>
		<br>
	</div>
</form>

<script type="text/javascript">
	
	function clickInterconsulta(){
		seccionPrincipal = document.getElementById("seccion_interconsulta");	
		if(seccionPrincipal.hidden == true){
			seccionPrincipal.hidden = false;	
			var f = new Date();
			var fecha = document.getElementById("interconsulta_fecha_solicito");
			fecha.value = f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear();
			//document.write(f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear());					
		}
		else {
			seccionPrincipal.hidden = true;
		}
	}	

	function cargarInterconsulta() {
		var paciente = document.getElementById("paciente_id").value;	
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_numero_interconsulta',
           data:{paciente:paciente ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.numero != null && data.interconsulta != null && data.response == 1){           			
           			document.getElementById("interconsulta_numero").value = data.numero;
           			if(data.numero != 0){
           				document.getElementById("seccion_interconsulta").hidden = false;	           			
	        			document.getElementById("interconsulta_especialista").value = data.interconsulta.especialista;
	        			
	        			var fecha_aux = data.interconsulta.fechaSolicitud.split("-");
	        			var fecha_mostrar = fecha_aux[2]+"/"+fecha_aux[1]+"/"+fecha_aux[0];
	        			document.getElementById("interconsulta_fecha_solicito").value = fecha_mostrar;

						document.getElementById("interconsulta_solicito").value = data.interconsulta.solicito;
						document.getElementById("interconsulta_respuesta").value = data.interconsulta.respuesta;
						var valor = data.numero+"/"+data.numero;
	           			document.getElementById("interconsulta_actual_cantidad").value = valor;		   			
           			}
           		}
            }
        });	
	}

	function interconsultaAnteriorSiguiente(opcion){
		var paciente = document.getElementById("paciente_id").value;	
		//var numero = document.getElementById("interconsulta_actual_cantidad").value;
		//var numero_aux = numero.split("/");
		//numero = parseInt(numero_aux[1]) - 1;	
		var numero_actual = document.getElementById("interconsulta_numero").value;
		if(opcion == 1) // avanzo
			var numero = parseInt(numero_actual) + 1;
		else
			var numero = parseInt(numero_actual) - 1;
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_interconsulta',
           data:{paciente:paciente ,numero:numero ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){           			
           			document.getElementById("interconsulta_numero").value = data.interconsulta.numero;
           			if(data.interconsulta.numero != 0){
           				document.getElementById("interconsulta_numero").value = data.interconsulta.numero;
           				document.getElementById("seccion_interconsulta").hidden = false;	           			
	        			document.getElementById("interconsulta_especialista").value = data.interconsulta.especialista;
	        			
	        			var fecha_aux = data.interconsulta.fechaSolicitud.split("-");
	        			var fecha_mostrar = fecha_aux[2]+"/"+fecha_aux[1]+"/"+fecha_aux[0];
	        			document.getElementById("interconsulta_fecha_solicito").value = fecha_mostrar;

						document.getElementById("interconsulta_solicito").value = data.interconsulta.solicito;
						document.getElementById("interconsulta_respuesta").value = data.interconsulta.respuesta;
						var valor = data.interconsulta.numero+"/"+data.numero;
	           			document.getElementById("interconsulta_actual_cantidad").value = valor;		   			
           			}
           		}
            }
        });
	}

	function nuevaInterconsulta(){
		document.getElementById("interconsulta_especialista").value = "";
		document.getElementById("interconsulta_solicito").value = "";
		document.getElementById("interconsulta_respuesta").value = "";		
		var numero = document.getElementById("interconsulta_actual_cantidad").value;
		var numero_aux = numero.split("/");
		numero = parseInt(numero_aux[1]) + 1;
		document.getElementById("interconsulta_numero").value = numero;
	}

	function guardarDatosInterconsulta(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;	
		var numero = document.getElementById("interconsulta_numero").value;	

		var especialista = document.getElementById("interconsulta_especialista").value;
		var solicito = document.getElementById("interconsulta_solicito").value;
		var respuesta = document.getElementById("interconsulta_respuesta").value;
		var fechaSolicitud = document.getElementById("interconsulta_fecha_solicito").value;

		//alert(consulta);
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_interconsulta',
           data:{consulta:consulta, paciente:paciente, numero:numero, solicito:solicito, especialista:especialista, respuesta:respuesta ,fechaSolicitud:fechaSolicitud,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			var valor = data.numero+"/"+data.cantidadInterconsultas;
           			document.getElementById("interconsulta_actual_cantidad").value = valor;
           			mostrarSnackbar("INTERCONSULTA GUARDADA");
            	} else {
            		mostrarSnackbar("INTERCONSULTA FALLO");
            	}
            }
        });
	}

</script>