<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversacion extends Model
{
    protected $table="conversaciones";
    protected $fillable = [
        'usuario_1','usuario_2','conversacion_borrada_1','conversacion_borrada_2'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function mensajes(){
        return  $this->hasMany('App\Mensaje');
    }

}
