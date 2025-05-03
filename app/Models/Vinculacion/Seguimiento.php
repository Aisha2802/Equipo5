<?php

namespace App\Models\Vinculacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seguimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'aspirante_id',
        'documento_id',
        'tipo_id',
        'estado',
    ];

    // Relación con el modelo Aspirante
    public function aspirante()
    {
        return $this->belongsTo(Aspirante::class, 'aspirante_id');
    }

    // Relación con el modelo Documento
    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }

    // Relación con el modelo Tipo
    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }
}
