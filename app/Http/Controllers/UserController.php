<?php

namespace App\Http\Controllers;

use App\Direccion;
use App\Producto;
use App\ProductoVendido;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Laracasts\Flash\Flash;
use Exception;
use App\Http\Controllers\ProductosController;


class UserController extends Controller
{

    public function __construct(ProductosController $productosController
    )
    {
        $this->productosController = $productosController;

    }

    /**
     * funcion que devuelve la vista de editar perfil
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function modificar_perfil($id)
    {
        $usuario = User::find($id);


        if (auth()->user() == $usuario) {
            $productos_vendidos = Producto::where('user_id', '=', $usuario->id)->where('vendido', '=', 'true')->get();

            $productos = Producto::where('user_id', '=', $usuario->id)->get();

            $direccion = $usuario->direccion;

            return view('usuarios.administar-perfil')->with('usuario', $usuario)
                ->with('direccion', $direccion)
                ->with('productos_vendidos', $productos_vendidos)
                ->with('productos', $productos);

        } else {
            return redirect()->route('error_403');
        }
    }

    /**
     * funcion qu edita los datos de un usuario
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function guardar_perfil(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'confirmed|string|min:6|max:191',
            'nombre' => 'required|alpha|max:30',
            'apellido1'=>'required|alpha|max:30',
            'apellido2'=>'alpha|max:30',
            'nombre_usuario'=>'required|alpha_num|max:30|unique:users,nombre_usuario,'.$id,
            'email' => 'required|email|max:191|unique:users,email,'.$id,
            'direccion' => 'nullable|string',
            'telefono' => 'numeric|digits:9|nullable',
            'cityLat' =>'required_with:direccion',
            'cityLng' => 'required_with:direccion',

        ]);
        try {
            $usuario = User::find($id);

            $usuario->direccion_id = self::direccion($request->direccion, $request->cityLat, $request->cityLng);

            $nombre_imagen = '';
            if ($request->hasFile('imagen')) {
                $imagen = $request->imagen;


                $nombre_imagen = 'fakeapop_' . time() . '.' . $imagen->getClientOriginalExtension();

                // se guarda en la carpeta de public
                $path = public_path() . '/imagenes/perfil/';

                $imagen->move($path, $nombre_imagen);


            }
            $usuario->fill($request->all());
            if ($request->password){

                $usuario->password = Hash::make($request->password);

            }

            if($nombre_imagen!=''){

                $usuario->imagen = $nombre_imagen;

            }


            if ($usuario->isDirty()) {

                $usuario->save();

                Flash::success('El perfil se actualizó correctamente');
                return redirect()->route('administrar_perfil', auth()->user());

            } else {
                Flash::success('El perfil se actualizó correctamente');
                return redirect()->route('administrar_perfil', auth()->user());
            }

        } catch (Exception $exception) {
            
            Flash::error('no se ha podido actualizar el perfil');
            return redirect()->route('index');
        }


    }

    /**
     * funcion para la direccion del usuario
     * @param $direccion
     * @param $latitud
     * @param $longitud
     * @return mixed
     */
    public function direccion($direccion, $latitud, $longitud)
    {
        if ($direccion != "") {

            $direccion = Direccion::firstOrCreate([
                'nombre' => $direccion,
                'latitud' => $latitud,
                'longitud' => $longitud,
            ]);
            return $direccion->id;
        }


    }

