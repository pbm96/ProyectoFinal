<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Imagen;
use App\Producto;
use App\ProductoFavorito;
use App\ProductoVendido;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Laracasts\Flash\Flash;

class ProductosController extends Controller
{

    /** Si el usuario quiere filtrar productos se llama a la funcion filtrarProductos()
     *  Si no quiere, se muestran todos los productos
     */
    public function index(Request $request)
    {

        $listaCategorias = Categoria::orderBy('nombre', 'ASC')->get();

        $productos = ($request->query()) ? $this->filtrarProductos($request->query()) : Producto::where('vendido', '=', 'false')->orderBy('created_at', 'desc');

        $productos = $productos->paginate(8);
        

        self::creado_desde($productos);

        return view('index')->with(['productos' => $productos, 'listaCategorias' => $listaCategorias]);

    }



    /** Filtra los productos */
    public function filtrarProductos(array $filtro)
    {
        try {
            $productos = (new Producto)->newQuery();
            if (Input::get('buscar') != null) {
                $buscador = Input::get('buscar');

                $productos = Producto::where(function ($query) use ($buscador) {
                    $query->where('nombre', 'like', '%' . $buscador . '%')
                        ->orWhere('descripcion', 'like', '%' . $buscador . '%')
                        ->where('vendido', '=', 'false');

                    return $query;
                });
                if (count($productos->get()) <= 0) {
                    Flash::error('No se encontró ningún producto');
                }
            } else {
                $productos->where('vendido', '=', 'false');
            }

            if (isset($filtro['slider'])) {
                $productos->whereBetween('precio', explode(',', $filtro['slider']));
            }

            if (isset($filtro['categoriasSeleccionadas'])) {

                $categoriasSeleccionadas = $filtro['categoriasSeleccionadas'];

                $productos->where(function ($query) use ($categoriasSeleccionadas, $productos) {

                    foreach ($categoriasSeleccionadas as $posicion => $categoria) {
                        $query->orWhere('categoria_id', "=", $categoria);
                    }

                    return $query;
                });
            }

            if (isset($filtro['orden'])) {
                $orden = explode(',', $filtro['orden']);
                if ($orden[0] === 'created_at' || $orden[0] === 'precio') {
                    $productos->orderBy($orden[0], $orden[1]);
                }

            }

            return $productos;

        } catch (Exception $exception) {

            Flash::error('Ha ocurrido un error al filtrar los productos');
            return redirect()->route('index');

        }

    }

