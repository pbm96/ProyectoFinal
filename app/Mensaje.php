<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $table="mensajes";
    protected $fillable = [
        'enviado_por','recibido_id','cuerpo_mensaje','visto','conversacion_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function enviado_por(){
        return $this->belongsTo('App\User');
    }
    public function conversacion(){
        return  $this->belongsTo('App\Conversacion');
    }
}
