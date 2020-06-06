<form class="card background_panel">
	<div class="row">                      
		  @csrf
		<div class="row">
			  <div class="margin_left_20px">
				  	<small>DNI</small>      
				   	@if($paciente != null && $paciente->dni != null)
				   		<input type="text" class="form-control input_width_150px" id="dni" name="dni" placeholder="DNI" value="{{$paciente->dni}}" readonly/>
				   	@else
				   		<input type="text" class="form-control input_width_150px" id="dni" name="dni" placeholder="DNI" value="" readonly/>
				   	@endif
			  </div>

			  <div class="margin_left_20px">
				  <small>Nombre</small>      
				  @if($paciente != null && $paciente->nombre != null)
				  	<input type="text" class="form-control input_width_250px" id="nombre" name="nombre" value="{{$paciente->nombre}}" readonly/>
				  @else
				  	<input type="text" class="form-control input_width_250px" id="nombre" name="nombre"  placeholder="Nombre Paciente" value="" readonly />
				  @endif
			  </div>

			  <div class="margin_left_20px">
				  <small>Apellido</small>      
				  @if($paciente != null && $paciente->apellido != null)
				  	<input type="text" class="form-control input_width_250px" id="apellido" name="apellido"  value="{{$paciente->apellido}}" readonly/>
				  @else
				  	<input type="text" class="form-control input_width_250px" id="apellido" name="apellido"  placeholder="Apellido Paciente" readonly/>
				  @endif
			  </div>

			  <div class="margin_left_20px">
			  	  <small>Fecha Nacimiento</small>
			  	  @if($paciente != null && $paciente->fecha_nacimiento != null)
				  	<input type="text" class="form-control input_width_250px" id="fecha_nacimiento" name="fecha_nacimiento"  value="{{$paciente->fecha_nacimiento}}" readonly />
				  @else      
				  <input type="text" class="form-control input_width_150px" id="fecha_nacimiento" name="fecha_nacimiento"  placeholder="Fecha Nac." readonly/>
				  @endif
			 </div>

			 <div class="margin_left_20px">
				  <small>Sexo</small>      
				  @if($paciente != null && $paciente->sexo != null)
				  	<div class="row">
				  	<div class="custom-control custom-radio">
				  		@if($paciente != null && $paciente->sexo == "M")
				  			<input type="radio" id="sexo_m" name="sexo" class="custom-control-input" checked readonly>
				  		@else
				  			<input type="radio" id="sexo_m" name="sexo" class="custom-control-input" readonly>
				  		@endif
				  		<label class="custom-control-label" for="sexo_m">M</label>
					</div>
					<div class="custom-control custom-radio">
						 @if($paciente != null && $paciente->sexo == "F")
						 	<input type="radio" id="sexo_f" name="sexo" class="custom-control-input" checked readonly>
						 @else
						 	<input type="radio" id="sexo_f" name="sexo" class="custom-control-input" readonly>
						 @endif
						 <label class="custom-control-label margin_left_5px" for="sexo_f">F</label>
					</div>
				   </div>
				  @else
				  <div class="row">
				  	<div class="custom-control custom-radio">
				  		<input type="radio" id="sexo_m" name="sexo" class="custom-control-input" readonly>
				  		<label class="custom-control-label" for="sexo_m">M</label>
					</div>
					<div class="custom-control custom-radio">
						 <input type="radio" id="sexo_f" name="sexo" class="custom-control-input" readonly>
						 <label class="custom-control-label margin_left_5px" for="sexo_f">F</label>
					</div>
				   </div>
				   @endif				
			  </div>

			 <div class="margin_left_20px">	  
			 	 <small>Hermanos</small> 
			 	 @if($paciente != null && $paciente->cantidad_hermanos != null)     
			  	 	<input type="text" class="form-control input_width_50px" id="hermanos" name="hermanos" value="{{$paciente->cantidad_hermanos}}" readonly />        
			  	 @else
			  		<input type="text" class="form-control input_width_50px" id="hermanos" name="hermanos" placeholder="0" readonly />        
			     @endif
			 </div>

		</div>

		<div class="row">
			 <div class="margin_left_20px">
			  <small>Localidad</small>     
			  @if($paciente != null && $paciente->localidad != null)   
			  	<input type="text" class="form-control input_width_350px" id="localidad" name="localidad"  value="{{$paciente->localidad}}" readonly />
			  @else
			  	<input type="text" class="form-control input_width_350px" id="localidad" name="localidad"  placeholder="Localidad"  readonly/>
			  @endif
			</div>

			<div class="margin_left_20px">
			  <small>Domicilio</small>   
			   @if($paciente != null && $paciente->domicilio != null)     
			   	<input type="text" class="form-control input_width_350px" id="domicilio" name="domicilio"  value="{{$paciente->domicilio}}"  readonly/>
			   @else
			  	<input type="text" class="form-control input_width_350px" id="domicilio" name="domicilio"  placeholder="Domicilio" readonly />
			  @endif
			</div>
			
			<div class="margin_left_20px">
			  <small>Mail</small>      
			  @if($paciente != null && $paciente->mail != null)     
			  	<input type="text" class="form-control input_width_350px" id="mail" name="mail" value="{{$paciente->mail}}" readonly />
			  @else
			  	<input type="text" class="form-control input_width_350px" id="mail" name="mail" placeholder="Mail" readonly />
			  @endif
			</div>
		</div>

		<div class="row">
			<div class="margin_left_20px">
			  <small>Telefono</small>      
			  @if($paciente != null && $paciente->telefono != null)     
			  	<input type="text" class="form-control input_width_150px" id="telefono" name="telefono"  value="{{$paciente->telefono}}" readonly />
			  @else
			   <input type="text" class="form-control input_width_150px" id="telefono" name="telefono"  placeholder="Telefono" readonly />
			  @endif
			</div>

			 <div class="margin_left_20px">  
			  <small>Nombre Madre</small>
			  @if($paciente != null && $paciente->nombre_madre != null)     
			 	<input type="text" class="form-control input_width_250px" id="nombre_madre" name="nombre_madre" value="{{$paciente->nombre_madre}}" readonly />
			  @else      
			  	<input type="text" class="form-control input_width_250px" id="nombre_madre" name="nombre_madre" placeholder="Nombre Madre" readonly />
			  @endif
			</div>

			<div class="margin_left_20px">
			  <small>Nombre Padre</small>      
			  @if($paciente != null && $paciente->nombre_padre != null)     
			  	<input type="text" class="form-control input_width_250px" id="nombre_padre" name="nombre_padre" value="{{$paciente->nombre_padre}}" readonly />
			  @else
			 	 <input type="text" class="form-control input_width_250px" id="nombre_padre" name="nombre_padre" placeholder="Nombre Padre" readonly />
			  @endif
			</div>	  	     

		</div>

		<div class="row">
			<div class="margin_left_20px">
			  <small>Obra Social</small>      
			  @if($paciente != null && $paciente->obra_social != null)    
			  	<input type="text" class="form-control" id="obrasocial" name="obra_social" value="{{$paciente->obra_social}}" readonly />
			  @else
			  	<input type="text" class="form-control" id="obrasocial" name="obra_social" placeholder="Obra Social" readonly />
			  @endif
			</div>

			<div class="margin_left_20px">
			  <small>N°Afiliado</small>      
			  @if($paciente != null && $paciente->numero_afiliado != null)    
			  	<input type="text" class="form-control" id="numero_afiliado" name="numero_afiliado" value="{{$paciente->numero_afiliado}}" readonly />
			  @else
			  	<input type="text" class="form-control" id="numero_afiliado" name="numero_afiliado" placeholder="N° Afiliado" readonly />
			  @endif
			</div>  

			<div class="margin_left_20px">
			  <small>Tipo Plan</small>      
			  @if($paciente != null && $paciente->obra_social_plan != null)    
			  	<input type="text" class="form-control" id="plan_obra_social" name="plan_obra_social" value="{{$paciente->obra_social_plan}}" readonly />
			  @else
			  	<input type="text" class="form-control" id="plan_obra_social" name="plan_obra_social" placeholder="Plan Obra Social"readonly  />
			  @endif
			</div>	   	
		</div>
	</div>

</form>


