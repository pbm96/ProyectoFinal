<?php

namespace App\Http\Controllers;

use App\Direccion;
use App\Producto;
use App\ProductoVendido;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Laracasts\Flash\Flash;
use Exception;
use App\Http\Controllers\ProductosController;


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
       $direccion= $usuario->direccion;

        $ano = Carbon::createFromFormat('Y-m-d H:i:s', $usuario->created_at)->year;

            $mes = Carbon::createFromFormat('Y-m-d H:i:s', $usuario->created_at)->month;

            $dia =Carbon::createFromFormat('Y-m-d H:i:s', $usuario->created_at)->day;

            $mes=$mes<10?'0'.$mes:$mes;
            $dia=$dia<10?'0'.$dia:$dia;
            
            $fecha_user=$dia.'-'.$mes.'-'.$ano;


        // productos del usuario que no se han vendido todavia
        $productos_user= Producto::where('user_id', '=', $usuario->id)->where('vendido','=','false')->orderBy('created_at', 'desc')->paginate(12);

        $this->productosController->creado_desde($productos_user);

        //productos del usuario que se han vendido
        $productos_vendidos_user =   Producto::where('user_id', '=', $id)->where('vendido','=','true')->orderBy('created_at', 'desc')->paginate(12);

        $this->productosController->creado_desde($productos_vendidos_user);


        //sacar los datos de la venta de los productos
            if(count($productos_vendidos_user)>0) {
                $datos_venta_producto = $usuario->vendedor;

                // se necesitan sacar los datos del usuario al que se le ha vendido el producto y el comentario y valoracion

                foreach ($datos_venta_producto as $datos) {

                    $datos_user_venta[] = User::where('id', '=', $datos->vendido_a)->first();
                }
            }else{
                $datos_venta_producto=null;
                $datos_user_venta='';
            }


       return view('usuarios.perfil-publico.index')->with('usuario',$usuario)
                                                        ->with('productos_user',$productos_user)
                                                        ->with('productos_vendidos_user',$productos_vendidos_user)
                                                        ->with('datos_venta_producto',$datos_venta_producto)
                                                        ->with('datos_user_venta',$datos_user_venta)
                                                        ->with('direccion',$direccion)
                                                        ->with('fecha_user',$fecha_user);


    }




}
