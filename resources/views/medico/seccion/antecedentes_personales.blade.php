<form class="card background_panel">
	<div class="row margin_left_5px">		
		<label>Enfermedad Actual:</label>
	</div>
	<div class="row margin_left_5px">		
		<input type="text" class="form-control input_width_450px" id="ant_personales_enfermedad_actual" name="ant_personales_enfermedad_actual"/>
	</div>

	<div class="row margin_top_5px margin_left_5px">		
	 	<div class="margin_top_5px">
			<label>Internaciones:</label>      
			<div class="row margin_left_5px">
			  	<div class="custom-control custom-radio margin_left_5px ">
			  		<input onclick="clickInternacionesSi()" type="radio" id="ant_personales_internaciones_si" name="ant_personales_internaciones_group" class="custom-control-input">
			  		<label class="custom-control-label" for="ant_personales_internaciones_si">Si</label>
				</div>
				<div class="custom-control custom-radio ">
					 <input onclick="clickInternacionesNo()" type="radio" id="ant_personales_internaciones_no" name="ant_personales_internaciones_group" class="custom-control-input">
					 <label class="custom-control-label margin_left_5px" for="ant_personales_internaciones_no">No</label>
				</div>													
			</div>			
		</div>
	</div>

	<div hidden id="seccion_ant_personales_si">
		<div class="row margin_left_5px">
			<div class="margin_left_20px">
		  		<small>Motivo:</small>      
		  		<input type="text" class="form-control input_width_250px" id="ant_personales_internaciones_si_motivo" name="ant_personales_internaciones_si_motivo"  placeholder="Motivo"/>
	  		</div>
		</div>
		<div class="row margin_left_5px">
			<div class="margin_left_20px">
		  		<small>Lugar:</small>      
		  		<input type="text" class="form-control input_width_250px" id="ant_personales_internaciones_si_lugar" name="ant_personales_internaciones_si_lugar"  placeholder="Lugar"/>
	  		</div>
		</div>
		<div class="row margin_left_5px">
			<div class="margin_left_20px">
		  		<small>Duración:</small>      
		  		<input type="text" class="form-control input_width_250px" id="ant_personales_internaciones_si_duracion" name="ant_personales_internaciones_si_duracion"  placeholder="Duración"/>
	  		</div>
		</div>
		<div class="row margin_left_5px">
			<div class="margin_left_20px">
		  		<small>Indicación al alta:</small>   
		  		<div class="row margin_left_5px">   
		  		<textarea class="width200px" id="ant_personales_internaciones_si_indicacion_alta" name="ant_personales_internaciones_si_indicacion_alta" rows="5" cols="60" placeholder="Indicación al alta"></textarea>		
		  	</div>
	  		</div>
		</div>
	</div> <!-- FIN SECCION ANT PERSONALES SI -->

	<div class="row margin_top_5px margin_left_5px">		
	 	<div>
			<label class="margin_left_5px">Alergias:</label>      
			<div class="row margin_left_5px">
			  	<div class="custom-control custom-radio margin_left_5px margin_top_5px">
			  		<input onclick="clickAlergiasSi()" type="radio" id="ant_personales_alergias_si" name="ant_personales_alergias_group" class="custom-control-input">
			  		<label class="custom-control-label" for="ant_personales_alergias_si">Si</label>
				</div>
				<div class="custom-control custom-radio margin_top_5px">
					 <input onclick="clickAlergiasNo()" type="radio" id="ant_personales_alergias_no" name="ant_personales_alergias_group" class="custom-control-input">
					 <label class="custom-control-label margin_left_5px" for="ant_personales_alergias_no">No</label>
				</div>
				<input hidden type="text" class="form-control input_width_350px margin_left_5px" id="ant_personales_alergias_si_detalle" name="ant_personales_alergias_si_detalle"/>								
			</div>			
		</div>
	</div>

	<div class="row margin_top_5px margin_left_5px">		
	 	<div>
			<label class="margin_left_5px">Qx:</label>      
			<div class="row margin_left_5px">
			  	<div class="custom-control custom-radio margin_left_5px margin_top_5px">
			  		<input onclick="clickQxSi()" type="radio" id="ant_personales_qx_si" name="ant_personales_qx_group" class="custom-control-input">
			  		<label class="custom-control-label" for="ant_personales_qx_si">Si</label>
				</div>
				<div class="custom-control custom-radio margin_top_5px">
					 <input onclick="clickQxNo()" type="radio" id="ant_personales_qx_no" name="ant_personales_qx_group" class="custom-control-input">
					 <label class="custom-control-label margin_left_5px" for="ant_personales_qx_no">No</label>
				</div>
				<input hidden type="text" class="form-control input_width_350px margin_left_5px" id="ant_personales_qx_si_detalle" name="ant_personales_qx_si_detalle"/>								
			</div>			
		</div>
	</div>

	<div class="row margin_top_5px margin_left_5px">		
	 	<div>
			<label class="margin_left_5px">Traumatismos:</label>      
			<div class="row margin_left_5px">
			  	<div class="custom-control custom-radio margin_left_5px margin_top_5px">
			  		<input onclick="clickTraumatismosSi()" type="radio" id="ant_personales_traumatismos_si" name="ant_personales_traumatismos_group" class="custom-control-input">
			  		<label class="custom-control-label" for="ant_personales_traumatismos_si">Si</label>
				</div>
				<div class="custom-control custom-radio margin_top_5px">
					 <input onclick="clickTraumatismosNo()" type="radio" id="ant_personales_traumatismos_no" name="ant_personales_traumatismos_group" class="custom-control-input">
					 <label class="custom-control-label margin_left_5px" for="ant_personales_traumatismos_no">No</label>
				</div>
				<input hidden type="text" class="form-control input_width_350px margin_left_5px" id="ant_personales_traumatismos_si_detalle" name="ant_personales_traumatismos_si_detalle"/>								
			</div>			
		</div>
	</div>

	<div class="row margin_top_5px margin_left_5px">		
	 	<div>
			<label class="margin_left_5px">Transfusiones:</label>      
			<div class="row margin_left_5px">
			  	<div class="custom-control custom-radio margin_left_5px margin_top_5px">
			  		<input onclick="clickTransfusionesSi()" type="radio" id="ant_personales_transfusiones_si" name="ant_personales_transfusiones_group" class="custom-control-input">
			  		<label class="custom-control-label" for="ant_personales_transfusiones_si">Si</label>
				</div>
				<div class="custom-control custom-radio margin_top_5px">
					 <input onclick="clickTransfusionesNo()" type="radio" id="ant_personales_transfusiones_no" name="ant_personales_transfusiones_group" class="custom-control-input">
					 <label class="custom-control-label margin_left_5px" for="ant_personales_transfusiones_no">No</label>
				</div>
				<input hidden type="text" class="form-control input_width_350px margin_left_5px" id="ant_personales_transfusiones_si_detalle" name="ant_personales_transfusiones_si_detalle"/>								
			</div>			
		</div>
	</div>

