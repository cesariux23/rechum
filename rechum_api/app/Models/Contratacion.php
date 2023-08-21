<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Contratacion extends Model
{
    use HasFactory;

    protected $table = 'contrataciones';

    protected $fillable = [
        'tipo_contratacion',
        'numero_empleado',
        'rfc',
        'fecha_inicio',
        'fecha_baja',
        'motivo_baja',
        'status',
        'actual'
    ];

    // campos calculados
    protected $appends = ['puesto'];

    public function movimientos(): HasMany
    {
        return $this->hasMany(Movimiento::class);
    }

    public function puesto(): Attribute
    {
        return new Attribute(
            get: fn() => $this->movimientos()->with('adscripcion', 'plaza')->where('actual',true)->first()
        );
    }

    
}
