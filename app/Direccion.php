<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table="direcciones";
    protected $fillable = [
        'nombre','latitud','longitud'
    ];
    public function user(){
        return $this->hasOne('App\User');
    }
}
