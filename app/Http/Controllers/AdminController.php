<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\MedicoSecretaria;

class AdminController extends Controller
{
    
	public function __construct()
    {    	
        $this->middleware('auth');
    }

    public function vincularSecretariaMedico(Request $request)
    {
    	
		$medico_aux = explode('-',$request->get('medico'));
		$secretaria_aux = explode('-',$request->get('secretaria'));

		$sec_medico = new medicoSecretaria;
		$sec_medico->medico_user_id = $medico_aux[0];
		$sec_medico->secretaria_user_id = $secretaria_aux[0];    
		$sec_medico->activo = 1;    
    	$sec_medico->save();


    	$secretarias = DB::table('users')->where('usuario_tipo', 3)->get();
		$medicos = DB::table('users')->where('usuario_tipo', 2)->get();

    	return View('admin.admin_secretaria')
    	->with('secretarias',$secretarias)
    	->with('medicos',$medicos);   
    }
}
