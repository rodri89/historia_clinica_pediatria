<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/original', function () {
    return view('plantillas.plantilla_original');
});




Route::get('/', function () {
	return view('auth.login');
   // return view('plantillas.plantilla_medico');
});

Route::get('/home', 'HomeController@index')->name('home');

// Aca van a ir todas las rutas que tiene acceso un administrador.
Route::group(['middleware' => ['usuarioAdmin']], function () {

	Route::get('/admin_home', function () {
	    return view('plantillas.plantilla_admin');
	});

	Route::get('/admin_nuevo_usuario', function () {
	    return view('admin.nuevo_usuario');
	});

	Route::get('/admin_medicos', function () {
	    return view('admin.admin_medicos');
	});

	Route::get('/admin_secretaria', function () {
		$secretarias = DB::table('users')->where('usuario_tipo', 3)->get();
		$medicos = DB::table('users')->where('usuario_tipo', 2)->get();

    	return View('admin.admin_secretaria')
    	->with('secretarias',$secretarias)
    	->with('medicos',$medicos);   
    });

	Auth::routes();

	Route::post('/registrar', 'Auth\RegisterController@registrar')->name('registrar');

	Route::post('/vincular_secretaria_medico', 'AdminController@vincularSecretariaMedico')->name('vincularsecretariamedico');
	
 });

