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
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function guardar_perfil(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'confirmed|string|min:6|max:191',
        ]);
        try {
            $usuario = User::find($id);

            $usuario->direccion_id = self::direccion($request->direccion, $request->cityLat, $request->cityLng);

            if ($request->hasFile('imagen')) {
                $imagen = $request->imagen;
                $nombre_imagen = '';
                $nombre_imagen = 'fakeapop_' . time() . '.' . $imagen->getClientOriginalExtension();

                // se guarda en la carpeta de public
                $path = public_path() . '/imagenes/perfil/';

                $imagen->move($path, $nombre_imagen);
                $usuario->imagen = $nombre_imagen;


            }
              $request->password = Hash::make($request->password);

            $usuario->fill($request->all());

            $usuario->password = $request->password;



            if ($usuario->isDirty()) {

                $usuario->save();

                Flash::success('El perfil se actualizo correctamente');
                return redirect()->route('administrar_perfil', auth()->user());

            } else {
                Flash::success('El perfil se actualizo correctamente');
                return redirect()->route('administrar_perfil', auth()->user());
            }

        } catch (Exception $exception) {
            dd($exception);
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

    public function perfil_publico($id)
    {


        //usuario del perfil
        $usuario = User::find($id);
        $direccion = $usuario->direccion;

        $ano = Carbon::createFromFormat('Y-m-d H:i:s', $usuario->created_at)->year;

        $mes = Carbon::createFromFormat('Y-m-d H:i:s', $usuario->created_at)->month;

        $dia = Carbon::createFromFormat('Y-m-d H:i:s', $usuario->created_at)->day;

        $mes = $mes < 10 ? '0' . $mes : $mes;
        $dia = $dia < 10 ? '0' . $dia : $dia;

        $fecha_user = $dia . '-' . $mes . '-' . $ano;


        // productos del usuario que no se han vendido todavia
        $productos_user = Producto::where('user_id', '=', $usuario->id)->where('vendido', '=', 'false')->orderBy('created_at', 'desc')->paginate(12);

        $this->productosController->creado_desde($productos_user);

        //productos del usuario que se han vendido
        $productos_vendidos_user = Producto::where('user_id', '=', $id)->where('vendido', '=', 'true')->orderBy('created_at', 'desc')->paginate(12);

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

    }

    public function comprobar_password(Request $request, $id)
    {
        if(auth()->user()->id== $id) {
            $user = User::find($id);

            $old_password = $request->password;

            if (Hash::check($old_password, $user->password)) {

                return 'true';

            } else {
                return 'false';
            }
        }
    }










}
