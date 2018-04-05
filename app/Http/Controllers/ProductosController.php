<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Imagen;
use App\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('productos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias=Categoria::orderBy('nombre','ASC')->pluck('nombre','id');
        return view('productos.crear_producto')->with('categorias',$categorias);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'imagen' => 'required|image'

        ]);
//        manipular imagenes
        if($request->file('imagen')){
            $file=$request->file('imagen');
            $nombre_imagen='fakeapop_'.time().'.'.$file->getClientOriginalExtension();
            $path=public_path().'/imagenes/productos/';
            $file->move($path,$nombre_imagen);
        }
        $producto = new Producto($request->all());
        $producto->user_id=\Auth::user()->id;
        $producto->save();



        $imagen = new Imagen();
        $imagen->nombre= $nombre_imagen;
        $imagen->producto()->associate($producto);
        $imagen->save();
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