// Aca van a ir todas las rutas que tiene acceso un medico.
Route::group(['middleware' => ['usuarioMedico']], function () {

	Route::get('/medico_home', function () {
	    return view('plantillas.plantilla_medico');
	});

/*	Route::get('/listado_pacientes_dia', function () {
	    return view('medico.listado_pacientes_dia');
	});	 */

	Route::get('listado_pacientes_dia','MedicoController@listadoPacientesDia')->name('listadopacientesdia');

	Route::get('/medico_nuevo_paciente', function () {
	    return view('medico.nuevo_paciente')->with('medico_id', Auth::user()->id);
	});

	Route::get('/medico_buscar_paciente', function () {
	    $user = \Auth::user();	
	    return view('medico.buscar_paciente')->with('medico_id', $user->id);
	});	

	Route::get('medico_actualizar_paciente','PacienteController@actualizarPaciente')->name('medicoactualizarpaciente');

	Route::post('medico_actualizar_paciente_buscar','PacienteController@actualizarPacienteBuscar')->name('medicoactualizarpacientebuscar');

	Route::post('nueva_consulta','MedicoController@nuevaConsulta')->name('nuevaconsulta');

	Route::get('consulta/{paciente}/{consulta}','MedicoController@consultaGet')->name('consulta');	

	Route::get('interconsultores','MedicoController@interconsultores')->name('interconsultores');

	Route::post('ir_paciente_historia_clinica','MedicoController@irPacienteHistoriaClinica')->name('irpacientehistoriaclinica');
	
	Route::post('guardar_antecedentes_perinatales','MedicoController@guardarAntecedentesPerinatales')->name('guardarantecedentesperinatales');

	Route::post('guardar_antecedentes_personales','MedicoController@guardarAntecedentesPersonales')->name('guardarantecedentespersonales');
	
	Route::post('guardar_antecedentes_familiares','MedicoController@guardarAntecedentesFamiliares')->name('guardarantecedentesfamiliares');
	
	Route::post('guardar_escolaridad','MedicoController@guardarEscolaridad')->name('guardarescolaridad');
	
	Route::post('guardar_actividades_extra_escolares','MedicoController@guardarActividadesExtraEscolares')->name('guardaractividadesextraescolares');
	
	Route::post('guardar_pantallas','MedicoController@guardarPantallas')->name('guardarpantallas');
	
	Route::post('guardar_habitos','MedicoController@guardarHabitos')->name('guardarhabitos');
	
	Route::post('guardar_menarca','MedicoController@guardarMenarca')->name('guardarmenarca');
	
	Route::post('guardar_conductas','MedicoController@guardarConductas')->name('guardarconductas');
	
	Route::post('guardar_alimentacion','MedicoController@guardarAlimentacion')->name('guardaralimentacion');
	
	Route::post('guardar_examen_fisico','MedicoController@guardarExamenFisico')->name('guardarexamenfisico');
	
	Route::post('guardar_interconsulta','MedicoController@guardarInterconsulta')->name('guardarinterconsulta');
	
	Route::post('guardar_examenes_complementarios_fotos','MedicoController@guardarExamenesComplementariosFotos')->name('guardarexamenescomplementariosfotos');

	Route::post('guardar_examenes_complementarios','MedicoController@guardarExamenesComplementarios')->name('guardarexamenescomplementarios');
	
	Route::post('cargar_examenes_complementarios','MedicoController@cargarExamenesComplementarios')->name('cargarexamenescomplementarios');

	Route::post('cargar_examenes_complementarios_ant_sig_foto','MedicoController@cargarExamenesComplementariosAntSigFoto')->name('cargarexamenescomplementariosantsigfoto');

	Route::post('get_examenes_complementarios_ultimo','MedicoController@getExamenesComplementariosUltimo')->name('getexamenescomplementariosultimo');
	
	Route::post('nuevo_examen_complementario','MedicoController@nuevoExamenComplementario')->name('nuevoexamencomplementario');
	
	Route::post('cargar_examenes_complementarios_ant_sig','MedicoController@cargarExamenesComplementariosAntSig')->name('cargarexamenescomplementariosantsig');
	
	Route::post('get_fotos_examenes_complementarios','MedicoController@getFotosExamenesComplementarios')->name('getfotosexamenescomplementarios');
	
	Route::post('guardar_nota_antecedentes_neonatales_patologicos','MedicoController@guardarNotaAntecedentesNeonatalesPatologicos')->name('guardarnotaantecedentesneonatalespatologicos');
	
	Route::post('guardar_antecedentes_neonatales','MedicoController@guardarAntecedentesNeonatales')->name('guardarantecedentesneonatales');

	Route::post('cargar_antecedentes_neonatales_ant_sig_foto','MedicoController@cargarAntecedentesNeonatalesAntSigFoto')->name('cargarantecedentesneonatalesantsigfoto');
	
	Route::post('get_fotos_antecedentes_neonantales','MedicoController@getFotosAntecedentesNeonantales')->name('getfotosantecedentesneonantales');

	Route::post('guardar_vacuna_paciente','MedicoController@guardarVacunaPaciente')->name('guardarvacunapaciente');

	Route::post('cargar_vacuna_paciente','MedicoController@cargarVacunaPaciente')->name('cargarvacunapaciente');
	
	Route::post('guardar_vacuna_otra_paciente','MedicoController@guardarVacunaOtraPaciente')->name('guardarvacunaotrapaciente');

	Route::get('consulta','MedicoController@consultarPaciente')->name('consulta');

	Route::get('nueva_consulta_paciente_listado_buscar','MedicoController@nuevaConsultaPacienteListadoBuscar')->name('nuevaconsultapacientelistadobuscar');

	Route::get('nueva_consulta_paciente','MedicoController@nuevaConsultaPaciente')->name('nuevaconsultapaciente');
	
	Route::post('crear_nueva_consulta','MedicoController@crearNuevaConsulta')->name('crearnuevaconsulta');
	
	Route::get('paciente_consultas/{paciente_id}','MedicoController@pacienteConsultas')->name('pacienteconsultas');

	Route::get('paciente_consultas_listado','MedicoController@pacienteConsultasListado')->name('pacienteconsultaslistado');
	
	Route::post('navegar_consultas','MedicoController@navegarConsultas')->name('navegarconsultas');
	
	Route::get('navegar_consulta_seleccionada','MedicoController@navegarConsultaSeleccionada')->name('navegarconsultaseleccionada');
	
	Route::post('guardar_consulta_medico_info','MedicoController@guardarConsultaMedicoInfo')->name('guardarconsultamedicoinfo');
	
	Route::post('establecer_activo','MedicoController@establecerActivo')->name('estableceractivo');

	Route::post('check_consulta_existe','MedicoController@checkConsultaExiste')->name('checkconsultaexiste');

	Route::post('cargar_escolaridad','MedicoController@cargarEscolaridad')->name('cargarescolaridad');
	
	Route::post('cargar_actividades_extra_escolares','MedicoController@cargarActividadesExtraEscolares')->name('cargaractividadesextraescolares');
	
	Route::post('cargar_pantallas','MedicoController@cargarPantallas')->name('cargarpantallas');
	
	Route::post('cargar_habitos','MedicoController@cargarHabitos')->name('cargarhabitos');
	
	Route::post('cargar_conductas','MedicoController@cargarConductas')->name('cargarconductas');
	
	Route::post('cargar_examen_fisico','MedicoController@cargarExamenFisico')->name('cargarexamenfisico');
	
	Route::post('cargar_alimentacion','MedicoController@cargarAlimentacion')->name('cargaralimentacion');
	
	Route::post('cargar_menarca','MedicoController@cargarMenarca')->name('cargarmenarca');
	
	Route::post('cargar_antecedentes_perinatales','MedicoController@cargarAntecedentesPerinatales')->name('cargarantecedentesperinatales');
	
	Route::post('cargar_antecedentes_personales','MedicoController@cargarAntecedentesPersonales')->name('cargarantecedentespersonales');
	
	Route::post('cargar_antecedentes_familiares','MedicoController@cargarAntecedentesFamiliares')->name('cargarantecedentesfamiliares');
	
	Route::post('cargar_antecedentes_neonantales_nota','MedicoController@cargarAntecedentesNeonantalesNota')->name('cargarantecedentesneonantalesnota');
	
	Route::post('cargar_numero_interconsulta','MedicoController@cargarNumeroInterconsulta')->name('cargarnumerointerconsulta');
	
	Route::post('cargar_interconsulta','MedicoController@cargarInterconsulta')->name('cargarinterconsulta');
	
	Route::post('guardar_interconsultores','MedicoController@guardarinterconsultores')->name('guardarinterconsultores');
	
	Route::get('interconsultores_listado_buscar','MedicoController@interconsultoresListadoBuscar')->name('interconsultoreslistadobuscar');
	
	Route::post('guardar_pendientes','MedicoController@guardarPendientes')->name('guardarpendientes');
	
	Route::post('cargar_pendientes','MedicoController@cargarPendientes')->name('cargarpendientes');
 });

