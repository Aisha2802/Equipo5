<?php

namespace App\Models\Vinculacion;

use App\Models\Respuesta;
use App\Models\SeguimientoEmpleo;
use App\Models\User;
use App\Models\Vinculacion\SeguimientoEmpleo as VinculacionSeguimientoEmpleo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirante extends Model
{
    use HasFactory;
    protected $table = 'aspirantes';
    protected $primaryKey = 'aspirante_id';
    public $incrementing = true;

    protected $fillable = [
        'nombre',
        'numero_control',
        'estado',
        'user_id', // Clave foránea para la relación con User
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function solicitudes()
    {
        return $this->hasMany(SolicitudVacante::class, 'aspirante_id');
    }
    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'aspirante_id');
    }
    
    public function seguimientosEmpleo()
    {
        return $this->hasMany(VinculacionSeguimientoEmpleo::class, 'aspirante_id');
    }
}
