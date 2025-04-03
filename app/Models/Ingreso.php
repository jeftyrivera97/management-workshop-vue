<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    public $timestamps = false;
    protected $table="ingresos";
    protected $primaryKey = 'id';

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'id_usuario');
    }

    public function Categoria()
    {
        return $this->belongsTo('App\Models\IngresoCategoria', 'id_categoria');
    }
    public function Cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'id_cliente');
    }
    public function Auto()
    {
        return $this->belongsTo('App\Models\Auto', 'id_auto');
    }
}
