<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table="planillas";
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_usuario');
    }
    public function Empleado()
    {
        return $this->belongsTo('App\Models\Empleado', 'id_empleado');
    }

}
