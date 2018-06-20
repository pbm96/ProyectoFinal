<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoFavorito extends Model
{
    protected $table="productos_favoritos";
    protected $fillable = [
        'user_id','producto_id',
    ];

    public function producto(){
        return   $this->belongsTo('App\Producto','producto_id','id');


    }
    public function user(){
        return $this->belongsToMany('App\Users');
    }
}
