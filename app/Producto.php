<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table="productos";
    protected $fillable = [
        'nombre','descripcion','fecha','user_id','categoria_id','precio','vendido'
    ];
    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }
    public function imagen(){
        return $this->hasMany('App\Imagen');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function producto_favorito(){
        return $this->belongsToMany('App\ProductoFavorito');
    }
    public function venta(){
        return $this->hasOne('App\ProductoVendido');

    }

}
