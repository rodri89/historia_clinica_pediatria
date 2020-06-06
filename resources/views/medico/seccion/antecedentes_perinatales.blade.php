<form class="card background_panel">
	<div class="row">
		<div>
			<label class="margin_left_5px" for="ant_perinatales_embarazo">Embarazo:</label>
            <select class="form-control input_width_250px margin_left_5px" id="ant_perinatales_embarazo" name="ant_perinatales_embarazo">            
	            <option>CONTROLADO</option>    
	            <option>POCO CONTROLADO</option>    
	            <option>NO CONTROLADO</option>    
	        </select>
    	</div>

    	<div>
			<label class="margin_left_20px" for="ant_perinatales_embarazo_numero_controles">N°Controles:</label>
	        <input type="text" class="form-control input_width_50px margin_left_20px" id="ant_perinatales_embarazo_numero_controles" name="ant_perinatales_embarazo_numero_controles"  placeholder="0"/>
		</div>
	</div>

	<div class="row margin_top_5px">		
	 	<div>
			<label class="margin_left_5px">Patologías:</label>      
			<div class="row margin_left_5px">
			  	<div class="custom-control custom-radio margin_left_5px margin_top_5px">
			  		<input onclick="clickPatologiaSi()" type="radio" id="ant_perinatles_patologia_si" name="patologia_group" class="custom-control-input">
			  		<label class="custom-control-label" for="ant_perinatles_patologia_si">Si</label>
				</div>
				<div class="custom-control custom-radio margin_top_5px">
					 <input onclick="clickPatologiaNo()" type="radio" id="ant_perinatles_patologia_no" name="patologia_group" class="custom-control-input">
					 <label class="custom-control-label margin_left_5px" for="ant_perinatles_patologia_no">No</label>
				</div>
				<input hidden type="text" class="form-control input_width_350px margin_left_5px" id="ant_perinatles_patologia_si_detalle" name="ant_perinatles_patologia_si_detalle"/>								
			</div>			
		</div>
	</div>

	<div class="row">
		<div>
			<label class="margin_left_5px margin_top_5px" for="ant_perinatales_parto">Parto:</label>
            <select class="form-control input_width_250px margin_left_5px" id="ant_perinatales_parto" name="ant_perinatales_parto">            
	            <option>CESÁREA</option>    
	            <option>EUTÓCICO</option>    
	            <option>DISTÓCICO</option>    
	        </select>
    	</div>

    	<div>			
    		<label class="margin_top_5px"></label>
	        <input type="text" class="form-control input_width_350px margin_left_20px margin_top_12px" id="ant_perinatales_parto_detalle" name="ant_perinatales_parto_detalle"/>
		</div>
	</div>

	<div class="row margin_top_12px">		
		
			<label class="margin_left_5px margin_top_5px" for="eg">EG:</label>
	        <input type="text" class="form-control input_width_50px margin_left_5px" id="ant_perinaltes_eg" name="ant_perinaltes_eg"  placeholder="0"/>

	        <label class="margin_left_20px margin_top_5px" for="peso">Peso:</label>
	        <input type="text" class="form-control input_width_50px margin_left_5px" id="ant_perinaltes_peso" name="ant_perinaltes_peso"  placeholder="0"/>
			
			<label class="margin_left_20px margin_top_5px" for="talla">Talla:</label>
	        <input type="text" class="form-control input_width_50px margin_left_5px" id="ant_perinaltes_talla" name="ant_perinaltes_talla"  placeholder="0"/>

	        <label class="margin_left_20px margin_top_5px" for="pc">PC:</label>
	        <input type="text" class="form-control input_width_50px margin_left_5px" id="ant_perinaltes_pc" name="ant_perinaltes_pc"  placeholder="0"/>

	        <label class="margin_left_20px margin_top_5px" for="apgar">Apgar:</label>
	        <input type="text" class="form-control input_width_50px margin_left_5px" id="ant_perinaltes_apgar" name="ant_perinaltes_apgar"  placeholder="0"/>	            
    	   
	</div>

	<div class="row margin_top_12px">		
			<label class="margin_left_5px margin_top_5px" for="ant_perinaltes_caida_cordon">Caida Cordón:</label>
	        <input type="text" class="form-control input_width_50px margin_left_5px" id="ant_perinaltes_caida_cordon" name="ant_perinaltes_caida_cordon"  placeholder="0"/> 
	        <label class="margin_left_5px margin_top_5px" for="ant_perinaltes_caida_cordon">dias.</label>
	</div>

	<div class="row margin_top_12px">		
			<label class="margin_left_5px margin_top_5px" for="ant_perinaltes_meconio">Meconio:</label>
	        <input type="text" class="form-control input_width_50px margin_left_5px" id="ant_perinaltes_meconio" name="ant_perinaltes_meconio"  placeholder="0"/> 
	        <label class="margin_left_5px margin_top_5px" for="ant_perinaltes_meconio">dias.</label>
	</div>

	<div class="row margin_top_12px">		
			<label class="margin_left_5px margin_top_5px" for="ant_perinaltes_gyf">G y F:</label>
	        <input type="text" class="form-control input_width_60px margin_left_5px" id="ant_perinaltes_gyf" name="ant_perinaltes_gyf"  placeholder="A+"/> 	        
	</div>

	<div class="row margin_top_5px">		
	 	<div>
			<label class="margin_left_5px">FEI:</label>      
			<div class="row margin_left_5px">
			  	<div class="custom-control custom-radio margin_left_5px margin_top_5px">
			  		<input onclick="clickFeiNormal()" type="radio" id="ant_perinatales_fei_normal" name="fei_group" class="custom-control-input">
			  		<label class="custom-control-label" for="ant_perinatales_fei_normal">Normal</label>
				</div>
				<div class="custom-control custom-radio margin_top_5px">
					 <input onclick="clickFeiAnormal()" type="radio" id="ant_perinatales_fei_anormal" name="fei_group" class="custom-control-input">
					 <label class="custom-control-label margin_left_5px" for="ant_perinatales_fei_anormal">Anormal</label>
				</div>
				<input hidden type="text" class="form-control input_width_350px margin_left_5px" id="ant_perinatales_fei_anormal_detalle" name="ant_perinatales_fei_anormal_detalle"/>								
			</div>			
		</div>
	</div>

	<div class="row margin_top_5px">		
	 	<div>
			<label class="margin_left_5px">OEA:</label>      
			<div class="row margin_left_5px">
			  	<div class="custom-control custom-radio margin_left_5px margin_top_5px">
			  		<input type="radio" id="ant_perinatales_oea_presente" name="oea_group" class="custom-control-input">
			  		<label class="custom-control-label" for="ant_perinatales_oea_presente">Presente</label>
				</div>
				<div class="custom-control custom-radio margin_top_5px">
					 <input type="radio" id="ant_perinatales_oea_ausente" name="oea_group" class="custom-control-input">
					 <label class="custom-control-label margin_left_5px" for="ant_perinatales_oea_ausente">Ausente</label>
				</div>									
			</div>			
		</div>
	</div>

