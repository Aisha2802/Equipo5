<?php

namespace App\Models\Vinculacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfiles';
    protected $primaryKey = 'perfil_id';
    protected $fillable = ['carrera_id', 'especialidad_id'];

    // Relación con el modelo Carrera
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    // Relación con el modelo Especialidad
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad_id');
    }

    // Relación muchos a muchos con el modelo Vacante
    public function vacantes()
    {
        return $this->belongsToMany(Vacante::class, 'vacante_perfil', 'perfil_id', 'vacante_id');
    }
}