<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table="imagenes";
    protected $fillable = [
        'nombre','producto_id',
    ];
    public function producto(){
        return $this->belongsTo('App\Producto');
    }
}
