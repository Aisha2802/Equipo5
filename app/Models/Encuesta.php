<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    use HasFactory;

    protected $table = 'encuestas';
    protected $primaryKey = 'encuesta_id';
    public $incrementing = true;

    protected $fillable = [
        'titulo',
        'descripcion',
        'tipo', // 'estudiante' o 'empresa'
        'habilitada', 
    ];

    // Relación con las preguntas
    public function preguntas()
    {
        return $this->hasMany(Pregunta::class, 'encuesta_id');
    }
}