</form>

<script type="text/javascript">
	
	function clickInternacionesSi(){
		var seccion = document.getElementById("seccion_ant_personales_si");
		seccion.hidden = false;
	}

	function clickInternacionesNo(){
		var seccion = document.getElementById("seccion_ant_personales_si");
		seccion.hidden = true;
		document.getElementById("ant_personales_internaciones_si_motivo").value = "";			
		document.getElementById("ant_personales_internaciones_si_lugar").value = "";			
		document.getElementById("ant_personales_internaciones_si_duracion").value = "";			
		document.getElementById("ant_personales_internaciones_si_indicacion_alta").value = "";			
	}

	function clickAlergiasSi(){
		var detalles = document.getElementById("ant_personales_alergias_si_detalle");
		detalles.hidden = false;
	}

	function clickAlergiasNo(){
		var detalles = document.getElementById("ant_personales_alergias_si_detalle");
		detalles.hidden = true;
		detalles.value = "";
	}

	function clickQxSi(){
		var detalles = document.getElementById("ant_personales_qx_si_detalle");
		detalles.hidden = false;
	}

	function clickQxNo(){
		var detalles = document.getElementById("ant_personales_qx_si_detalle");
		detalles.hidden = true;
		detalles.value = "";
	}

	function clickTraumatismosSi(){
		var detalles = document.getElementById("ant_personales_traumatismos_si_detalle");
		detalles.hidden = false;		
	}

	function clickTraumatismosNo(){
		var detalles = document.getElementById("ant_personales_traumatismos_si_detalle");
		detalles.hidden = true;
		detalles.value = "";
	}

	function clickTransfusionesSi(){
		var detalles = document.getElementById("ant_personales_transfusiones_si_detalle");
		detalles.hidden = false;		
	}

	function clickTransfusionesNo(){
		var detalles = document.getElementById("ant_personales_transfusiones_si_detalle");
		detalles.hidden = true;
		detalles.value = "";
	}

	function guardarAntecedentesPersonales(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;
		var enfermedad_actual = document.getElementById("ant_personales_enfermedad_actual").value;
		var interanaciones_si = document.getElementById("ant_personales_internaciones_si").checked;
		var interanaciones_no = document.getElementById("ant_personales_internaciones_no").checked;
		var internaciones = 2;
		if(interanaciones_si)
			interanaciones = 1;
		if(interanaciones_no)
			internaciones = 0;
		var internaciones_motivo = document.getElementById("ant_personales_internaciones_si_motivo").value;
		var interanaciones_lugar = document.getElementById("ant_personales_internaciones_si_lugar").value;
		var interanaciones_duracion = document.getElementById("ant_personales_internaciones_si_duracion").value;
		var interanaciones_indicacion_alta = document.getElementById("ant_personales_internaciones_si_indicacion_alta").value;
		
		var alergias = 2;
		var alergia_detalle = "";
		var alergias_si = document.getElementById("ant_personales_alergias_si").checked;
		var alergias_no = document.getElementById("ant_personales_alergias_no").checked;
		if(alergias_si){
			alergias = 1;
			var alergia_detalle = document.getElementById("ant_personales_alergias_si_detalle").value;
		}
		if(alergias_no)
			alergias = 0;

		var qx = 2;
		var qx_detalle = "";
		var qx_si = document.getElementById("ant_personales_qx_si").checked;
		var qx_no = document.getElementById("ant_personales_qx_no").checked;
		if(qx_si){
			qx = 1;
			qx_detalle = document.getElementById("ant_personales_qx_si_detalle").value;
		} 
		if(qx_no)
			qx = 0;

		var traumatismo = 2;
		var traumatismo_detalle = "";
		var traumatismos_si = document.getElementById("ant_personales_traumatismos_si").checked;
		var traumatismos_no = document.getElementById("ant_personales_traumatismos_no").checked;
		if(traumatismos_si){
			traumatismo = 1;
			traumatismo_detalle = document.getElementById("ant_personales_traumatismos_si_detalle").value;
		}
		if(traumatismos_no)
			traumatismo = 0;

		var transfusiones = 2;
		var transfusiones_detalle = "";
		var transfusiones_si = document.getElementById("ant_personales_transfusiones_si").checked;
		var transfusiones_no = document.getElementById("ant_personales_transfusiones_no").checked;
		if(transfusiones_si){
			transfusiones = 1;
			transfusiones_detalle = document.getElementById("ant_personales_transfusiones_si_detalle").value;
		}
		if(transfusiones_no)
			transfusiones = 0;

		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_antecedentes_personales',
           data:{consulta:consulta, paciente:paciente,enfermedad_actual:enfermedad_actual, internaciones:internaciones, internaciones_motivo:internaciones_motivo, interanaciones_lugar:interanaciones_lugar, interanaciones_duracion:interanaciones_duracion,interanaciones_indicacion_alta:interanaciones_indicacion_alta, alergias:alergias, alergia_detalle:alergia_detalle, qx:qx, qx_detalle:qx_detalle, traumatismo:traumatismo, traumatismo_detalle:traumatismo_detalle, transfusiones:transfusiones, transfusiones_detalle:transfusiones_detalle ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			//alert("Guardado con exito actividades extra escolares");
            	} else {
            		mostrarSanckbar("ANTECEDENTES PERSONALES FALLO");
            		//alert("Fallo al guardar");
            	}
            }
        });	
	}

	function cargarAntecedentesPersonales(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;		
		
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_antecedentes_personales',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){         
         			document.getElementById("ant_personales_enfermedad_actual").value = data.response_data.enfermedad_actual;		
					if(data.response_data.internaciones == 1) {
						document.getElementById("ant_personales_internaciones_si").checked = true;
						document.getElementById("seccion_ant_personales_si").hidden = false;
						document.getElementById("ant_personales_internaciones_si_motivo").value = data.response_data.internacion_motivo;
						document.getElementById("ant_personales_internaciones_si_lugar").value = data.response_data.interanacion_lugar;
						document.getElementById("ant_personales_internaciones_si_duracion").value = data.response_data.internacion_duracion;
						document.getElementById("ant_personales_internaciones_si_indicacion_alta").value = data.response_data.internacion_indicacion_alta;
					} else {
						document.getElementById("ant_personales_internaciones_no").checked = true;  			  			
					}

					if(data.response_data.alergias == 1) {
						document.getElementById("ant_personales_alergias_si").checked = true;						
						document.getElementById("ant_personales_alergias_si_detalle").hidden = false;
						document.getElementById("ant_personales_alergias_si_detalle").value = data.response_data.alergia_detalle;
					} else {
						document.getElementById("ant_personales_alergias_no").checked = true;  			  							
					}

					if(data.response_data.qx == 1) {
						document.getElementById("ant_personales_qx_si").checked = true;						
						document.getElementById("ant_personales_qx_si_detalle").hidden = false;
						document.getElementById("ant_personales_qx_si_detalle").value = data.response_data.qx_detalle;
					} else {
						document.getElementById("ant_personales_qx_no").checked = true;  			  							
					}

					if(data.response_data.traumatismos == 1) {
						document.getElementById("ant_personales_traumatismos_si").checked = true;						
						document.getElementById("ant_personales_traumatismos_si_detalle").hidden = false;
						document.getElementById("ant_personales_traumatismos_si_detalle").value = data.response_data.traumatismos_detalle;
					} else {
						document.getElementById("ant_personales_traumatismos_no").checked = true;  			  						
					}

					if(data.response_data.transfusiones == 1) {
						document.getElementById("ant_personales_transfusiones_si").checked = true;						
						document.getElementById("ant_personales_transfusiones_si_detalle").hidden = false;
						document.getElementById("ant_personales_transfusiones_si_detalle").value = data.response_data.transfusiones_detalle;
					} else {
						document.getElementById("ant_personales_transfusiones_no").checked = true;  			  						
					}
					
            	} else {
            		//mostrarSanckbar("ANTECEDENTES PERSONALES FALLO");            		
            	}
            }
        });	
	}

</script>