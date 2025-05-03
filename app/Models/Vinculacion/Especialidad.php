<?php

namespace App\Models\Vinculacion; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    use HasFactory;

    protected $table = 'especialidades';
    protected $primaryKey = 'especialidad_id';
    protected $fillable = ['carrera_id', 'nombre'];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }
}
