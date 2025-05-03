<?php

namespace App\Models\Vinculacion; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    protected $table = 'carreras';
    protected $primaryKey = 'carrera_id';
    protected $fillable = ['nombre'];

    public function especialidades()
    {
        return $this->hasMany(Especialidad::class, 'carrera_id');
    }

    public function perfiles()
    {
        return $this->hasMany(Perfil::class, 'carrera_id');
    }
}