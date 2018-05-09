<?php

namespace App\Http\Controllers;

use App\Direccion;
use App\Producto;
use App\ProductoVendido;
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

    public function perfil_publico($id){

        //usuario del perfil
        $usuario = User::find($id);

        // productos del usuario que no se han vendido todavia
        $productos_user= Producto::where('user_id', '=', $usuario->id)->where('vendido','=','false')->orderBy('created_at', 'desc')->paginate(12);

        //productos del usuario que se han vendido
        $productos_vendidos_user =   Producto::where('user_id', '=', $id)->where('vendido','=','true')->orderBy('created_at', 'desc')->paginate(12);



        //sacar los datos de la venta de los productos

        $datos_venta_producto= $usuario->vendedor->sortByDesc('created_at');



        // se necesitan sacar los datos del usuario al que se le ha vendido el producto y el comentario y valoracion

        foreach ($datos_venta_producto as $datos) {

            $datos_user_venta[]= User::where('id','=',$datos->vendido_a)->first();
            
        }





       return view('usuarios.perfil-publico.index')->with('usuario',$usuario)
                                                        ->with('productos_user',$productos_user)
                                                        ->with('productos_vendidos_user',$productos_vendidos_user)
                                                        ->with('datos_venta_producto',$datos_venta_producto)
                                                        ->with('datos_user_venta',$datos_user_venta);

    }




}
