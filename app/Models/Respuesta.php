<?php

namespace App\Models;

use App\Models\Vinculacion\Aspirante;
use App\Models\Vinculacion\Empresa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;

    protected $table = 'respuestas';
    protected $primaryKey = 'respuesta_id';
    public $incrementing = true;

    protected $fillable = [
        'pregunta_id',
        'aspirante_id',
        'empresa_id',
        'respuesta',
    ];

    // Relación con la pregunta
    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'pregunta_id');
    }

    // Relación con el aspirante
    public function aspirante()
    {
        return $this->belongsTo(Aspirante::class, 'aspirante_id');
    }

    // Relación con la empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}