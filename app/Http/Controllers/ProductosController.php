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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // se muestran los productos ordenados por fecha de añadido


        

        if ($request->query()) {

            $listaCategorias = Categoria::orderBy('nombre', 'ASC')->get();

            $productos = (new Producto)->newQuery();

            if ($request->has('categorias')) {

                $categorias = Input::has('categorias') ? Input::get('categorias') : [];

                foreach ($categorias as $categoria) {
                    $productos->where('categoria_id', "=", $categoria);
                }

            }

            if ($request->get('precioMin') > 0) {
                $productos->where('precio', '>=', Input::get('precioMin'));
            }

            if ($request->has('precioMax')) {
                $productos->where('precio', '<=', Input::get('precioMax'));
            }

            $productos->where('vendido', '=', 'false');

            $productos = $productos->paginate(8);

            return view('index')->with(['productos' => $productos, 'listaCategorias' => $listaCategorias]);

        } else {

            $listaCategorias = Categoria::orderBy('nombre', 'ASC')->get();


            $productos = Producto::where('vendido', '=', 'false')->orderBy('created_at', 'desc')->paginate(8);

            self::creado_desde($productos);

            return view('index')->with(['productos' => $productos, 'listaCategorias' => $listaCategorias]);

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $this->validate($request, [
            'imagen.*' => 'image|mimes:jpeg,png,jpg|max:2048',

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


        Flash::success('tu producto '.$producto->nombre." se ha creado correctamente");

        return redirect()->route('index');
    }

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function modificar_producto(Request $request, $id)
    {
        try {

            $producto = Producto::find($id);

            $producto->fill($request->all());

            $producto->save();

            Flash::success('El Producto ' . $producto->nombre . ' se actualizo correctamente');

            return redirect()->route('ver_productos_usuario', $producto->user_id);

        } catch (Exception $exception) {

            Flash::error('no se ha podido actualizar el Producto');
            return redirect()->route('ver_productos_usuario');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
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
            }else{
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

            return view('productos.ver-producto-individual.index')->with('producto', $producto)->with('imagenes', $imagenes)->with('producto_favorito', $producto_favorito);
        } else {
            Flash::error('El producto no existe');

            return redirect()->route('index');
        }

    }

    /**
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

                    Flash::error(' No tienes ningún producto subido');

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


                 $respuesta='si';

                  return response()->json($respuesta);


            } else if ($comprobar_favorito != null && $producto->user_id != $user_id) {
                $producto_favorito = ProductoFavorito::find($comprobar_favorito->id);

                $producto_favorito->delete();

      $respuesta='no';

                  return response()->json($respuesta);

             }else{
                  Flash::info('No puedes poner tu propio producto en favoritos');
                  $respuesta='no';

                  return response()->json($respuesta);
              }

        }catch (Exception $exception){
             Flash::error('Ha ocurriodo un error');

             return redirect()->route('index');


        }
    }
    public function ver_productos_usuario_favoritos($id)
    {
        if (auth()->user()->id == $id) {

            try {
                $productos_favoritos = ProductoFavorito::where('user_id', '=', $id)->get();

                if (count($productos_favoritos) > 0) {
                    foreach ($productos_favoritos as $producto_favorito) {

                        $productos = Producto::where('id', '=', $producto_favorito->producto_id)->orderby('created_at', 'desc')->paginate(8);

                    }
                    self::creado_desde($productos);

                    return view('productos.productos-usuario-favoritos.index')->with('productos', $productos)->with('productos_favoritos', $productos_favoritos);

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
    public function comprobar_producto_favorito($producto, $user)
    {

        $producto_favorito = ProductoFavorito::where('producto_id', '=', $producto->id)->where('user_id', '=', $user->id)->first();

        if ($producto_favorito != null) {

            return $producto_favorito = true;
        }
        return $producto_favorito = false;
    }

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
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function guardar_venta_producto_vendedor(Request $request,$id)

    {
        try {

            $producto = Producto::find($id);
            if ($producto != null) {

                if (auth()->user()->id == $producto->user_id) {
                    // saca el usuario al que le vende el producto
                    $user_venta = User::where('nombre_usuario', '=', $request->nombre_usuario)->first();
                    if ($user_venta != null) {

                        //añade los valores a la tabla de articulos vendidos
                        $producto_vendido = new ProductoVendido();

                        $producto_vendido->producto_id = $id;

                        $producto_vendido->user_id = auth()->user()->id;

                        $producto_vendido->vendido_a = $user_venta->id;

                        $producto_vendido->valoracion_venta_vendedor = $request->valoracion_venta;

                        $producto_vendido->comentario_venta_vendedor = $request->comentario_venta;

                        $producto_vendido->precio_venta = $request->precio_venta;

                        $producto_vendido->notificacion = "true";

                        $producto_vendido->save();


                        $producto->vendido='true';

                        $producto->save();

                        Flash::success('venta guardada correctamente');

                        return redirect()->route('ver_productos_usuario', auth()->user()->id);
                    } else {
                        Flash::error('no existe el usuario');
                        return back()->withInput();
                    }
                } else {
                    return redirect()->route('error_403');
                }
            } else {
                Flash::error('no existe el poducto');
                return redirect()->route('ver_productos_usuario', auth()->user()->id);
            }

        }catch (Exception $exception){

            Flash::error('ha ocurrido un error');
            return redirect()->route('index');
        }
    }


    public function valoracion_compra($id){
        $venta= ProductoVendido::find($id);

        $producto = Producto::where('id','=',$venta->producto_id)->first();
        $user = User::where('id','=',$venta->vendido_a)->first();

        return view('productos.vender-producto.comprador.index')->with('venta',$venta)
                                                                ->with('producto',$producto)
                                                                ->with('user',$user);
    }

    public function guardar_valoracion_comprador(Request $request,$id){
        $venta = ProductoVendido::find($id);

        $user = User::where('id','=',$venta->vendido_a)->first();

        $venta->valoracion_venta_comprador=$request->valoracion_compra;

        $venta->comentario_venta_comprador=$request->comentario_compra;

        $venta->notificacion='false';

        $venta->save();

        return redirect()->route('perfil_publico',$user->id);
    }

}
