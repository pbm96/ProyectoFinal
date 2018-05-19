<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoVendido extends Model
{
    protected $table="productos_vendidos";
    protected $fillable = [
        'user_id','vendido_a','valoracion_venta_comprador','valoracion_venta_vendedor','comentario_venta_vendedor','comentario_venta_comprador','precio_venta','producto_id'
    ];
    public function producto(){
        return $this->hasOne('App\Producto');
    }
    public function vendido_a(){
        return $this->belongsTo('App\User');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }

}
