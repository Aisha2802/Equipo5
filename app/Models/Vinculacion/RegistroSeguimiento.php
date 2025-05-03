<?php

namespace App\Models\Vinculacion;

use App\Models\Periodo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroSeguimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'aspirante_id',
        'vacante_id',
        'periodo_id',
    ];

    // Relación con el modelo Aspirante
    public function aspirante()
    {
        return $this->belongsTo(Aspirante::class, 'aspirante_id');
    }

    // Relación con el modelo Vacante
    public function vacante()
    {
        return $this->belongsTo(Vacante::class, 'vacante_id');
    }

    // Relación con el modelo Seguimiento
    public function seguimientos()
    {
        return $this->hasMany(Seguimiento::class, 'aspirante_id', 'aspirante_id');
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }
    
    public function scopeCurrentPeriod($query)
    {
        return $query->whereHas('periodo', function($q) {
            $q->where('activo', true);
        });
    }
}
