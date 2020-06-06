<form class="card background_panel_consulta_actual">	
	<div class="row margin_left_5px">
		<h4><b><a onclick="clickExamenFisico()" type="button">Exámen Físico</a></b></h4>
	</div>	
	<div id="seccion_examen_fisico" hidden>		
		<div class="row">
		<div class="col-md-5">		
			<div class="row margin_left_5px margin_top_5px">			
				<label class=" margin_top_5px input_width_50px" for="examen_fisico_peso">Peso:</label>
		    	<input type="number" step=".01" min="0" class="form-control input_width_110px" id="examen_fisico_peso" name="examen_fisico_peso"  placeholder=""/>
		    	<label class=" margin_top_5px margin_left_5px input_width_60px">kg.</label>
		    	<label class=" margin_top_5px margin_left_30px input_width_80px" for="examen_fisico_percentil_peso">Percentil</label>
		    	<input type="text" class="form-control input_width_80px" id="examen_fisico_percentil_peso" name="examen_fisico_percentil_peso"  placeholder=""/>
			</div> 

			<div class="row margin_left_5px margin_top_5px">			
				<label class=" margin_top_5px input_width_50px" for="examen_fisico_talla">Talla:</label>
		    	<input type="number" step=".01" min="0" class="form-control input_width_110px" id="examen_fisico_talla" name="examen_fisico_talla"  placeholder=""/>
		    	<label class=" margin_top_5px margin_left_5px input_width_60px">mts.</label>
		    	<label class=" margin_top_5px margin_left_30px input_width_80px" for="examen_fisico_percentil_talla">Percentil</label>
		    	<input type="number" step=".01" min="0" class="form-control input_width_80px" id="examen_fisico_percentil_talla" name="examen_fisico_percentil_talla"  placeholder=""/>
			</div> 
					
			<div class="row margin_left_5px margin_top_5px">			
				<label class=" margin_top_5px input_width_50px" for="examen_fisico_pc">PC:</label>
		    	<input type="number" step=".01" min="0" class="form-control input_width_110px" id="examen_fisico_pc" name="examen_fisico_pc"  placeholder=""/>
		    	<label class=" margin_top_5px margin_left_5px input_width_60px">cm.</label>
		    	<label class=" margin_top_5px margin_left_30px input_width_80px" for="examen_fisico_percentil_pc">Percentil</label>
		    	<input type="number" step=".01" min="0" class="form-control input_width_80px" id="examen_fisico_percentil_pc" name="examen_fisico_percentil_pc"  placeholder=""/>
			</div> 
			
			<div class="row margin_left_5px margin_top_5px">			
				<label class=" margin_top_5px input_width_50px" for="examen_fisico_ipd">IPD:</label>
		    	<input type="number" step=".01" min="0" class="form-control input_width_110px" id="examen_fisico_ipd" name="examen_fisico_ipd"  placeholder=""/>
		    	<label class=" margin_top_5px margin_left_5px input_width_60px">gr/dia.</label>		    	
			</div>

			<div class="row margin_left_5px margin_top_5px">			
				<label class=" margin_top_5px input_width_50px" for="examen_fisico_ta">TA:</label>
		    	<input type="number" step=".01" min="0" class="form-control input_width_110px" id="examen_fisico_ta" name="examen_fisico_ta"  placeholder=""/>
		    	<label class=" margin_top_5px margin_left_5px input_width_60px">mm HG.</label>		    	
			</div>

			<div class="row margin_left_5px margin_top_5px">			
				<label class=" margin_top_5px input_width_50px" for="examen_fisico_imc">IMC:</label>
		    	<input type="number" step=".01" min="0" class="form-control input_width_110px" id="examen_fisico_imc" name="examen_fisico_imc"  placeholder=""/>
		    	<button type="button" onclick="calcularIMC()" class="rodri_button_aceptar margin_left_5px">Calcular</button>
		    	<label class=" margin_top_5px margin_left_30px input_width_80px" for="examen_fisico_percentil_imc">Percentil</label>
		    	<input type="number" step=".01" min="0" class="form-control input_width_80px" id="examen_fisico_percentil_imc" name="examen_fisico_percentil_imc"  placeholder=""/>
			</div> 
		
		</div>

		<div class="col-md-7">		
			<!--<div>
				<label>Nota:</label>			
			</div>-->
			<textarea class="width200px" id="examen_fisico_nota" name="examen_fisico_nota" rows="10" cols="80"></textarea>	
		</div>
	</div>
		<br>
		<!--<div class="row contenedor3">
	    	<button onclick="guardarDatos()" class="rodri_button contenido3">GUARDAR</button>
		</div>
		<br> -->
	</div>

