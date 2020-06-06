<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Paciente;
use App\Consulta;
use App\AntecedentesPerinatales;
use App\AntecedentesPersonales;
use App\AntecedentesFamiliares;
use App\Escolaridad;
use App\ActividadesExtraEscolares;
use App\Pantalla;
use App\Habitos;
use App\Menarca;
use App\Conducta;
use App\Alimentacion;
use App\ExamenFisico;
use App\Interconsulta;
use Image;
use App\ExamenesComplementarios;
use App\ExamenesComplementariosFotos;
use App\AntecedentesNeonatales;
use App\AntecedentesNeonatalesFotos;
use App\VacunasPacientes;
use App\Vacunas;
use App\MedicoInfo;
use App\Interconsultores;
use App\AuxPendiente;

class MedicoController extends Controller
{

    function guardarVacunaOtraPaciente(Request $request){
        $vacuna_id = $request->vacuna_id;        
        $edad_meses = $request->edadMeses;
        $estado = 1;
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;
        $vacunaViewId = $request->vacunaViewId;
        $otra = $request->otra;

        $vacunaPaciente = $this->checkExisteVacuna($paciente_id, $vacuna_id, $edad_meses);            
        if($vacunaPaciente != null){            
            $vacunaPaciente->estado = $estado;
            $vacunaPaciente->nombre = $otra;
            $vacunaPaciente->activo = 1;
            $vacunaPaciente->save();
        } else {
            $vacuna =  Vacunas::find($vacuna_id);                       
            $vacunaPaciente = new VacunasPacientes;
            $vacunaPaciente->paciente_id = $paciente_id;
            $vacunaPaciente->vacuna_id = $vacuna_id;
            $vacunaPaciente->nombre = $otra;
            $vacunaPaciente->edad_meses = $edad_meses;
            $vacunaPaciente->estado = $estado;
            $vacunaPaciente->vacuna_view_id = $vacunaViewId;
            $vacunaPaciente->activo = 1;
            $vacunaPaciente->save();
        }
        
        return response()->json(array('response'=>1, 'request'=>$vacuna_id));        
    }

    function crearVacunasPaciente($paciente_id) {
       $vacunasPaciente = DB::table('vacunas_pacientes')
                                ->where('vacunas_pacientes.paciente_id', $paciente_id)
                                ->where(function ($query) {
                                         $query->where('vacunas_pacientes.activo', 1)
                                               ->orWhere('vacunas_pacientes.activo', 2);
                                    })                                                                            
                                ->first();
        if($vacunasPaciente == null) {
             $vacunas = DB::table('vacunas')                                
                                ->where('vacunas.activo', 1)                                               
                                ->get();
            foreach($vacunas as $v){
                $vacunaPacienteNueva = new VacunasPacientes;
                $vacunaPacienteNueva->paciente_id = $paciente_id;
                $vacunaPacienteNueva->vacuna_id = $v->id;
                $vacunaPacienteNueva->nombre = $v->nombre;
                $vacunaPacienteNueva->edad_meses = 0;
                $vacunaPacienteNueva->estado = 0;
                $vacunaPacienteNueva->activo = 1;
                $vacunaPacienteNueva->save();    
            }
        }
    }

    function getVacunasPaciente($paciente_id){
        $vacunasPaciente = DB::table('vacunas_pacientes')
                                ->where('vacunas_pacientes.paciente_id', $paciente_id)
                                 ->where(function ($query) {
                                         $query->where('vacunas_pacientes.activo', 1)
                                               ->orWhere('vacunas_pacientes.activo', 2);
                                    })                                                 
                                ->get();
        return $vacunasPaciente;
    }

    function guardarVacunaPaciente(Request $request){
        $vacuna_id = $request->vacuna_id;        
        $edad_meses = $request->edadMeses;
        $estado = $request->estado;
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;
        $vacunaViewId = $request->vacunaViewId;

        $vacunaPaciente = $this->checkExisteVacuna($paciente_id, $vacuna_id, $edad_meses);            
        if($vacunaPaciente != null){            
            $vacunaPaciente->estado = $estado;
            $vacunaPaciente->activo = 1;
            $vacunaPaciente->save();
        } else {
            $vacuna =  Vacunas::find($vacuna_id);                       
            $vacunaPaciente = new VacunasPacientes;
            $vacunaPaciente->paciente_id = $paciente_id;
            $vacunaPaciente->vacuna_id = $vacuna_id;
            $vacunaPaciente->nombre = $vacuna->nombre;
            $vacunaPaciente->edad_meses = $edad_meses;
            $vacunaPaciente->estado = $estado;
            $vacunaPaciente->vacuna_view_id = $vacunaViewId;
            $vacunaPaciente->activo = 1;
            $vacunaPaciente->save();
        }
        
        return response()->json(array('response'=>1, 'request'=>$vacuna_id));        
    }

    function checkExisteVacuna($paciente_id, $vacuna_id, $meses){
        $vacunasPaciente = DB::table('vacunas_pacientes')
                                ->where('vacunas_pacientes.paciente_id', $paciente_id)
                                ->where('vacunas_pacientes.vacuna_id', $vacuna_id)
                                ->where('vacunas_pacientes.edad_meses', $meses)
                                ->where(function ($query) {
                                         $query->where('vacunas_pacientes.activo', 1)
                                               ->orWhere('vacunas_pacientes.activo', 2);
                                    })                                   
                                ->first();
        if($vacunasPaciente != null)
             $vacunasPaciente = VacunasPacientes::find($vacunasPaciente->id);                       
        return $vacunasPaciente;
    }

    function cargarVacunaPaciente(Request $request){
        $vacunaPaciente = $this->getVacunasPaciente($request->paciente);
        return response()->json(array('response'=>1, 'vacunaPaciente'=>$vacunaPaciente));        
    }

    function nuevaConsultaPaciente(){
           return view('medico.nueva');
    }

