<?php

namespace App\Models\Vinculacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacante extends Model
{
    use HasFactory;

    protected $table = 'vacantes';
    protected $primaryKey = 'vacante_id';
    protected $fillable = [
        'empresa_id',
        'titulo',
        'descripcion',
        'ubicacion',
        'tipo',
        'estado',
        'max',
        'pago',
    ];

    // Relación con el modelo Empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    // Relación muchos a muchos con el modelo Perfil
    public function perfiles()
    {
        return $this->belongsToMany(Perfil::class, 'vacante_perfil', 'vacante_id', 'perfil_id');
    }

    public function solicitudes()
    {
        return $this->hasMany(SolicitudVacante::class, 'vacante_id');
    }
}
