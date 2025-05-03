<?php

namespace App\Models;

use App\Models\Vinculacion\SolicitudVacante;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Periodo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    // Obtener el periodo activo actual
    public static function actual()
    {
        return static::where('activo', true)->first();
    }

    // Marcar este periodo como el activo (y desactivar los demás)
    public function activar()
    {
        DB::transaction(function () {
            static::where('id', '!=', $this->id)->update(['activo' => false]);
            $this->update(['activo' => true]);
        });
    }

    public function solicitudesVacantes()
    {
        return $this->hasMany(SolicitudVacante::class);
    }
}