    function nuevaConsultaPacienteListadoBuscar(){
        $user=\Auth::user();        
        if($user->usuario_tipo == 2){      
            $users = DB::table('pacientes')                                
                                ->join('medico_pacientes','medico_pacientes.paciente_id','=','pacientes.id')                        
                                ->select('pacientes.*')                                
                                ->where('medico_pacientes.medico_user_id',$user->id)                                                       
                                ->where('pacientes.activo', 1) 
                                ->where('medico_pacientes.activo', 1)                                 
                                ->distinct()
                                ->orderby('pacientes.apellido');        
        } else {
            if($user->usuario_tipo == 3){      
                $users = DB::table('pacientes')             
                                ->join('medico_pacientes','medico_pacientes.paciente_id','=','pacientes.id')
                                ->join('medico_secretarias','medico_secretarias.medico_user_id','=','medico_pacientes.medico_user_id')                                
                                ->select('pacientes.*')                                                                
                                ->where('medico_secretarias.secretaria_user_id', $user->id) 
                                ->where('pacientes.activo', 1) 
                                ->where('medico_pacientes.activo', 1)
                                ->where('medico_secretarias.activo', 1)   
                                ->distinct()                              
                                ->orderby('pacientes.apellido');            
            }
        }
        
        return datatables()->of($users)
                           ->addIndexColumn()
                           ->addColumn('action', function($row){                                   
                               $val = $row->id;
                               $btn = "<button onclick=navegarNuevaConsulta($val) class='rodri_button_aceptar_si'>></button>";
                               /*$btn = "<form method='POST' action='{{ route('nuevaconsulta') }}'>
                                        @csrf                           
                                        <button class='rodri_button_aceptar_si' type='submit'>></button>                                        
                                        </form>";*/
                               return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
    }

    function consultaGet($paciente, $consulta){                
        $_paciente = paciente::find($paciente);
        if($consulta == null){
            if($_paciente != null){
                $consultaAbierta = $this->checkConsultaAbierta($paciente);
                if( $consultaAbierta == null){
                    $_consulta = new Consulta;
                    $_consulta->paciente_id = $paciente;
                    $_consulta->activo = 2;
                    $_consulta->save();
                } else {
                    $_consulta = $consultaAbierta;
                }
            } else {
                $_consulta = null;
            }
        } else {
            $_consulta = Consulta::find($consulta);
        }

         return view('medico.nueva_consulta')
                    ->with('nueva_consulta', 0)
                    ->with('consulta',$_consulta)                
                    ->with('paciente',$_paciente);                
    }

    function nuevaConsulta(Request $request){
        if($request->paciente_id != null){
        	$paciente_id = $request->paciente_id;
        	$paciente = paciente::find($paciente_id);
        	if($paciente != null) {
                $consultaAbierta = $this->checkConsultaAbierta($paciente_id);
                if( $consultaAbierta == null){
            		$consulta = new Consulta;
            		$consulta->paciente_id = $paciente->id;
            		$consulta->activo = 2;
            		$consulta->save();
                } else {
                    $consulta = $consultaAbierta;
                }
        	} else {
        		$consulta = null;
        	}
        } else {
            $paciente = null;
            $consulta = null;
        }
        
        //$this->crearVacunasPaciente($paciente_id);
    	//$vacunasPaciente = $this->getVacunasPaciente($paciente_id);

        return view('medico.nueva_consulta')
    	 			->with('nueva_consulta', 1)
                    ->with('consulta',$consulta)                                    
    	 			->with('paciente',$paciente);                
    }

    // se considera consulta abierta aquella que tenga activo = 2
    function checkConsultaAbierta($paciente_id){
        $consultaActiva = DB::table('consultas')
                                    ->where('consultas.paciente_id', $paciente_id)
                                    ->where('consultas.activo', 2)                                               
                                    ->first();
        return $consultaActiva;
    }

    function interconsultores(){
    	return view('medico.interconsultores');
    }

    function listadoPacientesDia(){
    	$listadoPacientesDia = DB::table('pacientes')                                               
                    		 			->get();
    	return view('medico.listado_pacientes_dia')->with('listadoPacientes', $listadoPacientesDia);
    }

    function guardarAntecedentesPerinatales(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;
        if($this->existeAntecedentePerinatal($consulta_id, $paciente_id) == null) { 
            $antecedentesPerinatales = new AntecedentesPerinatales;
        } else {
            $antecedentesPerinatales_aux = $this->existeAntecedentePerinatal($consulta_id, $paciente_id);
            $antecedentesPerinatales = AntecedentesPerinatales::find($antecedentesPerinatales_aux->id);
        }
            
        $antecedentesPerinatales->consulta_id = $consulta_id;
        $antecedentesPerinatales->paciente_id = $paciente_id;
        $antecedentesPerinatales->embarazo = $request->embarazo;
        
        if($request->embarazo_numero_controles != null)
            $antecedentesPerinatales->embarazo_controles = $request->embarazo_numero_controles;
        else
            $antecedentesPerinatales->embarazo_controles = 0;

        $antecedentesPerinatales->patologias = $request->patologia;
        if($request->patologias_detalle != null)
            $antecedentesPerinatales->patologias_detalle = $request->patologias_detalle;
        else
            $antecedentesPerinatales->patologias_detalle = "";
       
        $antecedentesPerinatales->parto = $request->parto;

        if($request->parto_detalle != null)
            $antecedentesPerinatales->parto_detalle = $request->parto_detalle;
        else
            $antecedentesPerinatales->parto_detalle = "";

        if($request->eg != null)
            $antecedentesPerinatales->eg = $request->eg;
        else
            $antecedentesPerinatales->eg = "";

        if($request->peso != null)
            $antecedentesPerinatales->peso = $request->peso;
        else
            $antecedentesPerinatales->peso = "";

        if($request->talla != null)
            $antecedentesPerinatales->talla = $request->talla;
        else
            $antecedentesPerinatales->talla = "";

        if($request->pc != null)
            $antecedentesPerinatales->pc = $request->pc;
        else
            $antecedentesPerinatales->pc = "";

        if($request->apgar != null)
            $antecedentesPerinatales->apgar = $request->apgar;
        else
            $antecedentesPerinatales->apgar = "";

        if($request->caida_cordon != null)
            $antecedentesPerinatales->caida_cordon = $request->caida_cordon;
        else
            $antecedentesPerinatales->caida_cordon = 0;

        if($request->meconio != null)
            $antecedentesPerinatales->meconio = $request->meconio;
        else
            $antecedentesPerinatales->meconio = 0;

         if($request->gyf != null)
            $antecedentesPerinatales->gyf = $request->gyf;
        else
            $antecedentesPerinatales->gyf = "";

        $antecedentesPerinatales->fei = $request->fei;
        if($request->fei_anormal_detalle != null)
            $antecedentesPerinatales->fei_anormal_detalle = $request->fei_anormal_detalle;
        else
            $antecedentesPerinatales->fei_anormal_detalle = "";

        $antecedentesPerinatales->oea = $request->oea;
        $antecedentesPerinatales->activo = 1; // quiere decir que todavia no esta confirmado
        $antecedentesPerinatales->save();

        return response()->json(array('response'=>1, 'request'=>$request));
        
    }    

    function existeAntecedentePerinatal($consulta_id, $paciente_id){
        $antecedentePerinatal = DB::table('antecedentes_perinatales')                                    
                                    ->where('antecedentes_perinatales.paciente_id', $paciente_id)
                                     ->where(function ($query) {
                                         $query->where('antecedentes_perinatales.activo', 1)
                                               ->orWhere('antecedentes_perinatales.activo', 2);
                                    })                           
                                    ->first();
        return $antecedentePerinatal;
    }

    function guardarAntecedentesPersonales(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;

        if($this->existeAntecedentesPersonales($consulta_id, $paciente_id) == null) { 
            $antecedentesPersonales = new AntecedentesPersonales;
        } else {
            $antecedentesPersonales_aux = $this->existeAntecedentesPersonales($consulta_id, $paciente_id);
            $antecedentesPersonales = AntecedentesPersonales::find($antecedentesPersonales_aux->id);
        }

        $antecedentesPersonales->consulta_id = $consulta_id;
        $antecedentesPersonales->paciente_id = $paciente_id;

        if($request->enfermedad_actual != null)
            $antecedentesPersonales->enfermedad_actual = $request->enfermedad_actual;
        else
            $antecedentesPersonales->enfermedad_actual = "";

        if($request->enfermedad_actual != null)
            $antecedentesPersonales->enfermedad_actual = $request->enfermedad_actual;
        else
            $antecedentesPersonales->enfermedad_actual = "";

        $antecedentesPersonales->internaciones = $request->internaciones;
        if($request->internaciones_motivo != null)
            $antecedentesPersonales->internacion_motivo = $request->internaciones_motivo;
        else
            $antecedentesPersonales->internacion_motivo = "";

        if($request->interanaciones_lugar != null)
            $antecedentesPersonales->internacion_lugar = $request->interanaciones_lugar;
        else
            $antecedentesPersonales->internacion_lugar = "";

        if($request->interanaciones_duracion != null)
            $antecedentesPersonales->internacion_duracion = $request->interanaciones_duracion;
        else
            $antecedentesPersonales->internacion_duracion = "";

        if($request->interanaciones_indicacion_alta != null)
            $antecedentesPersonales->internacion_indicacion_alta = $request->interanaciones_indicacion_alta;
        else
            $antecedentesPersonales->internacion_indicacion_alta = "";

        $antecedentesPersonales->alergias = $request->alergias;
        if($request->alergia_detalle != null)
            $antecedentesPersonales->alergia_detalle = $request->alergia_detalle;
        else
            $antecedentesPersonales->alergia_detalle = "";       

        $antecedentesPersonales->qx = $request->qx;
        if($request->qx_detalle != null)
            $antecedentesPersonales->qx_detalle = $request->qx_detalle;
        else
            $antecedentesPersonales->qx_detalle = "";               

        $antecedentesPersonales->traumatismos = $request->traumatismo;
        if($request->traumatismo_detalle != null)
            $antecedentesPersonales->traumatismos_detalle = $request->traumatismo_detalle;
        else
            $antecedentesPersonales->traumatismos_detalle = "";                

        $antecedentesPersonales->transfusiones = $request->transfusiones;
        if($request->transfusiones_detalle != null)
            $antecedentesPersonales->transfusiones_detalle = $request->transfusiones_detalle;
        else
            $antecedentesPersonales->transfusiones_detalle = "";               

        $antecedentesPersonales->activo = 1; // quiere decir que todavia no esta confirmado
        $antecedentesPersonales->save();

        return response()->json(array('response'=>1, 'request'=>$request));

    }

   function existeAntecedentesPersonales($consulta_id, $paciente_id){
        $antecedentesPersonales = DB::table('antecedentes_personales')
                                ->where('antecedentes_personales.consulta_id', $consulta_id)
                                ->where('antecedentes_personales.paciente_id', $paciente_id)
                                ->where(function ($query) {
                                     $query->where('antecedentes_personales.activo', 1)
                                           ->orWhere('antecedentes_personales.activo', 2);
                                })                                    
                                ->first();
        return $antecedentesPersonales;
    }

    function guardarAntecedentesFamiliares(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;

        if($this->existeAntecedentesFamiliares($consulta_id, $paciente_id) == null) { 
            $antecedentesFamiliares = new AntecedentesFamiliares;
        } else {
            $antecedentesFamiliares_aux = $this->existeAntecedentesFamiliares($consulta_id, $paciente_id);
            $antecedentesFamiliares = AntecedentesFamiliares::find($antecedentesFamiliares_aux->id);
        }

        $antecedentesFamiliares->consulta_id = $consulta_id;
        $antecedentesFamiliares->paciente_id = $paciente_id;

        $antecedentesFamiliares->hta = $request->hta;
        if($request->hta_detalle != null)
            $antecedentesFamiliares->hta_detalle = $request->hta_detalle;
        else
            $antecedentesFamiliares->hta_detalle = "";

        $antecedentesFamiliares->dbt = $request->dbt;
        if($request->dbt_detalle != null)
            $antecedentesFamiliares->dbt_detalle = $request->dbt_detalle;
        else
            $antecedentesFamiliares->dbt_detalle = "";

        $antecedentesFamiliares->asma = $request->asma;
        if($request->asma_detalle != null)
            $antecedentesFamiliares->asma_detalle = $request->asma_detalle;
        else
            $antecedentesFamiliares->asma_detalle = "";

        $antecedentesFamiliares->alergia = $request->alergia;
        if($request->alergia_detalle != null)
            $antecedentesFamiliares->alergia_detalle = $request->alergia_detalle;
        else
            $antecedentesFamiliares->alergia_detalle = "";

        $antecedentesFamiliares->enf_cv = $request->enf_cv;
        if($request->enf_cv_detalle != null)
            $antecedentesFamiliares->enf_cv_detalle = $request->enf_cv_detalle;
        else
            $antecedentesFamiliares->enf_cv_detalle = "";

        $antecedentesFamiliares->muerte_subita = $request->muerte_subita;
        if($request->muerte_subita_detalle != null)
            $antecedentesFamiliares->muerte_subita_detalle = $request->muerte_subita_detalle;
        else
            $antecedentesFamiliares->muerte_subita_detalle = "";

        $antecedentesFamiliares->enf_celiaca = $request->enf_celiaca;
        if($request->enf_celiaca_detalle != null)
            $antecedentesFamiliares->enf_celiaca_detalle = $request->enf_celiaca_detalle;
        else
            $antecedentesFamiliares->enf_celiaca_detalle = "";

        $antecedentesFamiliares->enf_tiroideas = $request->enf_tiroideas;
        if($request->enf_tiroideas_detalle != null)
            $antecedentesFamiliares->enf_tiroideas_detalle = $request->enf_tiroideas_detalle;
        else
            $antecedentesFamiliares->enf_tiroideas_detalle = "";

        $antecedentesFamiliares->enf_neurologicas = $request->enf_neurologicas;
        if($request->enf_neurologicas_detalle != null)
            $antecedentesFamiliares->enf_neurologicas_detalle = $request->enf_neurologicas_detalle;
        else
            $antecedentesFamiliares->enf_neurologicas_detalle = "";

         $antecedentesFamiliares->convulsion_febril = $request->convulsion_febril;
        if($request->convulsion_febril_detalle != null)
            $antecedentesFamiliares->convulsion_febril_detalle = $request->convulsion_febril_detalle;
        else
            $antecedentesFamiliares->convulsion_febril_detalle = "";

        $antecedentesFamiliares->enf_psiquiatrica = $request->enf_psiquiatrica;
        if($request->enf_psiquiatrica_detalle != null)
            $antecedentesFamiliares->enf_psiquiatrica_detalle = $request->enf_psiquiatrica_detalle;
        else
            $antecedentesFamiliares->enf_psiquiatrica_detalle = "";

        $antecedentesFamiliares->enf_oh = $request->enf_oh;
        if($request->enf_oh_detalle != null)
            $antecedentesFamiliares->enf_oh_detalle = $request->enf_oh_detalle;
        else
            $antecedentesFamiliares->enf_oh_detalle = "";

        $antecedentesFamiliares->tabaquismo = $request->tabaquismo;
        if($request->tabaquismo_detalle != null)
            $antecedentesFamiliares->tabaquismo_detalle = $request->tabaquismo_detalle;
        else
            $antecedentesFamiliares->tabaquismo_detalle = "";

        if($request->nota != null)
            $antecedentesFamiliares->nota = $request->nota;
        else
            $antecedentesFamiliares->nota = "";

        $antecedentesFamiliares->activo = 1;
        $antecedentesFamiliares->save();

         return response()->json(array('response'=>1, 'request'=>$request));
    }

    function existeAntecedentesFamiliares($consulta_id, $paciente_id){
        $antecedentesFamiliares = DB::table('antecedentes_familiares')
                                ->where('antecedentes_familiares.consulta_id', $consulta_id)
                                ->where('antecedentes_familiares.paciente_id', $paciente_id)
                                ->where(function ($query) {
                                     $query->where('antecedentes_familiares.activo', 1)
                                           ->orWhere('antecedentes_familiares.activo', 2);
                                })                                    
                                ->first();
        return $antecedentesFamiliares;
    }

    function guardarEscolaridad(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;

        if($this->existeEscolaridad($consulta_id, $paciente_id) == null) { 
            $escolaridad = new Escolaridad;
        } else {
            $escolaridad_aux = $this->existeEscolaridad($consulta_id, $paciente_id);
            $escolaridad = Escolaridad::find($escolaridad_aux->id);
        }

        $escolaridad->consulta_id = $consulta_id;
        $escolaridad->paciente_id = $paciente_id;
        
        if($request->descripcion != null)
            $escolaridad->descripcion = $request->descripcion;
        else
            $escolaridad->descripcion = "";    

        $escolaridad->activo = 1;
        $escolaridad->save();

        return response()->json(array('response'=>1, 'request'=>$request));
    }

    function existeEscolaridad($consulta_id, $paciente_id){
        $escolaridad = DB::table('escolaridads')
                                ->where('escolaridads.consulta_id', $consulta_id)
                                ->where('escolaridads.paciente_id', $paciente_id)
                                ->where(function ($query) {
                                     $query->where('escolaridads.activo', 1)
                                           ->orWhere('escolaridads.activo', 2);
                                })                                    
                                ->first();
        return $escolaridad;
    }

    function guardarActividadesExtraEscolares(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;

        if($this->existeActividadesExtraEscolares($consulta_id, $paciente_id) == null) { 
            $actividadesExtraEscolares = new ActividadesExtraEscolares;
        } else {
            $actividadesExtraEscolares_aux = $this->existeActividadesExtraEscolares($consulta_id, $paciente_id);
            $actividadesExtraEscolares = ActividadesExtraEscolares::find($actividadesExtraEscolares_aux->id);
        }

        $actividadesExtraEscolares->consulta_id = $consulta_id;
        $actividadesExtraEscolares->paciente_id = $paciente_id;
        
        if($request->descripcion != null)
            $actividadesExtraEscolares->descripcion = $request->descripcion;
        else
            $actividadesExtraEscolares->descripcion = "";    

        $actividadesExtraEscolares->activo = 1;
        $actividadesExtraEscolares->save();

        return response()->json(array('response'=>1, 'request'=>$request));
    }

     function existeActividadesExtraEscolares($consulta_id, $paciente_id){
        $actividadesExtraEscolares = DB::table('actividades_extra_escolares')
                                ->where('actividades_extra_escolares.consulta_id', $consulta_id)
                                ->where('actividades_extra_escolares.paciente_id', $paciente_id)
                                ->where(function ($query) {
                                     $query->where('actividades_extra_escolares.activo', 1)
                                           ->orWhere('actividades_extra_escolares.activo', 2);
                                })                                    
                                ->first();
        return $actividadesExtraEscolares;
    }

    function guardarPantallas(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;

        if($this->existePantallas($consulta_id, $paciente_id) == null) { 
            $pantallas = new Pantalla;
        } else {
            $pantallas_aux = $this->existePantallas($consulta_id, $paciente_id);
            $pantallas = Pantalla::find($pantallas_aux->id);
        }

        $pantallas->consulta_id = $consulta_id;
        $pantallas->paciente_id = $paciente_id;
        
        if($request->descripcion != null)
            $pantallas->descripcion = $request->descripcion;
        else
            $pantallas->descripcion = "";    

        $pantallas->activo = 1;
        $pantallas->save();

        return response()->json(array('response'=>1, 'request'=>$request));
    }

    function existePantallas($consulta_id, $paciente_id){
        $pantallas = DB::table('pantallas')
                                ->where('pantallas.consulta_id', $consulta_id)
                                ->where('pantallas.paciente_id', $paciente_id)
                                ->where(function ($query) {
                                     $query->where('pantallas.activo', 1)
                                           ->orWhere('pantallas.activo', 2);
                                })                                    
                                ->first();
        return $pantallas;
    }

    function guardarHabitos(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;

        if($this->existeHabitos($consulta_id, $paciente_id) == null) { 
            $habitos = new Habitos;
        } else {
            $habitos_aux = $this->existeHabitos($consulta_id, $paciente_id);
            $habitos = Habitos::find($habitos_aux->id);
        }

        $habitos->consulta_id = $consulta_id;
        $habitos->paciente_id = $paciente_id;
        
        if($request->descripcion != null)
            $habitos->descripcion = $request->descripcion;
        else
            $habitos->descripcion = "";    

        $habitos->activo = 1;
        $habitos->save();

        return response()->json(array('response'=>1, 'request'=>$request));
    }

    function existeHabitos($consulta_id, $paciente_id){
        $habitos = DB::table('habitos')
                                ->where('habitos.consulta_id', $consulta_id)
                                ->where('habitos.paciente_id', $paciente_id)
                                ->where(function ($query) {
                                     $query->where('habitos.activo', 1)
                                           ->orWhere('habitos.activo', 2);
                                })                                    
                                ->first();
        return $habitos;
    }

    function guardarMenarca(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;

        if($this->existeMenarca($paciente_id) == null) { 
            $menarca = new Menarca;
        } else {
            $menarca_aux = $this->existeMenarca($paciente_id);
            $menarca = Menarca::find($menarca_aux->id);
        }

        $menarca->consulta_id = $consulta_id;
        $menarca->paciente_id = $paciente_id;
        
        if($request->descripcion != null)
            $menarca->descripcion = $request->descripcion;
        else
            $menarca->descripcion = "";    

        $menarca->activo = 1;
        $menarca->save();

        return response()->json(array('response'=>1, 'request'=>$request));
    }

    function existeMenarca($paciente_id){
        $menarca = DB::table('menarcas')                                
                                ->where('menarcas.paciente_id', $paciente_id)
                                ->where(function ($query) {
                                     $query->where('menarcas.activo', 1)
                                           ->orWhere('menarcas.activo', 2);
                                })                                    
                                ->first();
        return $menarca;
    }

    function guardarConductas(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;

        if($this->existeConducta($consulta_id, $paciente_id) == null) { 
            $conducta = new Conducta;
        } else {
            $conducta_aux = $this->existeConducta($consulta_id, $paciente_id);
            $conducta = Conducta::find($conducta_aux->id);
        }

        $conducta->consulta_id = $consulta_id;
        $conducta->paciente_id = $paciente_id;
        
        if($request->descripcion != null)
            $conducta->descripcion = $request->descripcion;
        else
            $conducta->descripcion = "";    

        $conducta->activo = 1;
        $conducta->save();

        return response()->json(array('response'=>1, 'request'=>$request));
    }

    function existeConducta($consulta_id, $paciente_id){
        $conductas = DB::table('conductas')
                                ->where('conductas.consulta_id', $consulta_id)
                                ->where('conductas.paciente_id', $paciente_id)
                                ->where(function ($query) {
                                     $query->where('conductas.activo', 1)
                                           ->orWhere('conductas.activo', 2);
                                })                                    
                                ->first();
        return $conductas;
    }

    function guardarAlimentacion(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;

        if($this->existeAlimentacion($consulta_id, $paciente_id) == null) { 
            $alimentacion = new Alimentacion;
        } else {
            $alimentacion_aux = $this->existeAlimentacion($consulta_id, $paciente_id);
            $alimentacion = Alimentacion::find($alimentacion_aux->id);
        }

        $alimentacion->consulta_id = $consulta_id;
        $alimentacion->paciente_id = $paciente_id;
        
        $alimentacion->pecho = $request->pecho;
        if($request->pecho_detalle != null)
            $alimentacion->pecho_detalle = $request->pecho_detalle;
        else
            $alimentacion->pecho_detalle = "";

        $alimentacion->leche_maternizada = $request->leche_maternizada;
        if($request->leche_maternizada_detalle != null)
            $alimentacion->leche_maternizada_detalle = $request->leche_maternizada_detalle;
        else
            $alimentacion->leche_maternizada_detalle = "";

        $alimentacion->leche_vaca = $request->leche_vaca;
        if($request->leche_vaca_detalle != null)
            $alimentacion->leche_vaca_detalle = $request->leche_vaca_detalle;
        else
            $alimentacion->leche_vaca_detalle = "";    

        if($request->dieta_tipo != null)
            $alimentacion->dieta_tipo = $request->dieta_tipo;
        else
            $alimentacion->dieta_tipo = "";    

        if($request->dieta_comidas != null)
            $alimentacion->dieta_comidas = $request->dieta_comidas;
        else
            $alimentacion->dieta_comidas = "";    

        $alimentacion->hierro = $request->hierro;
        if($request->hierro_dosis != null)
            $alimentacion->hierro_dosis = $request->hierro_dosis;
        else
            $alimentacion->hierro_dosis = "";    

        $alimentacion->vitamina = $request->vitamina;
        if($request->vitamina_dosis != null)
            $alimentacion->vitamina_dosis = $request->vitamina_dosis;
        else
            $alimentacion->vitamina_dosis = "";    

        if($request->catarsis != null)
            $alimentacion->catarsis = $request->catarsis;
        else
            $alimentacion->catarsis = "";    

        if($request->somnia != null)
            $alimentacion->somnia = $request->somnia;
        else
            $alimentacion->somnia = "";    

        $alimentacion->activo = 1;
        $alimentacion->save();

        return response()->json(array('response'=>1, 'request'=>$request));
    }

    function existeAlimentacion($consulta_id, $paciente_id){
        $alimentacion = DB::table('alimentacions')
                                ->where('alimentacions.consulta_id', $consulta_id)
                                ->where('alimentacions.paciente_id', $paciente_id)
                                ->where(function ($query) {
                                     $query->where('alimentacions.activo', 1)
                                           ->orWhere('alimentacions.activo', 2);
                                })                                    
                                ->first();
        return $alimentacion;
    }

    function guardarExamenFisico(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;

        if($this->existeExamenFisico($consulta_id, $paciente_id) == null) { 
            $examenFisico = new ExamenFisico;
        } else {
            $examenFisico_aux = $this->existeExamenFisico($consulta_id, $paciente_id);
            $examenFisico = ExamenFisico::find($examenFisico_aux->id);
        }

        $examenFisico->consulta_id = $consulta_id;
        $examenFisico->paciente_id = $paciente_id;
                
        if($request->peso != null)
            $examenFisico->peso = $request->peso;
        else
            $examenFisico->peso = 0;

        if($request->peso_percentil != null)
            $examenFisico->peso_percentil = $request->peso_percentil;
        else
            $examenFisico->peso_percentil = 0;

        if($request->talla != null)
            $examenFisico->talla = $request->talla;
        else
            $examenFisico->talla = 0;

        if($request->talla_percentil != null)
            $examenFisico->talla_percentil = $request->talla_percentil;
        else
            $examenFisico->talla_percentil = 0;

          if($request->pc != null)
            $examenFisico->pc = $request->pc;
        else
            $examenFisico->pc = 0;

        if($request->pc_percentil != null)
            $examenFisico->pc_percentil = $request->pc_percentil;
        else
            $examenFisico->pc_percentil = 0;

        if($request->ipd != null)
            $examenFisico->ipd = $request->ipd;
        else
            $examenFisico->ipd = 0;

        if($request->ta != null)
            $examenFisico->ta = $request->ta;
        else
            $examenFisico->ta = 0;

        if($request->imc != null)
            $examenFisico->imc = $request->imc;
        else
            $examenFisico->imc = 0;

        if($request->imc_percentil != null)
            $examenFisico->imc_percentil = $request->imc_percentil;
        else
            $examenFisico->imc_percentil = 0;

        if($request->nota != null)
            $examenFisico->nota = $request->nota;
        else
            $examenFisico->nota = "";

        $examenFisico->activo = 1;
        $examenFisico->save();

        return response()->json(array('response'=>1, 'request'=>$request));
    }

    function existeExamenFisico($consulta_id, $paciente_id){
        $examenFisico = DB::table('examen_fisicos')
                                ->where('examen_fisicos.consulta_id', $consulta_id)
                                ->where('examen_fisicos.paciente_id', $paciente_id)
                                ->where(function ($query) {
                                     $query->where('examen_fisicos.activo', 1)
                                           ->orWhere('examen_fisicos.activo', 2);
                                })                                    
                                ->first();
        return $examenFisico;
    }

    function existeInterconsulta($paciente, $numero){
        $cantidadInterconsultas = DB::table('interconsultas')                                
                                ->where('interconsultas.paciente_id', $paciente)
                                ->where('interconsultas.numero', $numero)
                                ->where('interconsultas.activo', 1)
                                ->first();    

        return $cantidadInterconsultas;
    }

    function guardarInterconsulta(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;
        $numero = $request->numero;
        if($numero == 0){
            $numero = 1;            
        }
        $interconsultas_aux = $this->existeInterconsulta($paciente_id, $numero);
        if($interconsultas_aux != null){
            $interconsulta = Interconsulta::find($interconsultas_aux->id);
            if($request->respuesta != null)
                $interconsulta->respuesta = $request->respuesta;
            else
                $interconsulta->respuesta = "";
            $interconsulta->save();
        } else {
            $interconsulta = new Interconsulta;
            $interconsulta->consulta_id = $consulta_id;
            $interconsulta->paciente_id = $paciente_id;        
            $interconsulta->numero = $numero;

            if($request->especialista != null)
                $interconsulta->especialista = $request->especialista;
            else
                $interconsulta->especialista = "";

            if($request->solicito != null)
                $interconsulta->solicito = $request->solicito;
            else
                $interconsulta->solicito = "";

            if($request->respuesta != null)
                $interconsulta->respuesta = $request->respuesta;
            else
                $interconsulta->respuesta = "";

            if($request->fechaSolicitud != null)
                $interconsulta->fechaSolicitud = $this->convertirFechaGuardar($request->fechaSolicitud);
            else
                $interconsulta->fechaSolicitud = "";

            $interconsulta->activo = 1;
            $interconsulta->save();
        }

        $cantidadInterconsultas_aux = DB::table('interconsultas')                                
                                ->where('interconsultas.paciente_id', $paciente_id)
                                ->where('interconsultas.activo', 1)
                                ->get();    
        $cantidadInterconsultas = $cantidadInterconsultas_aux->count();
        
        return response()->json(array('response'=>1, 'cantidadInterconsultas' => $cantidadInterconsultas,'numero'=>$numero));
    }

    function cargarInterconsulta(Request $request){
        $paciente_id = $request->paciente;
        $numero = $request->numero;
        if($numero < 1){
            $numero = 1;
        }
        $cantidadInterconsultas_aux = DB::table('interconsultas')                                
                                ->where('interconsultas.paciente_id', $paciente_id)
                                ->where('interconsultas.activo', 1)
                                ->get();    
        $cantidadInterconsultas = $cantidadInterconsultas_aux->count();
        if($numero>$cantidadInterconsultas)
            $numero = $cantidadInterconsultas;

        $response_data = DB::table('interconsultas')                                
                                        ->where('interconsultas.paciente_id', $paciente_id)
                                        ->where('interconsultas.numero', $numero)
                                        ->where('interconsultas.activo', 1)                                        
                                        ->first();

        return response()->json(array('response'=>1, 'numero' => $cantidadInterconsultas,'interconsulta'=>$response_data));
    }

    function cargarNumeroInterconsulta(Request $request){
        $paciente_id = $request->paciente;
        $interconsultas_aux = DB::table('interconsultas')                                
                                        ->where('interconsultas.paciente_id', $paciente_id)
                                        ->where('interconsultas.activo', 1)
                                        ->orderby('interconsultas.numero', 'desc')
                                        ->first();
        if($interconsultas_aux != null)    
            $numero = $interconsultas_aux->numero;
        else
            $numero = 0;

        return response()->json(array('response'=>1, 'numero' => $numero,'interconsulta' =>$interconsultas_aux,'request'=>$request));
    }

    // input : 15/05/2020 return 2020-05-15
    function convertirFechaGuardar($fecha){
        $fecha_aux = explode('/',$fecha);
        $_fecha = $fecha_aux[2].'-'.$fecha_aux[1].'-'.$fecha_aux[0];
        return $_fecha;
    }

    // input 2020-05-15 return 15/05/2020
    function convertirFechaMostrar($fecha){
        $fecha_aux = explode('-',$fecha);
        $_fecha = $fecha_aux[2].'/'.$fecha_aux[1].'/'.$fecha_aux[0];
        return $_fecha;
    }

    function guardarExamenesComplementarios(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;
        $examenes_complementarios_id = $request->ex_compl_id;
        $numero = $request->ex_compl_numero;
        if($numero == 0){
            $numero = 1;            
        }

        if(($examenes_complementarios_id == 0) || ($examenes_complementarios_id == -1)) {
            $examenesComplementarios = new ExamenesComplementarios;
            $examenesComplementarios->consulta_id = $consulta_id;
            $examenesComplementarios->paciente_id = $paciente_id;

            if($request->solicito != null)
                $examenesComplementarios->solicito = $request->solicito;
            else
                $examenesComplementarios->solicito = "";

            if($request->respuesta != null)
                $examenesComplementarios->respuesta = $request->respuesta;
            else
                $examenesComplementarios->respuesta = "";

            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $fecha = date("Y-m-d");                         
            $examenesComplementarios->fechaSolicitud = $fecha;            
            
            $examenesComplementarios->numero = $numero;
            $examenesComplementarios->activo = 1;

        } else {
            $examenesComplementarios = ExamenesComplementarios::find($examenes_complementarios_id);
            if($request->solicito != null)
                $examenesComplementarios->solicito = $request->solicito;
            else
                $examenesComplementarios->solicito = "";

            if($request->respuesta != null)
                $examenesComplementarios->respuesta = $request->respuesta;
            else
                $examenesComplementarios->respuesta = "";            
        }
        $examenesComplementarios->save();
        
        $examenComplementario_aux = DB::table('examenes_complementarios')                                
                                    ->where('examenes_complementarios.paciente_id', $request->paciente)
                                    ->where(function ($query) {
                                         $query->where('examenes_complementarios.activo', 1)
                                               ->orWhere('examenes_complementarios.activo', 2);
                                    })                                                                
                                    ->get();

        $cantidad = $examenComplementario_aux->count();

        return response()->json(array('response'=>1, 'cantidad' => $cantidad,'examenesComplementarios' =>$examenesComplementarios));
    }

    function cargarExamenesComplementarios(Request $request){
        $paciente_id = $request->paciente;
        $examenes_complementarios_aux = DB::table('examenes_complementarios')                                
                                        ->where('examenes_complementarios.paciente_id', $paciente_id)
                                        ->where('examenes_complementarios.activo', 1)
                                        ->orderby('examenes_complementarios.numero', 'desc')
                                        ->first();
        if($examenes_complementarios_aux != null){
            $numero = $examenes_complementarios_aux->numero;
            $examenes_complementarios_fotos_aux = DB::table('examenes_complementarios_fotos')                                
                                        ->where('examenes_complementarios_fotos.paciente_id', $paciente_id)
                                        ->where('examenes_complementarios_fotos.examen_complementario_id', $examenes_complementarios_aux->id)
                                        ->where('examenes_complementarios_fotos.activo', 1)                                        
                                        ->get();
            $numero_fotos = $examenes_complementarios_fotos_aux->count();
        }
        else {
            $numero = 0;
            $numero_fotos = 0;
        }

        return response()->json(array('response'=>1, 'numero' => $numero,'examenes_complementarios' =>$examenes_complementarios_aux,'request'=>$request, 'numero_fotos'=>$numero_fotos));   
    }

    function cargarExamenesComplementariosAntSigFoto(Request $request){
        $paciente_id = $request->paciente;
        $ex_compl_id = $request->ex_compl_id;
        $numero = $request->numero;
        if($numero < 1){
            $numero = 1;
        }
        $cantidadExamenesComplementariosFoto_aux = DB::table('examenes_complementarios_fotos')                                
                                ->where('examenes_complementarios_fotos.examen_complementario_id', $ex_compl_id)
                                ->where('examenes_complementarios_fotos.paciente_id', $paciente_id)                                
                                ->where('examenes_complementarios_fotos.activo', 1)
                                ->get();    
        $cantidadExamenesComplementariosFotos = $cantidadExamenesComplementariosFoto_aux->count();
        if($numero>$cantidadExamenesComplementariosFotos)
            $numero = $cantidadExamenesComplementariosFotos;

        $response_data = DB::table('examenes_complementarios_fotos')                                
                                        ->where('examenes_complementarios_fotos.paciente_id', $paciente_id)
                                        ->where('examenes_complementarios_fotos.examen_complementario_id', $ex_compl_id)
                                        ->where('examenes_complementarios_fotos.numero', $numero)
                                        ->where('examenes_complementarios_fotos.activo', 1)                                        
                                        ->first();

        return response()->json(array('response'=>1, 'tope' => $cantidadExamenesComplementariosFotos,'examenComplementarioFoto'=>$response_data));
    }

    function guardarExamenesComplementariosFotos(Request $request){
        $consulta_id = $request->examenes_complementarios_consulta_id;
        $paciente_id = $request->examenes_complementarios_paciente_id;
        $examenes_complementarios_id = $request->examenes_complementarios_id;        
        $examenesComplementarios = ExamenesComplementarios::find($examenes_complementarios_id);                      
 
        $cantidadFotos = intval($request->ex_comp_cantidad_fotos);
        $usuario_actual_nombre=\Auth::user()->email;   
        $pathFolderMedico_aux = explode('@', $usuario_actual_nombre);
        $pathFolderMedico = $pathFolderMedico_aux[0];
        
        for ($i = 1; $i <= $cantidadFotos; $i++) {
            $request_foto = 'ex_comp_foto_'.$i;

            if($request->$request_foto != null){
                
                if($request->hasfile($request_foto)){
                    $examenesComplementariosFotos = new ExamenesComplementariosFotos;
                    $examenesComplementariosFotos->activo = 1;
                    $examenesComplementariosFotos->paciente_id = $paciente_id;
                    $examenesComplementariosFotos->consulta_id = $consulta_id;
                    $examenesComplementariosFotos->numero = $this->getNumeroExamenComplementarioFoto($paciente_id, $examenesComplementarios->id);
                    if($request->foto_ex_complementario_id == 0)
                        $examenesComplementariosFotos->examen_complementario_id = $examenesComplementarios->id;
                    else
                        $examenesComplementariosFotos->examen_complementario_id = $request->foto_ex_complementario_id;

                    $pathName = $request->file($request_foto)->store('img/'.$pathFolderMedico.'/examenes_complementarios');
                    $name = collect(explode('/', $pathName))->last();
                    $image = $request->file($request_foto);
                    //$name  = $image->getClientOriginalName().time().'.'.$image->getClientOriginalExtension();
                    $path = 'img/'.$pathFolderMedico.'/examenes_complementarios/'.$name;        
                    Image::make($image->getRealPath())->resize(1980, 1920)->save($path);  
                    $examenesComplementariosFotos->foto = $pathFolderMedico.'/examenes_complementarios/'.$name;
                    $examenesComplementariosFotos->save();           
                }               
            } 
        }
        
        return redirect()->route('navegarconsultaseleccionada');
        
    }

    function getNumeroExamenComplementarioFoto($paciente_id, $examenComplementarioId){
        $examenComplementario_aux = DB::table('examenes_complementarios_fotos')
                                ->where('examenes_complementarios_fotos.examen_complementario_id', $examenComplementarioId)
                                ->where('examenes_complementarios_fotos.paciente_id', $paciente_id)
                                ->where(function ($query) {
                                     $query->where('examenes_complementarios_fotos.activo', 1)
                                           ->orWhere('examenes_complementarios_fotos.activo', 2);
                                })                                                                
                                ->get();  
        return $examenComplementario_aux->count()+1;
    }

    function getExamenesComplementariosUltimo(Request $request){        
         $examenComplementario = DB::table('examenes_complementarios')
                                ->where('examenes_complementarios.consulta_id', $request->consulta)
                                ->where('examenes_complementarios.paciente_id', $request->paciente)
                                ->where(function ($query) {
                                     $query->where('examenes_complementarios.activo', 1)
                                           ->orWhere('examenes_complementarios.activo', 2);
                                })                                
                                ->orderBy('id','desc')
                                ->first();
        return response()->json(array('response'=>1, 'examenComplementario'=>$examenComplementario));
    }

    function cargarExamenesComplementariosAntSig(Request $request){
        $paciente_id = $request->paciente;
        $numero = $request->numero;
        $ex_compl_id = $request->ex_compl_id;
        if($numero < 1){
            $numero = 1;
        }
        $cantidadExamenesComplementarios_aux = DB::table('examenes_complementarios')                                
                                ->where('examenes_complementarios.paciente_id', $paciente_id)
                                ->where('examenes_complementarios.activo', 1)
                                ->get();    
        $cantidadExamenesComplementarios = $cantidadExamenesComplementarios_aux->count();
        if($numero>$cantidadExamenesComplementarios)
            $numero = $cantidadExamenesComplementarios;

        $response_data = DB::table('examenes_complementarios')                                
                                        ->where('examenes_complementarios.paciente_id', $paciente_id)
                                        ->where('examenes_complementarios.numero', $numero)
                                        ->where('examenes_complementarios.activo', 1)                                        
                                        ->first();

                        
        $cantidadExamenesComplementariosFoto_aux = DB::table('examenes_complementarios_fotos')                                
                                ->where('examenes_complementarios_fotos.examen_complementario_id', $ex_compl_id)
                                ->where('examenes_complementarios_fotos.paciente_id', $paciente_id)                                
                                ->where('examenes_complementarios_fotos.activo', 1)
                                ->get();    
        $cantidadExamenesComplementariosFotos = $cantidadExamenesComplementariosFoto_aux->count();        
        $numero_foto = $cantidadExamenesComplementariosFotos;

        $response_data_foto = DB::table('examenes_complementarios_fotos')                                
                                        ->where('examenes_complementarios_fotos.paciente_id', $paciente_id)
                                        ->where('examenes_complementarios_fotos.examen_complementario_id', $ex_compl_id)
                                        ->where('examenes_complementarios_fotos.numero', $numero_foto)
                                        ->where('examenes_complementarios_fotos.activo', 1)                                        
                                        ->first();
        
        return response()->json(array('response'=>1, 'numero' => $cantidadExamenesComplementarios,'examenesComplementarios'=>$response_data, 'examenComplementarioFoto'=>$response_data_foto, 'numero_foto'=>$numero_foto));
    }

    function nuevoExamenComplementario(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;

        $examenComplementario_aux = DB::table('examenes_complementarios')                                
                                ->where('examenes_complementarios.paciente_id', $request->paciente)
                                ->where(function ($query) {
                                     $query->where('examenes_complementarios.activo', 1)
                                           ->orWhere('examenes_complementarios.activo', 2);
                                })                                                                
                                ->get();        
        $examenesComplementarios = $examenComplementario_aux->count() + 1;       
        /*if($examenComplementario_aux->count() == 0)
            $numero = 1;
        else
            $numero = $examenComplementario_aux->count();

        $examenesComplementarios = new ExamenesComplementarios;    
        $examenesComplementarios->consulta_id = $consulta_id;
        $examenesComplementarios->paciente_id = $paciente_id;
        $examenesComplementarios->numero = $numero;            
        $examenesComplementarios->solicito = "";        
        $examenesComplementarios->respuesta = "";

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date("Y-m-d");                      
        $examenesComplementarios->fechaSolicitud = $fecha;        

        $examenesComplementarios->activo = 1;
        $examenesComplementarios->save();        
        */
        return response()->json(array('response'=>1, 'examenComplementario'=>$examenesComplementarios));
    }

    function getFotosExamenesComplementarios(Request $request){
        $fotosExamenComplementario = DB::table('examenes_complementarios_fotos')                                
                                ->where('examenes_complementarios_fotos.paciente_id', $request->paciente)
                                ->where('examenes_complementarios_fotos.examen_complementario_id', $request->ex_compl_id)
                                ->where(function ($query) {
                                     $query->where('examenes_complementarios_fotos.activo', 1)
                                           ->orWhere('examenes_complementarios_fotos.activo', 2);
                                })                                
                                ->orderBy('id','desc')
                                ->first();
        return response()->json(array('response'=>1, 'fotosExamenComplementario'=>$fotosExamenComplementario));       
    }

    function getFotosAntecedentesNeonantales(Request $request){
        $fotos_aux = DB::table('antecedentes_neonatales_fotos')                                
                                ->where('antecedentes_neonatales_fotos.paciente_id', $request->paciente)                                
                                ->where(function ($query) {
                                     $query->where('antecedentes_neonatales_fotos.activo', 1)
                                           ->orWhere('antecedentes_neonatales_fotos.activo', 2);
                                })                                
                                ->orderBy('id','desc')
                                ->first();
        return response()->json(array('response'=>1, 'fotosAntecedentesNeonatales'=>$fotos_aux));       
    }

    function guardarNotaAntecedentesNeonatalesPatologicos(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;
        
        if($this->existeAntecedentesNeonantales($consulta_id, $paciente_id) == null) { 
            $antecedentesNeonatales = new AntecedentesNeonatales;
        } else {
            $antecedentesNeonatales_aux = $this->existeAntecedentesNeonantales($consulta_id, $paciente_id);
            $antecedentesNeonatales = AntecedentesNeonatales::find($antecedentesNeonatales_aux->id);
        }
        $antecedentesNeonatales->consulta_id = $consulta_id;
        $antecedentesNeonatales->paciente_id = $paciente_id;

        if($request->nota != null)
            $antecedentesNeonatales->nota = $request->nota;
        else
            $antecedentesNeonatales->nota = "";

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date("Y-m-d");                         
        $antecedentesNeonatales->fechaSolicitud = $fecha;
        $antecedentesNeonatales->activo = 1;
        $antecedentesNeonatales->save();
        
        return response()->json(array('response'=>1, 'antecedentesNeonatales'=>$antecedentesNeonatales));   
    }

    function existeAntecedentesNeonantales($consulta_id, $paciente_id){
        $antecedentesNeonatales = DB::table('antecedentes_neonatales')
                                ->where('antecedentes_neonatales.consulta_id', $consulta_id)
                                ->where('antecedentes_neonatales.paciente_id', $paciente_id)
                                ->where(function ($query) {
                                     $query->where('antecedentes_neonatales.activo', 1)
                                           ->orWhere('antecedentes_neonatales.activo', 2);
                                })                                    
                                ->first();
        return $antecedentesNeonatales;
    }

    function getNumeroFotosAntecedentesNeonantales($paciente_id){
        $antecedentesNeonatalesFotos = DB::table('antecedentes_neonatales_fotos')                                
                                ->where('antecedentes_neonatales_fotos.paciente_id', $paciente_id)
                                ->where(function ($query) {
                                     $query->where('antecedentes_neonatales_fotos.activo', 1)
                                           ->orWhere('antecedentes_neonatales_fotos.activo', 2);
                                })                                    
                                ->get();
        return $antecedentesNeonatalesFotos->count()+1;
    }

    function guardarAntecedentesNeonatales(Request $request){
        $consulta_id = $request->antecedentes_neonatales_consulta_id;
        $paciente_id = $request->antecedentes_neonatales_paciente_id;
        
        if($this->existeAntecedentesNeonantales($consulta_id, $paciente_id) == null) { 
            $antecedentesNeonatales = new AntecedentesNeonatales;
        } else {
            $antecedentesNeonatales_aux = $this->existeAntecedentesNeonantales($consulta_id, $paciente_id);
            $antecedentesNeonatales = AntecedentesNeonatales::find($antecedentesNeonatales_aux->id);
        }
        $antecedentesNeonatales->consulta_id = $consulta_id;
        $antecedentesNeonatales->paciente_id = $paciente_id;

        if($request->antecedentes_neonatales_patologicos_nota != null)
            $antecedentesNeonatales->nota = $request->antecedentes_neonatales_patologicos_nota;
        else
            $antecedentesNeonatales->nota = "";

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date("Y-m-d");                         
        $antecedentesNeonatales->fechaSolicitud = $fecha;
        $antecedentesNeonatales->activo = 1;
        $antecedentesNeonatales->save();

        $cantidadFotos = intval($request->ant_neonantales_cantidad_fotos);
        $usuario_actual_nombre=\Auth::user()->email;   
        $pathFolderMedico_aux = explode('@', $usuario_actual_nombre);
        $pathFolderMedico = $pathFolderMedico_aux[0];
        for ($i = 1; $i <= $cantidadFotos; $i++) {
            $request_foto = 'ant_neonatales_foto_'.$i;

            if($request->$request_foto != null){
                
                if($request->hasfile($request_foto)){
                    $antecedentesNeonatalesFotos = new AntecedentesNeonatalesFotos;
                    $antecedentesNeonatalesFotos->activo = 1;
                    $antecedentesNeonatalesFotos->paciente_id = $paciente_id;
                    $antecedentesNeonatalesFotos->consulta_id = $consulta_id;
                    $antecedentesNeonatalesFotos->numero = $this->getNumeroFotosAntecedentesNeonantales($paciente_id);
                    $antecedentesNeonatalesFotos->antecedentes_neonatales_id = $antecedentesNeonatales->id;

                    $pathName = $request->file($request_foto)->store('img/'.$pathFolderMedico.'antecedentes_neonatales');
                    $name = collect(explode('/', $pathName))->last();
                    $image = $request->file($request_foto);
                    //$name  = $image->getClientOriginalName().time().'.'.$image->getClientOriginalExtension();
                    $path = 'img/'.$pathFolderMedico.'/antecedentes_neonatales/'.$name;        
                    Image::make($image->getRealPath())->resize(1980, 1920)->save($path);  
                    $antecedentesNeonatalesFotos->foto = $pathFolderMedico.'/antecedentes_neonatales/'.$name;
                    $antecedentesNeonatalesFotos->save();           
                }               
            } 
        }

        return redirect()->route('navegarconsultaseleccionada');
    }

    function cargarAntecedentesNeonatalesAntSigFoto(Request $request){
        $paciente_id = $request->paciente;        
        $numero = $request->numero;
        if($numero < 1){
            $numero = 1;
        }
        $cantidad_fotos_aux = DB::table('antecedentes_neonatales_fotos')                                
                                ->where('antecedentes_neonatales_fotos.paciente_id', $paciente_id)                                
                                ->where('antecedentes_neonatales_fotos.activo', 1)
                                ->get();    
        $cantidadFotos = $cantidad_fotos_aux->count();
        if($numero>$cantidadFotos)
            $numero = $cantidadFotos;

        $response_data = DB::table('antecedentes_neonatales_fotos')                                
                                        ->where('antecedentes_neonatales_fotos.paciente_id', $paciente_id)                                        
                                        ->where('antecedentes_neonatales_fotos.numero', $numero)
                                        ->where('antecedentes_neonatales_fotos.activo', 1)                                        
                                        ->first();

        return response()->json(array('response'=>1, 'cantidadFotos' => $cantidadFotos,'response_data'=>$response_data));
    }

    function consultarPaciente(){
         return view('medico.consulta');                
    }

    function crearNuevaConsulta(Request $request){
        $paciente_id = $request->paciente_id;
           
        $paciente = paciente::find($paciente_id);
        if($paciente != null) {
            $consultaAbierta = $this->checkConsultaAbierta($paciente_id);
            if( $consultaAbierta == null){
                $consulta = new Consulta;
                $consulta->paciente_id = $paciente->id;
                $consulta->activo = 2;
                $consulta->save();
            } else {
                $consulta = $consultaAbierta;
            }
        } else {
            $consulta = null;
        }

        $user=\Auth::user();                
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();
        if($medicoInfoAux != null){
            $medicoInfo = MedicoInfo::find($medicoInfoAux->id);
            $medicoInfo->paciente_id = $paciente_id;
            $medicoInfo->consulta_id = $consulta->id;
            $medicoInfo->es_nueva_consulta = 1;
            $medicoInfo->save();
        } else {
            $medicoInfo = new MedicoInfo;
            $medicoInfo->medico_user_id = $user->id;
            $medicoInfo->paciente_id = $paciente_id;
            $medicoInfo->es_nueva_consulta = 1;
            $medicoInfo->consulta_id = $consulta->id;
            $medicoInfo-> save();
        }     

        //return redirect()->route('navegarconsultaseleccionada');
        return response()->json(array('response'=>1, 'paciente_id'=>$paciente_id, 'consulta_id'=>$consulta->id));
       
    }

    function pacienteConsultas($paciente_id){
         return view('medico.seleccionar_consulta')->with('paciente_id', $paciente_id);                
    }

    function pacienteConsultasListado(){
        $user=\Auth::user();
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();        
        $paciente_id = $medicoInfoAux->paciente_id;
        $users = DB::table('pacientes')                                
                                ->join('medico_pacientes','medico_pacientes.paciente_id','=','pacientes.id')
                                ->join('consultas','consultas.paciente_id','=','pacientes.id')                        
                                ->select('pacientes.id as paciente_id', 'consultas.id as consulta_id', 'consultas.created_at as fechaConsulta')                                
                                ->where('consultas.paciente_id', $paciente_id)
                                ->where('medico_pacientes.medico_user_id',$user->id)                                
                                ->where('pacientes.activo', 1)                                 
                                ->where('medico_pacientes.activo', 1)                                                                 
                                ->orderby('consultas.created_at');        
                
        return datatables()->of($users)
                           ->addIndexColumn()
                           ->addColumn('fecha', function($row){                                   
                               $fecha_aux = $row->fechaConsulta;                                                              
                               $fecha_aux = explode(' ', $fecha_aux);                               
                               $fecha_aux1 = explode('-', $fecha_aux[0]);                               
                               $fecha = $fecha_aux1[2].'/'.$fecha_aux1[1].'/'.$fecha_aux1[0];
                                                        
                               return $fecha;
                            })
                           ->addColumn('action', function($row){                                                                  
                               $consulta_id = $row->consulta_id;
                               $btn = "<button onclick=navegarConsulta($consulta_id) class='rodri_button_aceptar_si'>></button>";
                               /*$btn = "<form method='POST' action='{{ route('nuevaconsulta') }}'>
                                        @csrf                           
                                        <button class='rodri_button_aceptar_si' type='submit'>></button>                                        
                                        </form>";*/
                               return $btn;
                            })
                            ->rawColumns(['fecha','action'])
                            ->make(true);    
    }

    function navegarConsultas(Request $request){
        $user=\Auth::user();        
        $paciente_id = $request->paciente_id;

        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();
        if($medicoInfoAux != null){
            $medicoInfo = MedicoInfo::find($medicoInfoAux->id);
            $medicoInfo->paciente_id = $paciente_id;            
            $medicoInfo->save();
        } else {
            $medicoInfo = new MedicoInfo;
            $medicoInfo->medico_user_id = $user->id;
            $medicoInfo->paciente_id = $paciente_id;
            $medicoInfo->es_nueva_consulta = 0;
            $medicoInfo->consulta_id = 0;
            $medicoInfo-> save();
        }        

        return response()->json(array('response'=>1, 'paciente_id'=>$paciente_id));
    }

    function navegarConsultaSeleccionada(){
        $user=\Auth::user();   
        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();
        $paciente_id = $medicoInfoAux->paciente_id;
        $consulta_id = $medicoInfoAux->consulta_id;
        $esNuevaConsutlta = $medicoInfoAux->es_nueva_consulta;

        $_consulta = consulta::find($consulta_id);
        $_paciente = paciente::find($paciente_id);

        return view('medico.nueva_consulta')
                    ->with('nueva_consulta', $esNuevaConsutlta)
                    ->with('consulta',$_consulta)                
                    ->with('paciente',$_paciente);  
    }

    function guardarConsultaMedicoInfo(Request $request){
        $user=\Auth::user();        
        $consulta_id = $request->consulta_id;

        $medicoInfoAux = DB::table('medico_infos')
                            ->where('medico_infos.medico_user_id', $user->id)
                            ->first();
        if($medicoInfoAux != null){
            $medicoInfo = MedicoInfo::find($medicoInfoAux->id);
            $medicoInfo->consulta_id = $consulta_id;
            $medicoInfo->es_nueva_consulta = 0;
            $medicoInfo->save();
            return response()->json(array('response'=>1));
        }      

         return response()->json(array('response'=>0));
           
    }

    function establecerActivo(Request $request){
        $paciente_id = $request->paciente_id;
        $consulta_id = $request->consulta_id;        
        $consultas = consulta::find($consulta_id);
        $consultas->activo = 1;
        $consultas->save();
        return response()->json(array('response'=>1));
    }

    function checkConsultaExiste(Request $request){         
        $consulta_id = $request->consulta_id;

        $consulta = consulta::find($consulta_id);
        if($consulta->activo == 1){
            return response()->json(array('response'=>1));    
        } else {
            if($consulta->activo == 2){
                return response()->json(array('response'=>0));    
            } else {
                return response()->json(array('response'=>2));    
            }
        }
    }

    function cargarEscolaridad(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;
        
        $tablaAux = DB::table('escolaridads')
                        ->where('escolaridads.consulta_id', $consulta_id)
                        ->where('escolaridads.paciente_id', $paciente_id)
                        ->where('escolaridads.activo', 1)
                        ->first();        
        
        return response()->json(array('response'=>1, 'response_data' =>$tablaAux));
    }

    function cargarActividadesExtraEscolares(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;
        
        $tablaAux = DB::table('actividades_extra_escolares')
                        ->where('actividades_extra_escolares.consulta_id', $consulta_id)
                        ->where('actividades_extra_escolares.paciente_id', $paciente_id)
                        ->where('actividades_extra_escolares.activo', 1)
                        ->first();        
        
        return response()->json(array('response'=>1, 'response_data' =>$tablaAux));
    }

    function cargarPantallas(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;
        
        $tablaAux = DB::table('pantallas')
                        ->where('pantallas.consulta_id', $consulta_id)
                        ->where('pantallas.paciente_id', $paciente_id)
                        ->where('pantallas.activo', 1)
                        ->first();        
        
        return response()->json(array('response'=>1, 'response_data' =>$tablaAux));
    }

    function cargarHabitos(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;
        
        $tablaAux = DB::table('habitos')
                        ->where('habitos.consulta_id', $consulta_id)
                        ->where('habitos.paciente_id', $paciente_id)
                        ->where('habitos.activo', 1)
                        ->first();        
        
        return response()->json(array('response'=>1, 'response_data' =>$tablaAux));
    }

    function cargarConductas(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;
        
        $tablaAux = DB::table('conductas')
                        ->where('conductas.consulta_id', $consulta_id)
                        ->where('conductas.paciente_id', $paciente_id)
                        ->where('conductas.activo', 1)
                        ->first();        
        
        return response()->json(array('response'=>1, 'response_data' =>$tablaAux));
    }

    function cargarExamenFisico(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;
        
        $tablaAux = DB::table('examen_fisicos')
                        ->where('examen_fisicos.consulta_id', $consulta_id)
                        ->where('examen_fisicos.paciente_id', $paciente_id)
                        ->where('examen_fisicos.activo', 1)
                        ->first();        
        
        return response()->json(array('response'=>1, 'response_data' =>$tablaAux));
    }

    function cargarAlimentacion(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;
        
        $tablaAux = DB::table('alimentacions')
                        ->where('alimentacions.consulta_id', $consulta_id)
                        ->where('alimentacions.paciente_id', $paciente_id)
                        ->where('alimentacions.activo', 1)
                        ->first();        
        
        return response()->json(array('response'=>1, 'response_data' =>$tablaAux));   
    }

    function cargarMenarca(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;
        
        $tablaAux = DB::table('menarcas')                        
                        ->where('menarcas.paciente_id', $paciente_id)
                        ->where('menarcas.activo', 1)
                        ->first();        
        
        return response()->json(array('response'=>1, 'response_data' =>$tablaAux));   
    }

    function cargarAntecedentesPerinatales(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;
        
        $tablaAux = DB::table('antecedentes_perinatales')                        
                        ->where('antecedentes_perinatales.paciente_id', $paciente_id)
                        ->where('antecedentes_perinatales.activo', 1)
                        ->first();        
        
        return response()->json(array('response'=>1, 'response_data' =>$tablaAux));      
    }

    function cargarAntecedentesPersonales(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;
        
        $tablaAux = DB::table('antecedentes_personales')                        
                        ->where('antecedentes_personales.paciente_id', $paciente_id)
                        ->where('antecedentes_personales.activo', 1)
                        ->first();        
        
        return response()->json(array('response'=>1, 'response_data' =>$tablaAux));      
    }

    function cargarAntecedentesFamiliares(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;
        
        $tablaAux = DB::table('antecedentes_familiares')                        
                        ->where('antecedentes_familiares.paciente_id', $paciente_id)
                        ->where('antecedentes_familiares.activo', 1)
                        ->first();        
        
        return response()->json(array('response'=>1, 'response_data' =>$tablaAux));         
    }

    function cargarAntecedentesNeonantalesNota(Request $request){
        $consulta_id = $request->consulta;
        $paciente_id = $request->paciente;
        
        $tablaAux = DB::table('antecedentes_neonatales')                        
                        ->where('antecedentes_neonatales.paciente_id', $paciente_id)
                        ->where('antecedentes_neonatales.activo', 1)
                        ->first();        
        
        return response()->json(array('response'=>1, 'response_data' =>$tablaAux));         
    }

    function guardarinterconsultores(Request $request) {
        $user_id = \Auth::user()->id;        
        $interconsultores = new Interconsultores;
        $interconsultores->user_id = $user_id;
        
        if($request->nombre != null){
            $interconsultores->nombre = $request->nombre;
        } else {
            $interconsultores->nombre = "";
        }

        if($request->apellido != null){
            $interconsultores->apellido = $request->apellido;
        } else {
            $interconsultores->apellido = "";
        }

        if($request->especialidad != null){
            $interconsultores->especialidad = $request->especialidad;
        } else {
            $interconsultores->especialidad = "";
        }

        if($request->direccion != null){
            $interconsultores->direccion = $request->direccion;
        } else {
            $interconsultores->direccion = "";
        }

        if($request->telefono_p != null){
            $interconsultores->telefono_particular = $request->telefono_p;
        } else {
            $interconsultores->telefono_particular = "";
        }

        if($request->telefono_c != null){
            $interconsultores->telefono_consultorio = $request->telefono_c;
        } else {
            $interconsultores->telefono_consultorio = "";
        }

        $interconsultores->activo = 1;
        $interconsultores->save();

        return response()->json(array('response'=>1, 'response_data'=>$interconsultores));         
    }

    function interconsultoresListadoBuscar(){
        $user=\Auth::user();                
        $users = DB::table('interconsultores')                                                            
                            ->where('interconsultores.user_id',$user->id)                                                       
                            ->where('interconsultores.activo', 1)                                 
                            ->orderby('interconsultores.apellido');        

        return datatables()->of($users)
                           ->addIndexColumn()                                                       
                           ->make(true);    
    }       

    function guardarPendientes(Request $request){
        $paciente_id = $request->paciente_id;
        $consulta_id = $request->consulta_id;
        $pendiente_text = $request->pendiente;

        $existePendiente = DB::table('aux_pendientes')                                                            
                            ->where('aux_pendientes.paciente_id',$paciente_id)
                            ->where('aux_pendientes.consulta_id',$consulta_id)                                                       
                            ->where('aux_pendientes.activo', 1)                                 
                            ->first();
        if($existePendiente!=null){
            $pendiente = AuxPendiente::find($existePendiente->id);
            $pendiente->pendientes = $pendiente_text;                        
            $pendiente->save();
        }
        else{
            $pendiente = new AuxPendiente;
            $pendiente->paciente_id = $paciente_id;
            $pendiente->consulta_id = $consulta_id;
            $pendiente->pendientes = $pendiente_text;
            $pendiente->activo = 1;            
            $pendiente->save();
        }
        
        return response()->json(array('response'=>1, 'response_data'=>$pendiente));         
    }

    function cargarPendientes(Request $request){
        $paciente_id = $request->paciente_id;
        // ver tengo que buscar por consulta anterior, porque sino me carga el ultimo pendiente que hubo,
        // y si no hubo pendiente en la consulta anterior, igual me carga el ulitmo que exista.
        // fix: cargo en infoMedicos la ultima consulta antes de crear una nueva.        

        $existePendiente = DB::table('aux_pendientes')                                                            
                            ->where('aux_pendientes.paciente_id',$paciente_id)                            
                            ->where('aux_pendientes.activo', 1)
                            ->orderby('aux_pendientes.id','desc')                                 
                            ->first();

        return response()->json(array('response'=>1, 'response_data'=>$existePendiente));  
    }
}
