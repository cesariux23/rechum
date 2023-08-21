<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Personal extends Model
{
    use HasFactory;

    protected $table='personal';

    //custom primarykey like String
    protected $primaryKey = 'rfc';
    public $incrementing = false;

    protected $fillable = [
        'rfc',
        'nombre',
        'primer_apellido',
        'segundo_apellido',
        'curp',
        'fecha_nacimiento',
        'sexo',
        'banco',
        'numero_cuenta',
        'clabe',
        'codigo_postal',
        'correo_electronico',
        'seguridad_social',
        'nss',
        'tiene_hijos',
        'nombre_completo',
        'status',
    ];

    // campos calculados
    protected $appends = ['contratacion'];

    //scopes de busqueda
    public function scopeRfc(Builder $query, string $rfc): void
    {
        $query->where('rfc', 'like', "%{$rfc}%");
    }
    //scopes de busqueda
    public function scopeNombre(Builder $query, string $nombre): void
    {
        $query->where('nombre_completo', 'like', "%{$nombre}%");
    }

    public function contrataciones(): HasMany
    {
        return $this->hasMany(Contratacion::class, 'rfc', 'rfc')
            ->orderBy('actual','desc')
            ->orderBy('fecha_inicio','desc');
    }

    public function contratacion(): Attribute
    {
        return new Attribute(
            get: fn() => $this->contrataciones()->where('actual',true)->first()
        );
    }
}
