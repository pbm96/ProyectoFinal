<?php

namespace App\Http\Controllers\Auth;

use App\Direccion;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Laracasts\Flash\Flash;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'nombre' => 'required|string|max:30',
            'apellido1'=>'required|string|max:30',
            'apellido2'=>'string|max:30',
            'nombre_usuario'=>'required|alpha_num|max:30|unique:users',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6|confirmed|max:191',
            'direccion' => 'nullable|string',
            'telefono' => 'numeric|digits:9|nullable',
            //falta imagen

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
        Flash::success('Bienvenido a Fakeapop'.$data['nombre_usuario']);
        $id_direccion= self::direccion($data['direccion'],$data['cityLat'],$data['cityLng']);
        return User::create([
            'nombre' => $data['nombre'],
            'apellido1' => $data['apellido1'],
            'apellido2' => $data['apellido2'],
            'nombre_usuario'=> $data['nombre_usuario'],
            'password' => Hash::make($data['password']),
            'direccion_id'=> $id_direccion,
            'telefono'=>$data['telefono'],
            'email'=>$data['email'],


            //falta imagen
        ]);
    }
    protected function direccion($direccion, $latitud,$longitud){
        if($direccion!="") {
           $direccion= Direccion::firstOrCreate([
                'nombre' => $direccion,
                'latitud' => $latitud,
                'longitud' => $longitud,
            ]);

            return $direccion->id;
        }


    }
}
