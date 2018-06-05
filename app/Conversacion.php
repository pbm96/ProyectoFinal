<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversacion extends Model
{
    protected $table="conversaciones";
    protected $fillable = [
        'usuario_1','usuario_2','conversacion_borrada_1','conversacion_borrada_2'
    ];

    public function user_1(){
        return $this->belongsTo('App\User','id','usuario_1');
    }
    public function user_2(){
        return $this->belongsTo('App\User','id','usuario_2');
    }

}
