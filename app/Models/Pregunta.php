<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;

    protected $table = 'preguntas';
    protected $primaryKey = 'pregunta_id';
    public $incrementing = true;

    protected $fillable = [
        'encuesta_id',
        'texto',
        'tipo', // 'rango', 'opcion_multiple', 'texto'
        'opciones', 
    ];

    // Relación con la encuesta
    public function encuesta()
    {
        return $this->belongsTo(Encuesta::class, 'encuesta_id');
    }
}