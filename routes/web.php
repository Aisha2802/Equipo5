<?php
use App\Http\Controllers\VinculacionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    //todos
    Route::get('dashboard', [VinculacionController::class, 'incio'])->name('dashboard');

    //aspirantes
    Route::get('dashboard/estudiantes', [VinculacionController::class, 'estudiantes'])->name('dashboard.estudiantes');
    Route::get('dashboard/Mis Vacantes', [VinculacionController::class, 'vacantesEstudiantes'])->name('dashboard.vacantesEstudiantes');
    Route::get('dashboard/Documentos', [VinculacionController::class, 'Documentos'])->name('dashboard.documento');

    //vinculacion
    Route::get('dashboard/proyectos', [VinculacionController::class, 'proyectos'])->name('dashboard.proyectos');
    Route::get('dashboard/reportes', [VinculacionController::class, 'reportes'])->name('dashboard.reportes');
    Route::get('dashboard/Nueva empresa', [VinculacionController::class, 'nuevaEmpresa'])->name('dashboard.nuevaEmpresa');
    Route::get('dashboard/alta-encuestas', [VinculacionController::class, 'AltaEncuestas'])->name('dashboard.alta-encuestas');
    Route::get('dashboard/empresas', [VinculacionController::class, 'empresas'])->name('dashboard.empresas');
    Route::get('dashboard/crear-encuestas', [VinculacionController::class, 'CrearEncuesta'])->name('dashboard.crear-encuestas');
    Route::get('dashboard/estadistica-solicitud', [VinculacionController::class, 'EstadisticaSolicitud'])->name('dashboard.estadistica-solicitud');

    //empresas
    Route::get('dashboard/Papeles', [VinculacionController::class, 'Papeles'])->name('dashboard.papeles');
    Route::get('dashboard/vacante', [VinculacionController::class, 'vacantes'])->name('dashboard.vacante');
    Route::get('dashboard/solicitud', [VinculacionController::class, 'solicitudes'])->name('dashboard.solicitud');

    //empresas y aspirantes
    Route::get('dashboard/encuestas', [VinculacionController::class, 'encuestas'])->name('dashboard.encuestas');

    //jefe EstadisticaSolicitud
    Route::get('dashboard/Seguimiento', [VinculacionController::class, 'Seguimiento'])->name('dashboard.seguimiento');
    Route::get('dashboard/Seguimiento-egresados', [VinculacionController::class, 'SeguimientoEmpleo'])->name('dashboard.seguimiento-empleos');
});

Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

require __DIR__.'/auth.php';
