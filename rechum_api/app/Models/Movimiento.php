<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movimiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'contratacion_id',
        'numero_empleado',
        'adscripcion_id',
        'rfc',
        'codigo_plaza',
        'codigo_tabulador',
        'fecha_inicio',
        'fecha_baja',
        'funcion',
        'zona_economica',
        'status',
        'actual',
        'es_titular',
        //
        'interinato',
        'comisionado',
    ];

    protected $casts = [
        'actual' => 'boolean',
        'es_titular' => 'boolean',
    ];
    
    public function adscripcion(): BelongsTo
    {
        return $this->belongsTo(Adscripcion::class);
    }

    public function plaza(): BelongsTo
    {
        return $this->belongsTo(Plaza::class,'codigo_plaza','codigo_plaza');
    }


}
