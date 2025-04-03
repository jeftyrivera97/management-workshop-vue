<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table="autos";
    protected $primaryKey = 'id';

    public function Estado()
    {
        return $this->belongsTo('App\Models\Estado', 'id_estado');
    }
}