    /**
     * Funcion para llamar a la vista de crear un producto
     *e.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // se crea el select de las categorias para los productos
        $categorias = Categoria::orderBy('nombre', 'ASC')->pluck('nombre', 'id');
        return view('productos.crear-producto.index')->with('categorias', $categorias);

    }

    /**
     * Funcion para guardar un producto
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $this->validate($request, [
            'imagen.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'nombre' => 'string|required|max:191',
            'precio' => 'numeric|required',
            'descripcion'=> 'string|required|max:500'
        ]);
        $producto = new Producto($request->all());
        // introducir id de usuario autentificado en tabla productos
        $producto->user_id = \Auth::user()->id;
        $producto->save();
//        manipular imagenes
        if ($request->hasFile('imagen')) {
            $contador_imagenes = 0;
            $nombre_imagen = '';
            foreach ($request->file('imagen') as $imagen) {
                //pongo nombre a la imagen
                $nombre_imagen = 'fakeapop_' . time() . $contador_imagenes . '.' . $imagen->getClientOriginalExtension();
                // se guarda en la carpeta de public
                $path = public_path() . '/imagenes/productos/';
                $imagen->move($path, $nombre_imagen);
                //contador para si hay varias imagenes que se llamen diferente
                $contador_imagenes = $contador_imagenes + 1;
                //se guardan las imagenes en la base de datos
                $imagen = new Imagen();
                $imagen->nombre = $nombre_imagen;
                // llamar a metodo producto en modelo 'Imagen' y asociarle el producto al que pertenece esa imagen
                $imagen->producto()->associate($producto);
                $imagen->save();
            }
        }
        Flash::success('tu producto ' . $producto->nombre . " se ha creado correctamente");

        return redirect()->route('index');
    }

    /**
     * funcion que llama a la vista de editar un producto
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {

        $producto = Producto::find($id);

        $categorias = Categoria::orderBy('nombre', 'ASC')->pluck('nombre', 'id');

        if (auth()->user()->id == $producto->user_id) {

            return view('productos.editar-producto.index')->with('producto', $producto)->with('categorias', $categorias);

        } else {

            return redirect()->route('error_403');
        }

    }

    /**
     * Funcion para editar un producto
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function modificar_producto(Request $request, $id)
    {
            $this->validate($request, [
                'imagen.*' => 'image|mimes:jpeg,png,jpg|max:2048',
                'nombre' => 'string|required|max:191',
                'precio' => 'numeric|required',
                'descripcion'=> 'string|required|max:500'

            ]);
        try {
            $producto = Producto::find($id);


            Imagen::where('producto_id', '=', $id)->delete();

            $producto->fill($request->all());

            $producto->save();

            //        manipular imagenes
            if ($request->hasFile('imagen')) {
                
                $contador_imagenes = 0;
                $nombre_imagen = '';
                foreach ($request->file('imagen') as $imagen) {
                    //pongo nombre a la imagen
                    $nombre_imagen = 'fakeapop_' . time() . $contador_imagenes . '.' . $imagen->getClientOriginalExtension();
                    // se guarda en la carpeta de public
                    $path = public_path() . '/imagenes/productos/';
                    $imagen->move($path, $nombre_imagen);
                    //contador para si hay varias imagenes que se llamen diferente
                    $contador_imagenes = $contador_imagenes + 1;
                    //se guardan las imagenes en la base de datos
                    $imagen = new Imagen();
                    $imagen->nombre = $nombre_imagen;
                    // llamar a metodo producto en modelo 'Imagen' y asociarle el producto al que pertenece esa imagen
                    $imagen->producto()->associate($producto);
                    $imagen->save();
                }
            }

            Flash::success('El Producto ' . $producto->nombre . ' se actualizó correctamente');

            return redirect()->route('ver_productos_usuario', \Auth::user()->id);

        } catch (Exception $exception) {
            dd($exception);
            Flash::error('No se ha podido actualizar el Producto');

            return redirect()->route('ver_productos_usuario',auth()->user()->id);

        }
    }

    /**
     * Funcion para eliminar un producto
     *
     * @param  int $id
     * @return string
     */
    public function destroy($id)
    {
        try {

            $producto = Producto::find($id);

            $user_id = $producto->user_id;

            if (auth()->user()->id == $user_id) {
                if ($producto->vendido == 'false') {

                    $producto->delete();

                    Flash::success(' El producto se ha eliminado correctamente ');

                    return redirect()->route('ver_productos_usuario', auth()->user()->id);
                } else {
                    return redirect()->route('error_403');
                }

            } else {

                return redirect()->route('error_403');
            }
        } catch (Exception $exception) {

            Flash::error(' No se ha podido eliminar el producto ');

            return redirect()->route('ver_productos_usuario', auth()->user()->id);

        }

    }

