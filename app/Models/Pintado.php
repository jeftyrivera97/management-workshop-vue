<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pintado extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table="pintados";
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_usuario');
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
