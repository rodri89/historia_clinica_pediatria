<form class="card background_panel_consulta_actual">	
	<div class="row margin_left_5px">
		<h4><b><a onclick="clickConductas()" type="button">Conductas</a></b></h4>
	</div>	
	<div id="seccion_conductas" hidden>		
		
		<div class="row margin_left_5px">		
			<textarea class="width200px" id="conductas_detalles" name="conductas_detalles" rows="10" cols="100"></textarea>	
		</div>

		<br>
		<!--
		<div class="row contenedor3">
	    	<button onclick="guardarDatos()" class="rodri_button contenido3">GUARDAR</button>
		</div>
		<br> -->
	</div>

</form>

<script type="text/javascript">
	
	function clickConductas(){
		seccionPrincipal = document.getElementById("seccion_conductas");	
		if(seccionPrincipal.hidden == true){
			seccionPrincipal.hidden = false;			
		}
		else {
			seccionPrincipal.hidden = true;
		}
	}

	function guardarConductas(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;
		var descripcion = document.getElementById("conductas_detalles").value;
		//alert(consulta);
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_conductas',
           data:{consulta:consulta, paciente:paciente, descripcion:descripcion ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			//alert("Guardado con exito actividades extra escolares");
            	} else {
            		mostrarSanckbar("CONDUCTAS FALLO");
            		//alert("Fallo al guardar");
            	}
            }
        });		
	}

	function cargarConductas(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;		
		
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_conductas',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){           			
           			document.getElementById("conductas_detalles").value = data.response_data.descripcion;           			
           			document.getElementById("seccion_conductas").hidden = false;	
            	} else {
            		//mostrarSanckbar("CONDUCTAS FALLO");            		
            	}
            }
        });	
	}
</script>