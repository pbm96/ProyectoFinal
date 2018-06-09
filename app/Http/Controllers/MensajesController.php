<?php

namespace App\Http\Controllers;

use App\Conversacion;
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
            $conversaciones = Conversacion::where('usuario_1', '=', $user->id)->orWhere('usuario_2', '=', $user->id)->get();

            foreach ($conversaciones as $conversacion) {


                if ($conversacion->usuario_1 == $user->id) {

                    $conversacion->user_vista = $conversacion->usuario_1;

                    $conversacion->hablando_con = $conversacion->usuario_2;

                    $conversacion->hablando_con_user_datos = User::where('id', '=', $conversacion->hablando_con)->first();
                } elseif ($conversacion->usuario_2 == $user->id) {
                    $conversacion->user_vista = $conversacion->usuario_2;

                    $conversacion->hablando_con = $conversacion->usuario_1;

                    $conversacion->hablando_con_user_datos = User::where('id', '=', $conversacion->hablando_con)->first();

                }

                if (count($conversacion->mensajes) > 0) {
                    $conversacion->ultimo_mensaje_dia = $conversacion->mensajes->sortBy('created_at')->last()->created_at->day;

                    $ultimo_mensaje_mes_numero = $conversacion->mensajes->sortBy('created_at')->last()->created_at->month;

                    foreach ($conversacion->mensajes as $mensaje) {
                        $mensaje->ha_llegado = "true";
                        $mensaje->save();
                    }
                    $conversacion->ultimo_mensaje_mes = self::sacar_mes_string($ultimo_mensaje_mes_numero);

                }

            }

            $conversaciones = $conversaciones->sortByDesc('updated_at');

            return view('mensajes.mensajes-usuario.index')->with('user', $user)
                ->with('conversaciones', $conversaciones);
        } else {
            return redirect()->route('error_403');
        }
    }

    public function escribir_mensaje($id)
    {


    }

    public function enviar_mensaje(Request $request, $id, $conversacion_id)
    {
        try {

            $user = User::find($id);
            $enviado_por = auth()->user();

            if ($user != null && $request->cuerpo_mensaje !='') {
                $fecha = Carbon::now();

                $hora = $fecha->hour;

                $minutos = $fecha->minute;

                $dia = $fecha->day;

                $mes = self::sacar_mes_string($fecha->month);

                $mensaje = new Mensaje();

                $mensaje->recibido_id = $user->id;

                $mensaje->enviado_por = $enviado_por->id;

                $mensaje->conversacion_id = $conversacion_id;

                $mensaje->cuerpo_mensaje = htmlspecialchars($request->cuerpo_mensaje);

                $mensaje->visto = 'false';

                $mensaje->conversacion->updated_at = Carbon::now();

                $mensaje->save();

                $mensaje->conversacion->save();

                return response()->json(['respuesta' => true, 'mensaje' => $request->cuerpo_mensaje, 'hora' => $hora, 'minutos' => $minutos, 'dia' => $dia, 'mes' => $mes,'conversacion'=>$conversacion_id]);
            } else {
                return response()->json(['respuesta'=> false]);
            }

        } catch (Exception $exception) {
            /*cambiar*/
            Flash::error('Ha ocurrido un error al enviar el mensaje');
            return redirect()->route('index');

        }

    }

    public function eliminar_conversaciones_vacias()
    {

        $user = auth()->user();

        $conversaciones = Conversacion::where('usuario_1', '=', $user->id)->orWhere('usuario_2', '=', $user->id)->get();

        foreach ($conversaciones as $conversacion){

            if(count($conversacion->mensajes)<=0){

                $conversacion->delete();

            }
        }
    }

    public function recibir_mensajes_ajax()
    {

        $user = auth()->user();
        $mensajes_nuevos = Mensaje::where('recibido_id', '=', $user->id)->where('ha_llegado', '=', 'false')->orderBy('created_at')->get();
        if (count($mensajes_nuevos) > 0) {
            foreach ($mensajes_nuevos as $mensaje) {
                $mensaje->ha_llegado = 'true';
                $mensaje->save();

                $fecha = $mensaje->created_at;

                $mensaje->hora = $fecha->hour;

                $mensaje->minutos = $fecha->minute;

                $mensaje->dia = $fecha->day;

                $mensaje->mes = self::sacar_mes_string($fecha->month);

                $mensaje->user_enviado;
                if ($mensaje->user_enviado->imagen == null){
                    $mensaje->user_enviado->imagen = 'user-default.png';

                }


                $mensaje->conversacion;
            }


            return response()->json(['mensajes' =>$mensajes_nuevos]);
    }


    }

    public function sacar_mes_string($mes)
    {
        switch ($mes) {
            case 1:
                $mes = 'Enero';
                break;
            case 2:
                $mes = 'Febrero';
                break;
            case 3:
                $mes = 'Marzo';
                break;
            case 4:
                $mes = 'Abril';
                break;
            case 5:
                $mes = 'Mayo';
                break;
            case 6:
                $mes = 'Junio';
                break;
            case 7:
                $mes = 'Julio';
                break;
            case 8:
                $mes = 'Agosto';
                break;
            case 9:
                $mes = 'Septiembre';
                break;
            case 10:
                $mes = 'Octubre';
                break;
            case 11:
                $mes = 'Noviembre';
                break;
            case 12:
                $mes = 'Diciembre';
                break;

        }
        return $mes;
    }
}
