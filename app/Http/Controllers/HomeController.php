<?php

namespace App\Http\Controllers;

use App\Mensaje;
use App\Producto;
use App\ProductoVendido;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

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
     * Notificaciones de mensajes y productos vendidos usuario
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function notificaciones()
    {
        $notificaciones = ProductoVendido::where('vendido_a', '=', auth()->user()->id)->where('notificacion', '=', 'true')->get();

        $mensajes = Mensaje::where('recibido_id','=',auth()->user()->id)->where('visto','=','false')->get();

        foreach ($notificaciones as $notificacion) {

            $producto = Producto::find($notificacion->producto_id);

            $notificacion->nombre_producto =$producto->nombre;
        }

        foreach ($mensajes as $mensaje) {
            $mensaje->user = $mensaje->user_enviado->nombre_usuario;
        }
        if (count($notificaciones) <= 0) {
            $notificaciones = '';
        };

        if (count($mensajes) <= 0) {
            $mensajes = '';
        };



        return response()->json(['notificaciones'=>$notificaciones, 'mensajes'=>$mensajes]

        );
    }

    /**
     * vista about
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        return view('/about');
    }

    /**
     * vista contacto
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact()
    {
        return view('/contact');
    }

    /** Vista mapa web
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function mapaweb()
    {
        return view('/MapaWeb');
    }
    public function mensaje_contacto(Request $request){

        Flash::success('Tu propuesta se ha enviado correctamente ');

            return view('/contact');
    }
}
