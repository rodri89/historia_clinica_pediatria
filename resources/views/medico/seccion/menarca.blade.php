<form class="card background_panel_consulta_actual">	
	<div class="row margin_left_5px">
		<h4><b><a onclick="clickMenarca()" type="button">Menarca</a></b></h4>
	</div>	
	<div id="seccion_menarca" hidden>		

		<div class="row margin_left_5px margin_top_5px">			
	    	<input type="text" class="form-control input_width_150px" id="menarca_valor" name="menarca_valor"  placeholder=""/>
		</div>

		<br>
		<!--<div class="row contenedor3">
	    	<button onclick="guardarDatos()" class="rodri_button contenido3">GUARDAR</button>
		</div>
		<br> -->
	</div>

</form>

<script type="text/javascript">
	
	function clickMenarca(){
		seccionPrincipal = document.getElementById("seccion_menarca");	
		if(seccionPrincipal.hidden == true){
			seccionPrincipal.hidden = false;			
		}
		else {
			seccionPrincipal.hidden = true;
		}
	}

	function guardarMenarca(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;
		var descripcion = document.getElementById("menarca_valor").value;
		//alert(consulta);
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_menarca',
           data:{consulta:consulta, paciente:paciente, descripcion:descripcion ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			//alert("Guardado con exito actividades extra escolares");
            	} else {
            		mostrarSanckbar("MENARCA FALLO");
            		//alert("Fallo al guardar");
            	}
            }
        });		
	}

	function cargarMenarca(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;		
		
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_menarca',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){           			
           			document.getElementById("menarca_valor").value = data.response_data.descripcion;           			           	
           			document.getElementById("seccion_menarca").hidden = false;	
            	} else {
            		mostrarSanckbar("MENARCA FALLO");            		
            	}
            }
        });	
	}
</script>