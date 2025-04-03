<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table="servicios";
    protected $primaryKey = 'id_servicio';
    protected $fillable = ['id_servicio','descripcion','precio'];
}
