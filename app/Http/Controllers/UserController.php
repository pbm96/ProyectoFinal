<?php

namespace App\Http\Controllers;

use App\Direccion;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;
use Exception;

class UserController extends Controller
{

    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function modificar_perfil($id){
        $usuario=User::find($id);


        if(auth()->user()==$usuario ){

            $direccion=$usuario->direccion;

            return view('usuarios.administar-perfil')->with('usuario',$usuario)->with('direccion',$direccion);

        }else{
            return redirect()->route('error_403');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function guardar_perfil(Request $request,$id){
      $usuario= User::find($id);

        try{

            $usuario->direccion_id=self::direccion($request->direccion,$request->cityLat,$request->cityLng);
            $usuario->fill($request->all());

            if ($usuario->isDirty()) {

                $usuario->save();

                Flash::success('El perfil se actualizo correctamente');
                return redirect()->route('index');

            }

        }catch (Exception $exception){
            Flash::error('no se ha podido actualizar el perfil');
            return redirect()->route('index');
        }


    }

    /**
     * @param $direccion
     * @param $latitud
     * @param $longitud
     * @return mixed
     */
    public function direccion($direccion, $latitud,$longitud){
        if($direccion!="") {
            $direccion= Direccion::firstOrCreate([
                'nombre' => $direccion,
                'latitud' => $latitud,
                'longitud' => $longitud,
            ]);
            return $direccion->id;
        }


    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function borrar_perfil($id){
        $usuario=User::find($id);
        try{
        $usuario->destroy($usuario->id);

            Flash::info('El usuario se borro correctamente :(');

            return redirect()->route('index');

        }catch (Exception $exception){

            Flash::error('El usuario NO se borro correctamente :(');

            return redirect()->route('index');
        }
    }




}
