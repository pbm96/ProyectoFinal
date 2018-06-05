<?php

namespace App\Http\Controllers;

use App\Mensaje;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Laracasts\Flash\Flash;

class MensajesController extends Controller
{
        public function mensajes_user($id)
        {
            $user = User::find($id);

            if (auth()->user()->id == $user->id) {

                $mensajes = Mensaje::where('user_id','=',$user->id)->orWhere('enviado_por','=',$user->id)->whereNotIn('conversacion_con',[$user->id])->orderBy('created_at','asc')->get()->groupBy('conversacion_con');


                    return view('mensajes.escribir-mensaje.index')->with('user', $user);

            }else{
                return redirect()->route('error_403');
            }
        }

    public function escribir_mensaje($id){





    }

    public function enviar_mensaje(Request $request,$id){
        try {
            $user = User::find($id);
            $enviado_por = auth()->user();
            if ($user != null) {
                $fecha = Carbon::now();

                $hora= $fecha->hour;

                $minutos= $fecha->minute;

                $dia = $fecha->day;

                $mes = self::sacar_mes_string($fecha->month);

                $mensaje = new Mensaje();

                $mensaje->user_id = $user->id;

                $mensaje->enviado_por = $enviado_por->id;

                $mensaje->cuerpo_mensaje = $request->cuerpo_mensaje;

                $mensaje->visto = 'false';

                $mensaje->save();


                return response()->json(['respuesta'=>true,'mensaje'=> $request->cuerpo_mensaje,'hora'=>$hora,'minutos'=>$minutos,'dia'=>$dia,'mes'=>$mes]);
            }else{
                return 'ha ocurrido un error';
            }

        }catch (Exception $exception){
            Flash::error('Ha ocurrido un error al enviar el mensaje');
        return redirect()->route('index');

        }

    }

    public function eliminar_mensaje($id){

    }

    public function sacar_mes_string($mes){
        switch ($mes){
            case 1:
                $mes= 'Enero';
                break;
            case 2:
                $mes= 'Febrero';
                break;
            case 3:
                $mes= 'Marzo';
                break;
            case 4:
                $mes= 'Abril';
                break;
            case 5:
                $mes= 'Mayo';
                break;
            case 6:
                $mes= 'Junio';
                break;
            case 7:
                $mes= 'Julio';
                break;
            case 8:
                $mes= 'Agosto';
                break;
            case 9:
                $mes= 'Septiembre';
                break;
            case 10:
                $mes= 'Octubre';
                break;
            case 11:
                $mes= 'Noviembre';
                break;
            case 12:
                $mes= 'Diciembre';
                break;

        }
        return $mes;
    }
}
