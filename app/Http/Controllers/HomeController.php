<?php

namespace App\Http\Controllers;

use App\Producto;
use App\ProductoVendido;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function notificaciones()
    {
        $notificaciones = ProductoVendido::where('vendido_a', '=', auth()->user()->id)->where('notificacion', '=', 'true')->get();
        foreach ($notificaciones as $notificacion) {

            $producto = Producto::find($notificacion->id);

            $notificacion->nombre_producto =$producto->nombre;
        }
        if (count($notificaciones) <= 0) {
            $notificaciones = '';
        };

        return response()->json(
            $notificaciones
        );
    }


    public function about()
    {
        return view('/about');
    }

    public function contact()
    {
        return view('/contact');
    }

    public function mapaweb()
    {
        return view('/MapaWeb');
    }
}
