<?php

namespace App\Models\Vinculacion;

use App\Models\Periodo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudVacante extends Model
{
    use HasFactory;

    protected $fillable = [
        'vacante_id',
        'aspirante_id',
        'periodo_id',
        'estado',
    ];

    public function vacante()
    {
        return $this->belongsTo(Vacante::class, 'vacante_id');
    }

    /**
     * Obtener el aspirante asociado a la solicitud.
     */
    public function aspirante()
    {
        return $this->belongsTo(Aspirante::class, 'aspirante_id');
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }
}

