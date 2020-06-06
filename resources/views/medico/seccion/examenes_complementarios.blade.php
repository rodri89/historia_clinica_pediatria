<form class="card background_panel_consulta_actual" method="post" action="{{ route('guardarexamenescomplementariosfotos') }}" enctype="multipart/form-data">	
	@csrf  
	<div class="row margin_left_5px">
		<h4><b><a onclick="clickExamenesComplementarios()" type="button">Examenes Complementarios</a></b></h4>
	</div>	
	<div id="seccion_examenes_complementarios" hidden>		
		@if($consulta != null)
	   		<input type="text" id="examenes_complementarios_consulta_id" name="examenes_complementarios_consulta_id" value="{{$consulta->id}}"  hidden />
	   	@else
	   		<input type="text" id="examenes_complementarios_consulta_id" name="examenes_complementarios_consulta_id" hidden />
	   	@endif

	   	@if($paciente != null)
	   		<input type="text" id="examenes_complementarios_paciente_id" name="examenes_complementarios_paciente_id" value="{{$paciente->id}}" hidden />
	   	@else
	   		<input type="text" id="examenes_complementarios_paciente_id" name="examenes_complementarios_paciente_id" hidden />
	   	@endif
	   	<input type="text" id="examenes_complementarios_fecha_solicito" name="examenes_complementarios_fecha_solicito"  hidden />
		
		<input hidden id="examenes_complementarios_id" name="examenes_complementarios_id" />
		<input hidden id="examenes_complementarios_numero" name="examenes_complementarios_numero"/>
		<input hidden id="examenes_complementarios_numero_foto" name="examenes_complementarios_numero"/>

		<div class="row margin_left_5px">
			<div class="col-md-6">		
				<div class="row margin_left_5px margin_top_5px">			
					<label class="margin_top_5px input_width_80px" for="examenes_complementarios_solicito">Solicito:</label>
			    	<input type="text" class="form-control input_width_350px" id="examenes_complementarios_solicito" name="examenes_complementarios_solicito"  placeholder=""/>
				</div>
				<div class="row margin_left_5px">
					<label>Respuesta:</label>			
				</div>
				<textarea class="width200px margin_left_5px" id="examenes_complementarios_respuesta" name="examenes_complementarios_respuesta" rows="8" cols="60"></textarea>			
			</div>
			<div class="col-md-6">		
				<label>Agregar Foto:</label><br>
				<div id="seccion_examen_complementario_fotos">
			        <input type="hidden" id="foto_ex_complementario_id" name="foto_ex_complementario_id" />
			        <input type="hidden" id="ex_comp_cantidad_fotos" name="ex_comp_cantidad_fotos" />
			        <input type="file" id="ex_comp_foto_1" name="ex_comp_foto_1" /> 
			     </div>
          		<br>
          		<button onclick="agregarBotonNuevaFoto()" type="button" class="rodri_button_aceptar">AGREGAR</button> 			
          		<button type="submit" class="rodri_button_aceptar margin_left_20px">GUARDAR</button>

          		<div id="seccion_examen_complementario_ver_fotos" class="margin_top_12px">
				<a type="button" id="examenes_complementarios_foto_1" class="card-img-top img_little botonImage" alt="">
          			<img id="examenes_complementarios_foto" src="" class="card-img-top img_little botonImage">
          		</a>
				<div class="row margin_top_12px margin_left_60px">					
		    			<button type="button" onclick="examenesComplementariosAnteriorSiguienteFoto(0)" class="rodri_button_aceptar_si"><</button>
				    	<input id="examenes_complementarios_actual_cantidad_fotos" disabled class="input_width_50px sinBackground margin_left_20px" value="0/0"></input>
				    	<button type="button" onclick="examenesComplementariosAnteriorSiguienteFoto(1)" class="rodri_button_aceptar_si">></button>				    					
				</div>		
			</div>
			</div>
			
		</div>	

		<br>
		<div class="row contenedor3">
			<div class="contenido3">
		    	<button type="button" onclick="examenesComplementariosAnteriorSiguiente(0)" class="rodri_button_aceptar"><</button>
		    	<input id="examenes_complementarios_actual_cantidad" disabled class="input_width_50px sinBackground margin_left_20px" value="0/0"></input>
		    	<button type="button" onclick="examenesComplementariosAnteriorSiguiente(1)" class="rodri_button_aceptar">></button>
		    	<button type="button" onclick="nuevoExamenComplementario()" class="rodri_button margin_left_20px">NUEVA</button>
		    	<button type="button" onclick="guardarExamenComplementario()" class="rodri_button margin_left_20px">GUARDAR</button>
			</div>
		</div>		
		<br>
	</div>
