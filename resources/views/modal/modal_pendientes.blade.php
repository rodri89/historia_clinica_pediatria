<div class="modal fade" id="modalPendientes" 
     tabindex="-1" role="dialog" 
     aria-labelledby="favoritesModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     
      <div class="modal-header">      	
        <h4 class="modal-title"         
        id="modalTitleMensaje">Pendientes</h4>
      </div>      
       
      <div class="modal-body">       	
        <p>Ingrese información pendiente:.</p>
        <textarea  id="nueva_consulta_pendiente" name="nueva_consulta_pendiente" rows="10" cols="50"></textarea>
        <br>
        <small>Esta información será recordad al abrir una nueva consulta.</small>
      </div>
      
      <div class="modal-footer">
        <button hidden id="modal_pendiente_aceptar" type="button" 
           class="rodri_button_aceptar" 
           data-dismiss="modal">Aceptar</button>        
        <button id="modal_pendiente_cancelar" type="button" 
           class="rodri_button_cancelar" 
           data-dismiss="modal">Cancelar</button>        
        <button id="modal_pendiente_guardar" type="button"
           onclick="guardarPendiente()"
           class="rodri_button_aceptar" 
           data-dismiss="modal">Guardar</button>        
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">
  function guardarPendientesModal() {    
    $('#modalPendientes').modal(); 
  }

  function guardarPendiente(){
    var consulta_id = document.getElementById("consulta_id").value;
    var paciente_id = document.getElementById("paciente_id").value; 
    var pendiente = document.getElementById("nueva_consulta_pendiente").value;
    $.ajax({
         type:'POST',
         dataType:'JSON',
         url:'/guardar_pendientes',
         data:{paciente_id:paciente_id, consulta_id:consulta_id, pendiente:pendiente, _token: '{{csrf_token()}}'},
         success:function(data) { 
          if(data.response_data != null)
              mostrarSnackbar("PENDIENTES GUARDADOS");       
          }
      }); 
  }

  function checkPendientes(){
      var consulta_id = document.getElementById("consulta_id").value;
      var paciente_id = document.getElementById("paciente_id").value;       
      $.ajax({
         type:'POST',
         dataType:'JSON',
         url:'/cargar_pendientes',
         data:{paciente_id:paciente_id, consulta_id:consulta_id, _token: '{{csrf_token()}}'},
         success:function(data) { 
            if(data.response_data != null) {
              $('#nueva_consulta_pendiente').val(data.response_data.pendientes);
              document.getElementById("modal_pendiente_guardar").hidden = true;
              document.getElementById("modal_pendiente_cancelar").hidden = true;
              document.getElementById("modal_pendiente_aceptar").hidden = false;              
              $('#modalPendientes').modal();
            } 
          }
      }); 
  }
</script>