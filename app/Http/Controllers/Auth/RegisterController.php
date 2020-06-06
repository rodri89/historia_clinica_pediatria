<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

      public function registrar(Request $request)
    {            
        $user = new user;         
        $user->name = $request->get('surname').', '.$request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->usuario_tipo = $request->get('usuario_tipo');
        $user->perfil = 1;
        $user->foto = 'medico_sin_foto.png';
        $user->activo = 1;
        $user->save();        

        if ($request->get('usuario_tipo') == 3){ //secretaria
            /*$secretaria = new secretaria;
            $secretaria->nombre=$request->get('name');
            $secretaria->apellido=$request->get('surname');
            $secretaria->user_id= $user->id;
            $secretaria->save();*/
             return redirect('/secretaria_home');            
        }

        if ($request->get('usuario_tipo') == 2){ // medico
            return redirect('/medico_home');                                                    
        }

        if ($request->get('usuario_tipo') == 1){ // admin
            return redirect('/admin_home');                                           
        }
    }    
}
