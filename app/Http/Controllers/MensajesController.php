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
    /**
     * funcion del chat
     * @param $id
     * @param null $nueva_conversacion
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function mensajes_user($id, $nueva_conversacion = null)
    {
        try {
            $user = User::find($id);
            $activo = '';


            if (auth()->user()->id == $user->id) {


                if ($nueva_conversacion != null) {
                    // saca las conversaciones del usuario conectado
                    $conversaciones = Conversacion::where('usuario_1', '=', $user->id)->Where('usuario_2', '=', $nueva_conversacion)->orWhere('usuario_2', '=', $user->id)->Where('usuario_1', '=', $nueva_conversacion)->first();

                    if ($conversaciones !=null) {

                    // comprueba que no tiene ya uuna conversacion con quien quiere establecer una conversacion
                        if ($conversaciones->usuario_1 == $nueva_conversacion || $conversaciones->usuario_2 == $nueva_conversacion) {

                            // si es asi y tiene borrada esa conversacion la vuelve a sacar
                            if ($conversaciones->usuario_1 != $nueva_conversacion) {

                                $conversaciones->conversacion_borrada_usuario_1 = 'false';

                                $conversaciones->save();

                            } elseif ($conversaciones->usuario_2 != $nueva_conversacion) {

                                $conversaciones->conversacion_borrada_usuario_2 = 'false';

                                $conversaciones->save();

                            }
                        }
                        // sino crea una nueva conversacion
                    }else {
                        $conversacion_nueva = Conversacion::firstOrCreate([
                            'usuario_1' => auth()->user()->id,
                            'usuario_2' => $nueva_conversacion,

                        ]);
                        $conversacion_nueva->conversacion_borrada_usuario_1 = 'false';
                        $conversacion_nueva->conversacion_borrada_usuario_2 = 'false';

                        $conversacion_nueva->save();
                    }

                }
            // aqui saca todas las conversaciones del usuario una vez creada la otra
                $conversaciones = Conversacion::where('usuario_1', '=', $user->id)->orWhere('usuario_2', '=', $user->id)->get()->sortByDesc('updated_at');

            // recorre todas sus conversaciones para añadirle valores
                foreach ($conversaciones as $conversacion) {
                    // aqui comprueba quien es cada usuario y los ordena en con quien esta hablando y quien es el que esta conectado
                    if ($conversacion->usuario_1 == $user->id) {

                        $conversacion->user_vista = $conversacion->usuario_1;

                        $conversacion->hablando_con = $conversacion->usuario_2;

                        if ($conversacion->conversacion_borrada_usuario_1 == 'true') {

                            $conversacion->borrada = true;

                        }
                        // aqui saco los datos del usuario con quien esta hablando llamando al modelo
                        $conversacion->hablando_con_user_datos = User::where('id', '=', $conversacion->hablando_con)->first();

                    } elseif ($conversacion->usuario_2 == $user->id) {
                        $conversacion->user_vista = $conversacion->usuario_2;

                        $conversacion->hablando_con = $conversacion->usuario_1;

                        if ($conversacion->conversacion_borrada_usuario_2 == 'true') {

                            $conversacion->borrada = true;
                        }

                        $conversacion->hablando_con_user_datos = User::where('id', '=', $conversacion->hablando_con)->first();

                    }
                    // aqui saco cual es la conversacion activa en la vista
                    if (!isset($conversacion->borrada) && $activo == '') {
                        $activo = 'activo';
                        $conversacion->activo = true;
                    }

                        // compruebo si la conversacion tiene mensajes , si los tiene les doy un formato a la fecha para mostrar y pongo en true que han llegado y se han visto
                    if (count($conversacion->mensajes) > 0) {
                        $conversacion->ultimo_mensaje_dia = $conversacion->mensajes->sortBy('created_at')->last()->created_at->day;

                        $ultimo_mensaje_mes_numero = $conversacion->mensajes->sortBy('created_at')->last()->created_at->month;

                        foreach ($conversacion->mensajes as $mensaje) {
                            $mensaje->ha_llegado = "true";
                            $mensaje->visto = "true";
                            $mensaje->save();

                            $fecha = $mensaje->created_at;
                            $fecha_minutos = $fecha->minute < 10 ? '0' . $fecha->minute : $fecha->minute;
                            $mensaje->fecha_mensaje = $fecha->day . ' ' . self::sacar_mes_string($fecha->month) . ',' . $fecha->hour . ':' . $fecha_minutos;


                        }
                        $conversacion->ultimo_mensaje_mes = self::sacar_mes_string($ultimo_mensaje_mes_numero);

                    }

                }
                return view('mensajes.mensajes-usuario.index')->with('user', $user)
                    ->with('conversaciones', $conversaciones);
            } else {
                return redirect()->route('error_403');
            }
        }catch (Exception $exception){

            Flash::error('Ocurrio un error al intentar acceder a tus mensajes');

            return redirect()->route('index');
        }
    }

    /**
     * funcion para enviar mensajes
     * @param Request $request
     * @param $id
     * @param $conversacion_id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     *
     */
    public function enviar_mensaje(Request $request, $id, $conversacion_id)
    {
        try {

            $user = User::find($id);
            $enviado_por = auth()->user();

            if ($user != null && $request->cuerpo_mensaje != '') {
                $fecha = Carbon::now();

                $hora = $fecha->hour;
                if ($fecha->minute < 10) {
                    $minutos = '0' . $fecha->minute;
                } else {
                    $minutos = $fecha->minute;
                }


                $dia = $fecha->day;

                $mes = self::sacar_mes_string($fecha->month);

                $mensaje = new Mensaje();

                $mensaje->recibido_id = $user->id;

                $mensaje->enviado_por = $enviado_por->id;

                $mensaje->conversacion_id = $conversacion_id;

                $mensaje->cuerpo_mensaje = htmlspecialchars($request->cuerpo_mensaje);

                $mensaje->visto = 'false';

                $mensaje->conversacion->conversacion_borrada_usuario_2='false';

                $mensaje->conversacion->conversacion_borrada_usuario_1='false';

                $mensaje->conversacion->updated_at = Carbon::now();

                $mensaje->save();

                $mensaje->conversacion->save();

                return response()->json(['respuesta' => true, 'mensaje' => $request->cuerpo_mensaje, 'hora' => $hora, 'minutos' => $minutos, 'dia' => $dia, 'mes' => $mes, 'conversacion' => $conversacion_id]);
            } else {
                return response()->json(['respuesta' => false]);
            }

        } catch (Exception $exception) {
            /*cambiar*/
            Flash::error('Ha ocurrido un error al enviar el mensaje');
            return redirect()->route('index');

        }

    }

    /**
     * funcion para eliminar conversaciones vacias del usuario
     */
    public function eliminar_conversaciones_vacias()
    {

        $user = auth()->user();

        $conversaciones = Conversacion::where('usuario_1', '=', $user->id)->orWhere('usuario_2', '=', $user->id)->get();

        foreach ($conversaciones as $conversacion) {

            if (count($conversacion->mensajes) <= 0) {

                $conversacion->delete();

            }
        }
    }

    /**
     * funcion para eliminar una conversacion
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function eliminar_conversacion($id)
    {
        try {
            $user = auth()->user();

            $conversacion = Conversacion::where('id', '=', $id)->first();

            if ($conversacion->usuario_1 == $user->id) {

                $conversacion->conversacion_borrada_usuario_1 = 'true';

            } elseif ($conversacion->usuario_2 == $user->id) {

                $conversacion->conversacion_borrada_usuario_2 = 'true';
            }


            $conversacion->save();

            if ($conversacion->conversacion_borrada_usuario_1 == 'true' && $conversacion->conversacion_borrada_usuario_2 == 'true') {

                $conversacion->delete();
            }

            return redirect()->route('mis_mensajes',auth()->user()->id);

        } catch (Exception $exception) {

            return redirect()->route('mis_mensajes',auth()->user()->id);
        }


    }

    /**
     * funcion para recibir los mensajes por ajax
     * @return \Illuminate\Http\JsonResponse
     */
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
                if ($mensaje->user_enviado->imagen == null) {
                    $mensaje->user_enviado->imagen = 'user-default.png';

                }


                $mensaje->conversacion;
            }


            return response()->json(['mensajes' => $mensajes_nuevos]);
        }

    }

    /**
     * funcion para mostrar los nombres del mes que se le pasa
     * @param $mes
     * @return string
     */
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
