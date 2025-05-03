<?php
namespace App\Models\Vinculacion;

use App\Models\Respuesta;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';
    protected $primaryKey = 'empresa_id';
    protected $fillable = [
        'RFC',
        'nombreComercial',
        'razonSocial',
        'giro',
        'noEmpleado',
        'codigoPostal',
        'colonia',
        'ciudad',
        'estado',
        'pais',
        'sitioWeb',
    ];

    public function vacantes()
    {
        return $this->hasMany(Vacante::class, 'empresa_id');
    }

    public function usuarios()
    {
        return $this->hasMany(User::class, 'empresa_id', 'empresa_id');
    }

    public function respuestas()
{
    return $this->hasMany(Respuesta::class, 'empresa_id');
}
}