</form>
@include('modal.modal_ver_imagen')
<script type="text/javascript">
	
	function nuevoExamenComplementario() {
		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;		
		$.ajax({
	           type:'POST',
	           dataType:'JSON',
	           url:'/nuevo_examen_complementario',
	           data:{consulta:consulta, paciente:paciente, _token: '{{csrf_token()}}'},
	           	success:function(data) {               	
	           		if(data.response == 1) {           			           			
	           			if(data.examenComplementario != null) {            				           				
	           				document.getElementById("examenes_complementarios_id").value = "-1";
	           				document.getElementById("examenes_complementarios_numero").value = data.examenComplementario;
	           				document.getElementById("examenes_complementarios_solicito").value = "";
	           				document.getElementById("examenes_complementarios_respuesta").value = "";           
	           				$("#examenes_complementarios_foto").attr("src", "");                
		                	document.getElementById("examenes_complementarios_actual_cantidad_fotos").value = "0/0";
	           			}
	            	}
	            }
	        });
	}

	function clickExamenesComplementarios() {
		seccionPrincipal = document.getElementById("seccion_examenes_complementarios");	
		if(seccionPrincipal.hidden == true){
			//getExamanesComplementariosId();	
			var ex_compl_id = document.getElementById("examenes_complementarios_id").value;
			$('#ex_comp_cantidad_fotos').val(1);
  			$('#foto_ex_complementario_id').val(ex_compl_id); 
			var f = new Date();
			var fecha = document.getElementById("examenes_complementarios_fecha_solicito");
			fecha.value = f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear();
			seccionPrincipal.hidden = false;				
			cargarFotoExamenComplementario();	
		}
		else {
			seccionPrincipal.hidden = true;
		}
	}

	 function agregarBotonNuevaFoto(){
	    var cantidadFotos = document.getElementById("ex_comp_cantidad_fotos").value;  //1      
	    var viejoValor = parseInt(cantidadFotos); // 1
	    var nuevoValor = parseInt(cantidadFotos) + 1;      
	  //  var btn = document.getElementById("foto-"+viejoValor);
	    var ultimoFile = document.getElementById("ex_comp_foto_"+viejoValor);	    
	    var f = ultimoFile.value;
	    if(f.localeCompare('') != 0){
	      $('#ex_comp_cantidad_fotos').val(nuevoValor);
	      var seccion = document.getElementById("seccion_examen_complementario_fotos");                  
	      var input = document.createElement("INPUT");
	      input.type = 'file';
	      input.id = 'ex_comp_foto_'+nuevoValor;
	      input.name = 'ex_comp_foto_'+nuevoValor;
	      seccion.appendChild(input);
	    }
  	}

  	function getExamanesComplementariosId(){
  		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;

  		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/get_examenes_complementarios_ultimo',
           data:{consulta:consulta, paciente:paciente, _token: '{{csrf_token()}}'},
           	success:function(data) {               	
           		if(data.response == 1) {           			           			
           			if(data.examenComplementario != null) {     
           			     			
           				document.getElementById("examenes_complementarios_id").value = data.examenComplementario.id;
           				document.getElementById("examenes_complementarios_solicito").value = data.examenComplementario.solicito;
           				document.getElementById("examenes_complementarios_respuesta").value = data.examenComplementario.respuesta;
           				var fecha_aux = data.examenComplementario.fechaSolicitud.split("-");
           				document.getElementById("examenes_complementarios_fecha_solicito").value = fecha_aux[2]+"/"+fecha_aux[1]+"/"+fecha_aux[0];           				
           			} else {
           				document.getElementById("examenes_complementarios_id").value = 0;
           			}
            	}
            }
        });		
  	}

  	function cargarFotoExamenComplementario(ex_compl_id){
  		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;
		//var ex_compl_id = document.getElementById("examenes_complementarios_id").value;					
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/get_fotos_examenes_complementarios',
           data:{consulta:consulta, paciente:paciente, ex_compl_id:ex_compl_id, _token: '{{csrf_token()}}'},
           	success:function(data) {              	           		
           		if(data.response == 1) {           		           		      			           			
           			// medico1/examenes_complementarios/7JddMlunI1SPXoVSZcv3sloguzyRpkgAWsbFk66c.jpeg           			
           			if(data.fotosExamenComplementario!=null && data.fotosExamenComplementario.foto.localeCompare('') != 0) {	
           			 	       		                
		                var imagen = document.getElementById("examenes_complementarios_foto");
		                $("#examenes_complementarios_foto").attr("src", "img/"+data.fotosExamenComplementario.foto);
						imagen.addEventListener("dblclick", function(e){
						  getFullscreen(this);
						},false);

		                /*var img = document.getElementById("examenes_complementarios_foto");		                
		                $("#examenes_complementarios_foto").attr("src", "img/"+data.fotosExamenComplementario.foto);
		                img.onclick = function() {                                                  
		                  onClickVer(data.fotosExamenComplementario.foto);
		                } */    
		                document.getElementById("examenes_complementarios_numero_foto").value = data.fotosExamenComplementario.numero;
		                var valorFoto = data.fotosExamenComplementario.numero+"/"+data.fotosExamenComplementario.numero;
	           			document.getElementById("examenes_complementarios_actual_cantidad_fotos").value = valorFoto;		                       		                
		              } else {		              			                		                
		                $("#examenes_complementarios_foto").attr("src", "");                
		                document.getElementById("examenes_complementarios_actual_cantidad_fotos").value = "0/0";
		              }
            	}            	
            }
        });		
  	}



  	function guardarExamenComplementario(){
  		var consulta = document.getElementById("consulta_id").value;
		var paciente = document.getElementById("paciente_id").value;
		var ex_compl_id = document.getElementById("examenes_complementarios_id").value;			
		var ex_compl_numero = document.getElementById("examenes_complementarios_numero").value;			
		var solicito = document.getElementById("examenes_complementarios_solicito").value;			
		var respuesta = document.getElementById("examenes_complementarios_respuesta").value;			
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/guardar_examenes_complementarios',
           data:{consulta:consulta, paciente:paciente, ex_compl_id:ex_compl_id,ex_compl_numero:ex_compl_numero, solicito:solicito, respuesta:respuesta, _token: '{{csrf_token()}}'},
           	success:function(data) {              	           		
           		if(data.response == 1){
           			var valor = data.examenesComplementarios.numero+"/"+data.cantidad;
           			document.getElementById("examenes_complementarios_actual_cantidad").value = valor;
         			document.getElementById("examenes_complementarios_id").value = data.examenesComplementarios.id;  			
           			mostrarSnackbar("EXAMENES COMPLEMENTARIOS GUARDADOS");
            	} else {
            		mostrarSnackbar("EXAMENES COMPLEMENTARIOS FALLO");
            	}
            }
        });	
  	}

  	function cargarExamenesComplementarios() {
		var paciente = document.getElementById("paciente_id").value;			
		$('#ex_comp_cantidad_fotos').val(1);
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_examenes_complementarios',
           data:{paciente:paciente ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.numero != null && data.response == 1){           			
           			document.getElementById("examenes_complementarios_numero").value = data.numero;
           			if(data.numero != 0){
           				document.getElementById("seccion_examenes_complementarios").hidden = false;	           			
	        			document.getElementById("examenes_complementarios_solicito").value = data.examenes_complementarios.solicito;	        			       	
						document.getElementById("examenes_complementarios_respuesta").value = data.examenes_complementarios.respuesta;
						var ex = document.getElementById("examenes_complementarios_id").value = data.examenes_complementarios.id;
						var valor = data.numero+"/"+data.numero;
	           			document.getElementById("examenes_complementarios_actual_cantidad").value = valor;		           			
	           			var valorFoto = data.numero_fotos+"/"+data.numero_fotos;
	           			document.getElementById("examenes_complementarios_actual_cantidad_fotos").value = valorFoto;		           			
	           			cargarFotoExamenComplementario(ex);
           			} 
           		}
            }
        });	
	}

	function examenesComplementariosAnteriorSiguiente(opcion){
		var ex_compl_id = document.getElementById("examenes_complementarios_id").value;
		var paciente = document.getElementById("paciente_id").value;	
		//var numero = document.getElementById("interconsulta_actual_cantidad").value;
		//var numero_aux = numero.split("/");
		//numero = parseInt(numero_aux[1]) - 1;	
		var numero_actual = document.getElementById("examenes_complementarios_numero").value;
		if(opcion == 1) // avanzo
			var numero = parseInt(numero_actual) + 1;
		else
			var numero = parseInt(numero_actual) - 1;
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_examenes_complementarios_ant_sig',
           data:{paciente:paciente ,numero:numero, ex_compl_id:ex_compl_id ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){           			
           			document.getElementById("examenes_complementarios_numero").value = data.examenesComplementarios.numero;
           			if(data.examenesComplementarios.numero != 0){
           				document.getElementById("examenes_complementarios_id").value = data.examenesComplementarios.id;
           				document.getElementById("examenes_complementarios_numero").value = data.examenesComplementarios.numero;
	        			document.getElementById("examenes_complementarios_solicito").value = data.examenesComplementarios.solicito;	        				        		
						document.getElementById("examenes_complementarios_respuesta").value = data.examenesComplementarios.respuesta
						var valor = data.examenesComplementarios.numero+"/"+data.numero;
	           			document.getElementById("examenes_complementarios_actual_cantidad").value = valor;		   				     
           		
           				cargarFotoExamenComplementario(data.examenesComplementarios.id);
           			}
           		}
            }
        });
	}

	function examenesComplementariosAnteriorSiguienteFoto(opcion){
		var paciente = document.getElementById("paciente_id").value;
		var ex_compl_id = document.getElementById("examenes_complementarios_id").value;			
		var numero_actual = document.getElementById("examenes_complementarios_numero_foto").value;
		if(opcion == 1) // avanzo
			var numero = parseInt(numero_actual) + 1;
		else
			var numero = parseInt(numero_actual) - 1;
		$.ajax({
           type:'POST',
           dataType:'JSON',
           url:'/cargar_examenes_complementarios_ant_sig_foto',
           data:{paciente:paciente, ex_compl_id:ex_compl_id ,numero:numero ,_token: '{{csrf_token()}}'},
           	success:function(data){              
           		if(data.response == 1){           			           			
           			if(data.examenComplementarioFoto.numero != 0){           				
           				document.getElementById("examenes_complementarios_numero_foto").value = data.examenComplementarioFoto.numero;
	        			        				        								
						var valor = data.examenComplementarioFoto.numero+"/"+data.tope;
	           			document.getElementById("examenes_complementarios_actual_cantidad_fotos").value = valor;		   			
           			}
           			if(data.examenComplementarioFoto.foto.localeCompare('') != 0) { 
           			               		                
		                var imagen = document.getElementById("examenes_complementarios_foto");
		                 $("#examenes_complementarios_foto").attr("src", "img/"+data.examenComplementarioFoto.foto);
						imagen.addEventListener("dblclick", function(e){
						  getFullscreen(this);
						},false);

		               /* var img = document.getElementById("examenes_complementarios_foto");		                		                
		                $("#examenes_complementarios_foto").attr("src", "img/"+data.examenComplementarioFoto.foto);
		                img.onclick = function() {                                                  

		                  onClickVer(data.examenComplementarioFoto.foto);
		                }                 		                */
		              } else {		              	
		                $("#examenes_complementarios_foto").attr("src", "");                
		              }
           		}
            }
        });
	}


	function getFullscreen(element){
	  if(element.requestFullscreen) {
	      element.requestFullscreen();
	    } else if(element.mozRequestFullScreen) {
	      element.mozRequestFullScreen();
	    } else if(element.webkitRequestFullscreen) {
	      element.webkitRequestFullscreen();
	    } else if(element.msRequestFullscreen) {
	      element.msRequestFullscreen();
	    }
	}

</script>