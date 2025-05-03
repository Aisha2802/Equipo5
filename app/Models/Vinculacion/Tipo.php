<?php

namespace App\Models\Vinculacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    // Relación con el modelo Seguimiento
    public function seguimientos()
    {
        return $this->hasMany(Seguimiento::class);
    }
}