    /**
     * funcion para ver la vista de un producto en concreto
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ver_producto_completo($id)
    {
        $producto = Producto::find($id);

        $user = auth()->user();

        if ($user) {

            $producto_favorito = self::comprobar_producto_favorito($producto, $user);

        } else {

            $producto_favorito = false;
        }

        if (!empty($producto)) {

            $imagenes = $producto->imagen;

            $usuario_producto = User::where('id', '=', $producto->user_id)->first();

            return view('productos.ver-producto-individual.index')->with('producto', $producto)
                ->with('imagenes', $imagenes)
                ->with('usuario_producto', $usuario_producto)
                ->with('producto_favorito', $producto_favorito);
        } else {
            Flash::error('El producto no existe');

            return redirect()->route('index');
        }

    }

    /**
     * saca todos los productos del usuario
     * @param $id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function ver_productos_usuario($id)
    {
        if (auth()->user()->id == $id) {

            try {
                $productos = Producto::where('user_id', '=', $id)->where('vendido', '=', 'false')->orderBy('created_at', 'desc')->paginate(8);

                if (count($productos) > 0) {
                    self::creado_desde($productos);

                    return view('productos.productos-usuario.index')->with('productos', $productos);
                } else {

                    return view('productos.productos-usuario.index')->with('productos', $productos);
                }
            } catch (Exception $exception) {

                Flash::error(' Ha ocurrido un error');
                return redirect()->route('index');
            }

        } else {

            return redirect()->route('error_403');
        }
    }

    /**
     * Esta funcion pone el producto como favorito de un usuario
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function producto_favorito($id)
    {
        try {

            $comprobar_favorito = ProductoFavorito::where('producto_id', '=', $id)->first();

            $producto = Producto::find($id);

            $user_id = auth()->user()->id;

            if ($comprobar_favorito == null && $producto->user_id != $user_id) {

                $producto_favorito = new ProductoFavorito;

                $producto_favorito->user_id = $user_id;

                $producto_favorito->producto_id = $producto->id;

                $producto_favorito->save();

                $respuesta = 'si';

                return response()->json($respuesta);

            } else if ($comprobar_favorito != null && $producto->user_id != $user_id) {
                $producto_favorito = ProductoFavorito::find($comprobar_favorito->id);

                $producto_favorito->delete();

                $respuesta = 'no';

                return response()->json($respuesta);

            } else {
                $respuesta = 'no';

                return response()->json($respuesta);
            }

        } catch (Exception $exception) {
            Flash::error('Ha ocurriodo un error');

            return redirect()->route('index');

        }
    }

    /**
     * funcion que saca todos los productos favoritos del usuario
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function ver_productos_usuario_favoritos($id)
    {
        if (auth()->user()->id == $id) {

            try {

                $productos_favoritos = ProductoFavorito::where('user_id', '=', $id)->orderBy('created_at', 'desc')->paginate(8);

                if (count($productos_favoritos) > 0) {

                    foreach ($productos_favoritos as $producto) {

                        $producto->nombre = $producto->producto->nombre;

                        $producto->precio = $producto->producto->precio;

                        $producto->created_at = $producto->producto->created_at;

                    }

                    self::creado_desde($productos_favoritos);


                    return view('productos.productos-usuario-favoritos.index')->with('productos_favoritos', $productos_favoritos);

                } else {
                    return view('productos.productos-usuario-favoritos.index')->with('productos_favoritos', $productos_favoritos);
                }
            } catch (Exception $exception) {
                dd($exception);
                Flash::error(' Ha ocurrido un error');
                return redirect()->route('index');
            }

        } else {

            return redirect()->route('error_403');
        }
    }

    /**
     * funcion para mostrar el tiempo desde que se ha creado el producto
     * @param $productos
     * @return mixed
     */

    public function creado_desde($productos)
    {

        $fecha_actual = Carbon::now();
        foreach ($productos as $producto) {

            $fecha_producto = $producto->created_at;

            $diferencia = $fecha_actual->diff($fecha_producto);

            switch ($diferencia) {
                case $diferencia->y > 0:

                    $diferencia->y > 1 ? $producto->diferencia = $diferencia->y . " años" : $producto->diferencia = $diferencia->y . " año";
                    break;

                case $diferencia->m > 0:

                    $diferencia->m > 1 ? $producto->diferencia = $diferencia->m . " meses" : $producto->diferencia = $diferencia->m . " mes";
                    break;

                case $diferencia->d > 0:
                    $diferencia->d > 1 ? $producto->diferencia = $diferencia->d . " dias" : $producto->diferencia = $diferencia->d . " dia";

                    break;

                case $diferencia->h > 0:
                    $diferencia->h > 1 ? $producto->diferencia = $diferencia->h . " horas" : $producto->diferencia = $diferencia->h . " hora";
                    break;

                case $diferencia->i > 0:
                    $diferencia->i > 1 ? $producto->diferencia = $diferencia->i . " minutos" : $producto->diferencia = $diferencia->i . " minuto";

                    break;

                case $diferencia->s > 0:
                    $diferencia->s > 1 ? $producto->diferencia = $diferencia->s . " segundos" : $producto->diferencia = $diferencia->s . " segundo";
                    break;
                case $diferencia->f < 0:
                    $producto->diferencia = " 1 segundo";
                    break;

            }

        }

        return $productos;
    }

    /**
     * funcion que comprueba si el producto es ya producto favorito del usuario
     * @param $producto
     * @param $user
     * @return bool
     */
    public function comprobar_producto_favorito($producto, $user)
    {

        $producto_favorito = ProductoFavorito::where('producto_id', '=', $producto->id)->where('user_id', '=', $user->id)->first();

        if ($producto_favorito != null) {

            return $producto_favorito = true;
        }
        return $producto_favorito = false;
    }