</form>

<script type="text/javascript">
	function clickPatologiaSi(){
		document.getElementById("ant_perinatles_patologia_si_detalle").hidden = false;
	}

	function clickPatologiaNo(){
		document.getElementById("ant_perinatles_patologia_si_detalle").hidden = true; 	
		document.getElementById("ant_perinatles_patologia_si_detalle").value = ''; 
	}

	function clickFeiNormal(){
		document.getElementById("ant_perinatales_fei_anormal_detalle").hidden = true; 	
		document.getElementById("ant_perinatales_fei_anormal_detalle").value = ''; 
	}

	function clickFeiAnormal(){
		document.getElementById("ant_perinatales_fei_anormal_detalle").hidden = false; 	
	}

	function guardarAntecedentesPerinatales(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;
		var embarazo = document.getElementById("ant_perinatales_embarazo").value;
		var embarazo_numero_controles = document.getElementById("ant_perinatales_embarazo_numero_controles").value;
		var patologias_check_si = document.getElementById("ant_perinatles_patologia_si").checked;
		var patologias_check_no = document.getElementById("ant_perinatles_patologia_no").checked;
		var patologia = 2;
		var patologias_detalle = "";
		if(patologias_check_si){
			patologia = 1;
			patologias_detalle = document.getElementById("ant_perinatles_patologia_si_detalle").value;
		}
		if(patologias_check_no){
			patologia = 0;
		}
		
		var parto = document.getElementById("ant_perinatales_parto").value;
		var parto_detalle = document.getElementById("ant_perinatales_parto_detalle").value;
		var eg = document.getElementById("ant_perinaltes_eg").value;
		var peso = document.getElementById("ant_perinaltes_peso").value;
		var talla = document.getElementById("ant_perinaltes_talla").value;
		var pc = document.getElementById("ant_perinaltes_pc").value;
		var apgar = document.getElementById("ant_perinaltes_apgar").value;
		var caida_cordon = document.getElementById("ant_perinaltes_caida_cordon").value;
		var meconio = document.getElementById("ant_perinaltes_meconio").value;
		var gyf = document.getElementById("ant_perinaltes_gyf").value;
		var fei = 2;		
		var fei_anormal_detalle = "";
		var fei_normal = document.getElementById("ant_perinatales_fei_normal").checked;
		var fei_anormal = document.getElementById("ant_perinatales_fei_anormal").checked;
		if(fei_normal){
			fei = 1;			
		}
		if(fei_anormal){
			fei = 0;
			fei_anormal_detalle = document.getElementById("ant_perinatales_fei_anormal_detalle").value;
		}
		var oea = 2;
		var oea_presente = document.getElementById("ant_perinatales_oea_presente").checked;
		var oea_ausente = document.getElementById("ant_perinatales_oea_ausente").checked;
		if(oea_presente)
			oea = 1;
		if(oea_ausente)
			oea = 0;
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_antecedentes_perinatales',
           data:{consulta:consulta, paciente:paciente, embarazo :embarazo,embarazo_numero_controles:embarazo_numero_controles,patologia:patologia,patologias_detalle:patologias_detalle, parto:parto, parto_detalle:parto_detalle, eg:eg, peso:peso, talla:talla, pc:pc, apgar:apgar, caida_cordon:caida_cordon, meconio:meconio, gyf:gyf, fei:fei, fei_anormal_detalle:fei_anormal_detalle, oea:oea,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			//alert("Guardado con exito actividades extra escolares");
            	} else {
            		mostrarSanckbar("ANTECEDENTES PERINATALES FALLO");
            		//alert("Fallo al guardar");
            	}
            }
        });
	}

	function cargarAntecedentesPerinatales(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;		
		
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_antecedentes_perinatales',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data!=null && data.response == 1){         
         			document.getElementById("ant_perinatales_embarazo").value = data.response_data.embarazo;
					document.getElementById("ant_perinatales_embarazo_numero_controles").value = data.response_data.embarazo_controles;
					if(data.response_data.patologias == 1) {
						document.getElementById("ant_perinatles_patologia_si").checked = true;
						document.getElementById("ant_perinatles_patologia_si_detalle").hidden = false;
						document.getElementById("ant_perinatles_patologia_si_detalle").value = data.response_data.patologias_detalle;
					} else {
						document.getElementById("ant_perinatles_patologia_no").checked = true;  			  			
					}

					document.getElementById("ant_perinatales_parto").value = data.response_data.parto;
					document.getElementById("ant_perinatales_parto_detalle").value = data.response_data.parto_detalle;
           			document.getElementById("ant_perinaltes_eg").value = data.response_data.eg;
					document.getElementById("ant_perinaltes_peso").value = data.response_data.peso;
					document.getElementById("ant_perinaltes_talla").value = data.response_data.talla;
					document.getElementById("ant_perinaltes_pc").value = data.response_data.pc;
					document.getElementById("ant_perinaltes_apgar").value = data.response_data.apgar;
					document.getElementById("ant_perinaltes_caida_cordon").value = data.response_data.caida_cordon;
					document.getElementById("ant_perinaltes_meconio").value = data.response_data.meconio;
					document.getElementById("ant_perinaltes_gyf").value = data.response_data.gyf;

					if(data.response_data.fei == 1) {
						document.getElementById("ant_perinatales_fei_normal").checked = true;						
					} else {
						document.getElementById("ant_perinatales_fei_anormal").checked = true;  			  			
						document.getElementById("ant_perinatales_fei_anormal_detalle").hidden = false;
						document.getElementById("ant_perinatales_fei_anormal_detalle").value = data.response_data.fei_anormal_detalle;
					}

					if(data.response_data.oea == 1) {
						document.getElementById("ant_perinatales_oea_presente").checked = true;						
					} else {
						document.getElementById("ant_perinatales_oea_ausente").checked = true;  			  			
					}
            	} else {
            		//mostrarSanckbar("ANTECEDENTES PERINATALES FALLO");            		
            	}
            }
        });	
	}

</script>