<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Imagen;
use App\Producto;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // se muestran los productos ordenados por fecha de añadido
      $productos= Producto::orderBy('created_at','desc')->paginate(8);
        return view('index')->with('productos',$productos);
    }

    /**
     * Funcion para llamar a la vista de crear un producto
     *e.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // se crea el select de las categorias para los productos
        $categorias=Categoria::orderBy('nombre','ASC')->pluck('nombre','id');
        return view('productos.crear-producto.index')->with('categorias',$categorias);

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
            'imagen' => 'image'

        ]);
        $nombre_imagen='';
//        manipular imagenes
        if($request->file('imagen')){
            $file=$request->file('imagen');
            $nombre_imagen='fakeapop_'.time().'.'.$file->getClientOriginalExtension();
            $path=public_path().'/imagenes/productos/';
            $file->move($path,$nombre_imagen);
        }

        $producto = new Producto($request->all());
        // introducir id de usuario autentificado en tabla productos
        $producto->user_id=\Auth::user()->id;
        $producto->save();

        if($nombre_imagen!=""){
        $imagen = new Imagen();
        $imagen->nombre= $nombre_imagen;
        // llamar a metodo producto en modelo 'Imagen' y asociarle el producto al que pertenece esa imagen
        $imagen->producto()->associate($producto);
        $imagen->save();
            }
        Flash::success('tu producto '.$producto->nombre." se ha creado correctamente");
        return redirect()->route('index');
    }



    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return string
     */
    public function destroy($id)
    {
        //prueba de borrar un producto
        $producto= Producto::find($id);
        if ($producto!=null) {
            $producto->delete();
        }
        else {
            return (' no hay productos');
        }

    }


    public function  ver_producto_completo($id){
        //prueba de buscar un producto
        $producto=Producto::find($id);

       $imagenes=$producto->imagen ;




        return view('productos.ver-producto-individual.index')->with('producto',$producto)->with('imagenes',$imagenes);


}
}
