
@extends('plantillas/plantilla_medico')

@if($consulta != null && $consulta->activo == 2)
  @section('title_header','Nueva Consulta')
@else
  @section('title_header','Consulta')
@endif


@section('contenedor')

@include('modal.snackbar')

@if($consulta!=null)
  <input hidden class="form-control" type="text" name="consulta_id" id="consulta_id" value="{{$consulta->id}}" />   
@else
  <input hidden class="form-control" type="text" name="consulta_id" id="consulta_id" value="-1" />   
@endif

@if($paciente!=null)
  <input hidden class="form-control" type="text" name="paciente_id" id="paciente_id" value="{{$paciente->id}}" />   
@else
  <input hidden class="form-control" type="text" name="paciente_id" id="paciente_id" value="-1" />   
@endif
<input  class="form-control" type="text" name="es_nueva_consulta" id="es_nueva_consulta" value="{{$nueva_consulta}}" />   
<!--
<div class="row">
  <label class="label_text_size_1rem">DNI del Paciente:</label>
  @if($paciente != null )
    <input class="form-control input_width_150px" type="text" name="dni_paciente" id="dni_paciente" value="{{$paciente->dni}}" />   
  @else
	  <input class="form-control input_width_150px" type="text" name="dni_paciente" value="" /> 
  @endif
	<button onclick=""><img class="card-img-top img_icono_button" src="/img/iconos/buscar.png"/></button>      			    			 	  
</div> -->
<br>
<ul class="nav nav-tabs letrasblancas">
  <li class="nav-item">
    <a id="datos_a" onclick="getDatos()" type="button" class="nav-link nav_seleccionado">Datos</a>
  </li>
  <li class="nav-item">
    <a id="antecedentes_perinatales_a" onclick="getAntecedentesPerinatales()" type="button" class="nav-link nav_no_seleccionado">Antec. Perinatales</a>
  </li>
  <li class="nav-item">
    <a id="antecedentes_neonatales_patologicos_a" onclick="getAntecedentesNeonatales()" type="button" class="nav-link nav_no_seleccionado">Antec. Neonatales Patologicos</a>
  </li>
  <li class="nav-item">
    <a id="antecedentes_personales_a" onclick="getAntecedentesPersonales()" type="button" class="nav-link nav_no_seleccionado">Antec. Personales</a>
  </li>
  <li class="nav-item">
    <a id="antecedentes_familiares_a" onclick="getAntecedentesFamiliares()" type="button" class="nav-link nav_no_seleccionado">Antec. Familiares</a>
  </li>
</ul>
<div id="seccion_datos_paciente">
  @include('medico.seccion.info_paciente')
</div>

<div id="seccion_antecedentes_perinatales" hidden>
  @include('medico.seccion.antecedentes_perinatales')
</div>

<div id="seccion_antecedentes_neonatales" hidden>
  @include('medico.seccion.antecedentes_neonatales_patologicos')
</div>

<div id="seccion_antecedentes_personales" hidden>
  @include('medico.seccion.antecedentes_personales')
</div>

<div id="seccion_antecedentes_familiares" hidden>
  @include('medico.seccion.antecedentes_familiares')
</div>
<br>
<div class="row contenedor3">
    <button onclick="guardarDatos()" class="rodri_button contenido3">GUARDAR</button>
</div>
<br>
@include('medico.seccion.vacunas')
<br>
@include('medico.seccion.alimentacion')
<br>
@include('medico.seccion.escolaridad')
<br>
@include('medico.seccion.actividades_extra_escolares')
<br>
@include('medico.seccion.pantallas')
<br>
@include('medico.seccion.habitos')
<br>
@include('medico.seccion.menarca')
<br>
@include('medico.seccion.examen_fisico')
<br>
@include('medico.seccion.examenes_complementarios')
<br>
@include('medico.seccion.interconsulta')
<br>
@include('medico.seccion.conductas')
<br>

@include('modal.modal_pendientes')

<div class="row contenedor3">
  <div class="contenido3">
    <button onclick="guardarDatosDos()" class="rodri_button">GUARDAR</button>    
    <button type="button" onclick="guardarPendientesModal()" class="rodri_button margin_left_60px">PENDIENTES</button>
  </div>
