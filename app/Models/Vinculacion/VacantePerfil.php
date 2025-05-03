<?php

namespace App\Models\Vinculacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacantePerfil extends Model
{
    use HasFactory;

    // Nombre de la tabla pivote
    protected $table = 'vacante_perfil';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'vacante_id',
        'perfil_id',
    ];

    // Relación con el modelo Vacante
    public function vacante()
    {
        return $this->belongsTo(Vacante::class, 'vacante_id');
    }

    // Relación con el modelo Perfil
    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'perfil_id');
    }
}