<?php

namespace App\Models\Vinculacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'link',
        'aspirante_id',
    ];

    // Relación con el modelo Aspirante
    public function aspirante()
    {
        return $this->belongsTo(Aspirante::class);
    }

    // Relación con el modelo Seguimiento
    public function seguimientos()
    {
        return $this->hasMany(Seguimiento::class);
    }
}