// Aca van a ir todas las rutas que tiene acceso una secretaria.
Route::group(['middleware' => ['usuarioSecretaria']], function () {

	Route::get('/secretaria_home', function () {
	    return view('plantillas.plantilla_secretaria');
	});

	Route::get('nuevo_paciente','SecretariaController@nuevoPaciente')->name('nuevopaciente');	

	Route::get('actualizar_paciente','SecretariaController@actualizarPaciente')->name('actualizarpaciente');	

	Route::get('buscar_paciente','SecretariaController@buscarPaciente')->name('buscarpaciente');	

	Route::post('continuar_navegacion','SecretariaController@continuarNavegacion')->name('continuarnavegacion');

	Route::post('secretaria_actualizar_paciente_buscar','SecretariaController@actualizarPacienteBuscar')->name('secretariaactualizarpacientebuscar');

 });

// Aca van a ir todas las rutas que son publicas

Route::post('alta_paciente_medico_secretaria','PacienteController@altaPacienteMedicoSecretaria')->name('altapacientemedicosecretaria');

Route::post('consultar_paciente','PacienteController@consultarPaciente')->name('consultarpaciente');		

Route::post('actualizar_datos_paciente','PacienteController@actualizarDatosPaciente')->name('actualizardatospaciente');

Route::get('paciente_listado_buscar','PacienteController@pacienteListadoBuscar');						
