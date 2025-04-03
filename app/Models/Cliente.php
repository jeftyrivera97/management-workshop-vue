<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table="clientes";
    protected $primaryKey = 'id';

    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class);
    }

    public function ingreso(): HasMany
    {
        return $this->hasMany(Ingreso::class);
    }
}
