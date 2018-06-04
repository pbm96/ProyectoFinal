<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $table="mensajes";
    protected $fillable = [
        'enviado_por','user_id','cuerpo_mensaje','visto'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function enviado_por(){
        return $this->belongsTo('App\User');
    }
}