</form>

<script type="text/javascript">
	
	function clickExamenFisico(){
		seccionPrincipal = document.getElementById("seccion_examen_fisico");	
		if(seccionPrincipal.hidden == true){
			seccionPrincipal.hidden = false;			
		}
		else {
			seccionPrincipal.hidden = true;
		}
	}

	//peso/talla al cuadrado

	function calcularIMC(){
		var peso = document.getElementById("examen_fisico_peso").value;
		var talla = document.getElementById("examen_fisico_talla").value;
		talla = talla * talla;
		var imc_aux = peso / talla;
		imc_aux = trunc(imc_aux, 2);
		document.getElementById("examen_fisico_imc").value = imc_aux;		
	}

	function trunc (x, posiciones = 0) {
	  var s = x.toString()
	  var l = s.length
	  var decimalLength = s.indexOf('.') + 1
	  var numStr = s.substr(0, decimalLength + posiciones)
	  return Number(numStr)
	}

	function guardarExamenFisico(){		
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;		
		
		var peso = document.getElementById("examen_fisico_peso").value;
		var peso_percentil = document.getElementById("examen_fisico_percentil_peso").value;

		var talla = document.getElementById("examen_fisico_talla").value;
		var talla_percentil = document.getElementById("examen_fisico_percentil_talla").value;

		var pc = document.getElementById("examen_fisico_pc").value;
		var pc_percentil = document.getElementById("examen_fisico_percentil_pc").value;

		var ipd = document.getElementById("examen_fisico_ipd").value;
		var ta = document.getElementById("examen_fisico_ta").value;

		var imc = document.getElementById("examen_fisico_imc").value;
		var imc_percentil = document.getElementById("examen_fisico_percentil_imc").value;

		var nota = document.getElementById("examen_fisico_nota").value;
		//alert(consulta);
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_examen_fisico',
           data:{consulta:consulta, paciente:paciente, peso:peso, peso_percentil:peso_percentil, talla:talla, talla_percentil:talla_percentil, pc:pc, pc_percentil:pc_percentil, ipd:ipd, ta:ta, imc:imc, imc_percentil:imc_percentil, nota:nota ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){
           			//alert("Guardado con exito actividades extra escolares");
            	} else {
            		mostrarSanckbar("EXAMEN FISICO FALLO");
            		//alert("Fallo al guardar");
            	}
            }
        });		
	}

	function cargarExamenFisico(){
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;		
		
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_examen_fisico',
           data:{consulta:consulta, paciente:paciente,_token: '{{csrf_token()}}'},
           	success:function(data){                         		
           		if(data.response_data != null && data.response == 1){           			
           			document.getElementById("examen_fisico_nota").value = data.response_data.nota;           			
           			document.getElementById("examen_fisico_peso").value =data.response_data.peso;
					document.getElementById("examen_fisico_percentil_peso").value = data.response_data.peso_percentil;
					document.getElementById("examen_fisico_talla").value = data.response_data.talla;
					document.getElementById("examen_fisico_percentil_talla").value = data.response_data.talla_percentil;
					document.getElementById("examen_fisico_pc").value = data.response_data.pc;
					document.getElementById("examen_fisico_percentil_pc").value = data.response_data.pc_percentil;
					document.getElementById("examen_fisico_ipd").value = data.response_data.ipd;
					document.getElementById("examen_fisico_ta").value = data.response_data.ta;
					document.getElementById("examen_fisico_imc").value = data.response_data.imc;
					document.getElementById("examen_fisico_percentil_imc").value = data.response_data.imc_percentil;
           			document.getElementById("seccion_examen_fisico").hidden = false;	
            	} else {
            		//mostrarSanckbar("EXAMEN FISICO FALLO");            		
            	}
            }
        });	
	}
</script>