    /**
     * funcion para ver la vista de vender un producto
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function vender_producto($id)
    {
        try {

            $producto = Producto::find($id);

            if ($producto != null) {
                if (auth()->user()->id == $producto->user_id) {

                    return view('productos.vender-producto.vendedor.index')->with('producto', $producto);

                } else {

                    return redirect()->route('error_403');

                }
            } else {

                Flash::error('no se encontro el producto');

                return back();
            }
        } catch (Exception $exception) {

            Flash::error('ha ocurrido un error');
            return redirect()->route('index');
        }

    }

    /**
     * funcion para guardar ala venta de un producto
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function guardar_venta_producto(Request $request, $id)
    {

            $this->validate($request, [
                'nombre_usuario' => 'string|required|max:191',
                'precio_venta' => 'numeric|required',
                'valoracion_venta'=> 'numeric|nullable|digits:1|max:5|min:0',
                'comentario_venta' =>'string|max:191|nullable'

            ]);
        try {
            $producto = Producto::find($id);
            if ($producto != null) {

                if (auth()->user()->id == $producto->user_id) {
                    // saca el usuario al que le vende el producto
                    $user_venta = User::where('nombre_usuario', '=', $request->nombre_usuario)->first();
                        if ($user_venta != null) {

                            if (auth()->user()->id != $user_venta->id) {
                            //añade los valores a la tabla de articulos vendidos
                            $producto_vendido = new ProductoVendido();

                            $producto_vendido->producto_id = $id;

                            $producto_vendido->user_id = auth()->user()->id;

                            $producto_vendido->vendido_a = $user_venta->id;

                            $producto_vendido->valoracion_venta_vendedor = $request->valoracion_venta;

                            if ($request->valoracion_venta != null) {
                                self::calcular_valoracion_usuario($request->valoracion_venta, $user_venta);
                            }

                            $producto_vendido->comentario_venta_vendedor = $request->comentario_venta;

                            $producto_vendido->precio_venta = $request->precio_venta;

                            $producto_vendido->notificacion = "true";

                            $producto_vendido->save();

                            $producto->vendido = 'true';

                            $producto->save();

                            Flash::success('venta guardada correctamente');

                            return redirect()->route('ver_productos_usuario', auth()->user()->id);
                            }else{
                                Flash::error('No puedes venderte el producto a ti mismo');
                                return back()->withInput();
                            }
                        } else {

                            Flash::error('No existe el usuario');
                            return back()->withInput();
                        }

                } else {
                    return redirect()->route('error_403');
                }
            } else {
                Flash::error('No existe el poducto');
                return redirect()->route('ver_productos_usuario', auth()->user()->id);
            }

        } catch (Exception $exception) {
            Flash::error('Ha ocurrido un error al vender el producto');
            return redirect()->route('perfil_publico', auth()->user()->id);
        }
    }

    /**
     * funcion para que un usuario valore la compra de un producto
     * @param $id
     * @return mixed
     */
    public function valoracion_compra($id)
    {

        $venta = ProductoVendido::find($id);

        $producto = Producto::where('id', '=', $venta->producto_id)->first();
        $user = User::where('id', '=', $venta->vendido_a)->first();

        return view('productos.vender-producto.comprador.index')->with('venta', $venta)
            ->with('producto', $producto)
            ->with('user', $user);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function guardar_valoracion_comprador(Request $request, $id)
    {

        $this->validate($request, [
            'valoracion_venta'=> 'numeric|nullable|digits:1|max:5|min:0',
            'comentario_venta' =>'string|max:191|nullable'

        ]);
        try {
            $venta = ProductoVendido::find($id);

            $user_comprador = User::where('id', '=', $venta->user_id)->first();

            $user = User::where('id', '=', $venta->vendido_a)->first();


            $venta->valoracion_venta_comprador = $request->valoracion_compra;

            if ($request->valoracion_compra != null) {
                self::calcular_valoracion_usuario($request->valoracion_compra, $user_comprador);
            }

            $venta->comentario_venta_comprador = $request->comentario_compra;

            $venta->notificacion = 'false';

            $venta->save();

            return redirect()->route('perfil_publico', $user->id);
        }catch (Excption $exception){
            Flash::error('Ha ocurrido un error al guardar la valoracion');
            return redirect()->route('index');
        }
    }

    /**
     * funcion para que un usuario no quiera valorar la compra
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelar_valoracion($id)
    {
        $producto = ProductoVendido::find($id);

        $producto->comentario_venta_comprador = null;

        $producto->valoracion_venta_comprador = null;

        $producto->notificacion = "false";

        $producto->save();

        return redirect()->route('perfil_publico', auth()->user()->id);

    }

    /*
     * funcion para calcular la valoracion del usuario
     * @param $valoracion
     * @param $usuario
     * @return bool
     */
    public function calcular_valoracion_usuario($valoracion, $usuario)
    {
        try {

            $user = User::find($usuario->id);

            $user->valoracion = ($user->valoracion + $valoracion) / 2;

            $user->save();

            return true;

        } catch (Exception $exception) {

            return false;
        }

    }

}