    /**
     * funcion para borrar el perfil del usuario
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function borrar_perfil($id)
    {
        $usuario = User::find($id);
        try {
            $usuario->destroy($usuario->id);

            Flash::info('El usuario se borro correctamente :(');

            return redirect()->route('index');

        } catch (Exception $exception) {

            Flash::error('El usuario NO se borro correctamente :(');

            return redirect()->route('index');
        }
    }

    /**
     * funcion del perfil publico del usuario
     * @param $id
     * @return mixed
     */
    public function perfil_publico($id)
    {

        try {
            //usuario del perfil
            $usuario = User::find($id);

            if ($usuario != null) {
                $direccion = $usuario->direccion;

                // sacar fecha de la creacion del usuario
                $ano = Carbon::createFromFormat('Y-m-d H:i:s', $usuario->created_at)->year;

                $mes = Carbon::createFromFormat('Y-m-d H:i:s', $usuario->created_at)->month;

                $dia = Carbon::createFromFormat('Y-m-d H:i:s', $usuario->created_at)->day;

                $mes = $mes < 10 ? '0' . $mes : $mes;
                $dia = $dia < 10 ? '0' . $dia : $dia;

                $fecha_user = $dia . '-' . $mes . '-' . $ano;


                // productos del usuario que no se han vendido todavia
                $productos_user = Producto::where('user_id', '=', $usuario->id)->where('vendido', '=', 'false')->orderBy('created_at', 'desc')->get();

                $this->productosController->creado_desde($productos_user);

                //productos del usuario que se han vendido
                $productos_vendidos_user = Producto::where('user_id', '=', $id)->where('vendido', '=', 'true')->orderBy('created_at', 'desc')->get();

                $productos_comprados_user = ProductoVendido::where('vendido_a', '=', $usuario->id)->get();


                $this->productosController->creado_desde($productos_vendidos_user);


                //sacar los datos de la venta de los productos

                if (count($productos_vendidos_user) > 0) {
                    $datos_venta_producto = $usuario->vendedor;

                    // se necesitan sacar los datos del usuario al que se le ha vendido el producto y el comentario y valoracion

                    foreach ($datos_venta_producto as $datos) {

                        $datos_user_venta[] = User::where('id', '=', $datos->vendido_a)->first();
                    }
                } else {
                    $datos_venta_producto = null;
                    $datos_user_venta = '';
                }
                if (count($productos_comprados_user) > 0) {

                    foreach ($productos_comprados_user as $producto) {

                        $datos_user_compra[] = User::where('id', '=', $producto->user_id)->first();
                    }
                } else {
                    $productos_comprados_user = '';
                    $datos_user_compra = '';
                }


                return view('usuarios.perfil-publico.index')->with('usuario', $usuario)
                    ->with('productos_user', $productos_user)
                    ->with('productos_vendidos_user', $productos_vendidos_user)
                    ->with('datos_venta_producto', $datos_venta_producto)
                    ->with('productos_comprados_user', $productos_comprados_user)
                    ->with('datos_user_venta', $datos_user_venta)
                    ->with('datos_user_compra', $datos_user_compra)
                    ->with('direccion', $direccion)
                    ->with('fecha_user', $fecha_user);
            } else {
                Flash::error('No existe el usuario');
                return redirect()->route('index');
            }
        }catch (Exception $exception){
            Flash::error('Ha ocurrido un error');
            return redirect()->route('index');
        }

    }

    /**
     * fucion que comprueba que la contraseña introducida para cambiar es la misma que la actual del usuario
     * @param Request $request
     * @param $id
     * @return string
     */
    public function comprobar_password(Request $request, $id)
    {
        if (auth()->user()->id == $id) {
            $user = User::find($id);

            $old_password = $request->password;

            if (Hash::check($old_password, $user->password)) {

                return 'true';

            } else {
                return 'false';
            }
        }
    }

    /**
     * funcion para mostrar un autocomplete con los usuarios para vender el producto
     * @param Request $request
     * @return array|string
     */

    public function autocomplete_usuarios(Request $request)
    {
        $usuario = $request->usuario;
        $users = User::where('nombre_usuario', 'like', '%' . $usuario . '%')->take(5)->get();


        if (count($users)>0) {
            foreach ($users as $user) {
                if ($user->imagen == null || $user->imagen == '') {
                    $user->imagen = 'user-default.png';
                }
                $results[] = ['label' => $user->nombre_usuario, 'imagen' => $user->imagen, 'value' => $user->nombre_usuario];
            }
        }else{
            $results='';
        }

        return $results;
    }


}