</div>
<br>
<script type="text/javascript">
  
  function getDatos(){
    ocultarPaneles();    
    document.getElementById("seccion_datos_paciente").hidden = false;  
    var a = document.getElementById("datos_a");
    a.setAttribute('class', 'nav-link nav_seleccionado');
  }

  function getAntecedentesPerinatales(){
    ocultarPaneles();    
    document.getElementById("seccion_antecedentes_perinatales").hidden = false;
    var a = document.getElementById("antecedentes_perinatales_a");
    a.setAttribute('class', 'nav-link nav_seleccionado');
  }

  function getAntecedentesNeonatales(){
    ocultarPaneles();    
    document.getElementById("seccion_antecedentes_neonatales").hidden = false;
    var a = document.getElementById("antecedentes_neonatales_patologicos_a");
    a.setAttribute('class', 'nav-link nav_seleccionado');        
  }

  function getAntecedentesPersonales(){
    ocultarPaneles();    
    document.getElementById("seccion_antecedentes_personales").hidden = false;
    var a = document.getElementById("antecedentes_personales_a");
    a.setAttribute('class', 'nav-link nav_seleccionado'); 
  }

  function getAntecedentesFamiliares(){
    ocultarPaneles();    
    document.getElementById("seccion_antecedentes_familiares").hidden = false;
    var a = document.getElementById("antecedentes_familiares_a");
    a.setAttribute('class', 'nav-link nav_seleccionado'); 
  }

  function ocultarPaneles(){
    document.getElementById("seccion_datos_paciente").hidden = true;
    var datos_a = document.getElementById("datos_a");
    datos_a.setAttribute('class', 'nav-link nav_no_seleccionado');

    document.getElementById("seccion_antecedentes_perinatales").hidden = true;
    var antecedentes_perinatales_a = document.getElementById("antecedentes_perinatales_a");
    antecedentes_perinatales_a.setAttribute('class', 'nav-link nav_no_seleccionado');        

    document.getElementById("seccion_antecedentes_neonatales").hidden = true;
    var antecedentes_neonatales_patologicos_a = document.getElementById("antecedentes_neonatales_patologicos_a");
    antecedentes_neonatales_patologicos_a.setAttribute('class', 'nav-link nav_no_seleccionado');    

    document.getElementById("seccion_antecedentes_personales").hidden = true;
    var antecedentes_personales_a = document.getElementById("antecedentes_personales_a");
    antecedentes_personales_a.setAttribute('class', 'nav-link nav_no_seleccionado');    

    document.getElementById("seccion_antecedentes_familiares").hidden = true;
    var antecedentes_familiares_a = document.getElementById("antecedentes_familiares_a");
    antecedentes_familiares_a.setAttribute('class', 'nav-link nav_no_seleccionado');    
  }

  function guardarDatos(){
    guardarAntecedentesPerinatales();
    guardarAntecedentesPersonales();
    guardarAntecedentesFamiliares();   
    guardarNotaAntecedentesNeonantales(); 
    mostrarSnackbar("DATOS GUARDADOS");       
  }

  function guardarDatosDos(){
    guardarEscolaridad();
    guardarActividadesExtraEscolares();
    guardarPantallas();
    guardarHabitos();
    guardarMenarca();
    guardarConductas();
    guardarAlimentacion();
    guardarExamenFisico();

    establecerActivo();
  }

  function establecerActivo(){
    var consulta_id = document.getElementById("consulta_id").value;
    var paciente_id = document.getElementById("paciente_id").value;        
    $.ajax({
             type:'POST',
             dataType:'JSON',
             url:'/establecer_activo',
             data:{paciente_id:paciente_id, consulta_id:consulta_id, _token: '{{csrf_token()}}'},
             success:function(data) { 
                mostrarSnackbar("CONSULTA GUARDADA");       
              }
          });     
  }

  function mostrarConsulta(){
    cargarEscolaridad();
    cargarActividadesExtraEscolares();
    cargarPantallas();
    cargarHabitos();
    cargarConductas();
    cargarExamenFisico();
    cargarAlimentacion();
    cargarMenarca();
    cargarAntecedentesPerinatales();
    cargarAntecedentesPersonales();
    cargarAntecedentesFamiliares();
    cargarAntecedentesNeonatales();
    cargarInterconsulta();
    cargarExamenesComplementarios();

    mostrarSnackbar("CONSULTA CARGADA");     
  }



  window.onload=function() {        
    var esNuevaConsulta = document.getElementById("es_nueva_consulta").value;
    if(esNuevaConsulta == 1){
      getExamanesComplementariosId();
      inicializarAntecedentesNeonatales();
      checkPendientes();
    } else {
      var consulta = document.getElementById("consulta_id");    
      if(consulta != null && consulta.value != null){
        var consulta_id = consulta.value;
        $.ajax({
               type:'POST',
               dataType:'JSON',
               url:'/check_consulta_existe',
               data:{consulta_id:consulta_id, _token: '{{csrf_token()}}'},
               success:function(data) {                 
                  if(data.response == 1){
                    mostrarConsulta();
                    inicializarAntecedentesNeonatales();
                  } else { 
                    if(data.response == 0){
                      getExamanesComplementariosId();
                      inicializarAntecedentesNeonatales();              
                  } else {
                    mostrarSnackbar("ERROR");    
                  }
               }
             }
            });     
      }
    }
  }

</script>



@endsection