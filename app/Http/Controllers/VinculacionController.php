<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VinculacionController extends Controller
{
    // Método para el submódulo de Empresas
    public function incio(Request $request)
    {
        $submodulo = 1; // Empresas
        return view('dashboard', compact('submodulo'));
    }

    public function empresas(Request $request)
    {
        $submodulo = 9; // Empresas
        return view('dashboard', compact('submodulo'));
    }

    // Método para el submódulo de Estudiantes
    public function estudiantes(Request $request)
    {
        $submodulo = 2; // Estudiantes
        return view('dashboard', compact('submodulo'));
    }

    // Método para el submódulo de Proyectos
    public function proyectos(Request $request)
    {
        $submodulo = 3; // Proyectos
        return view('dashboard', compact('submodulo'));
    }

    // Método para el submódulo de Reportes
    public function reportes(Request $request)
    {
        $submodulo = 4; // Reportes
        return view('dashboard', compact('submodulo'));
    }

    public function vacantes(Request $request)
    {
        $submodulo = 5; 
        return view('dashboard', compact('submodulo'));
    }

    public function solicitudes(Request $request)
    {
        $submodulo = 6; 
        return view('dashboard', compact('submodulo'));
    }

    public function vacantesEstudiantes(Request $request)
    {
        $submodulo = 7; 
        return view('dashboard', compact('submodulo'));
    }

    public function nuevaEmpresa(Request $request)
    {
        $submodulo = 8; 
        return view('dashboard', compact('submodulo'));
    }

    public function encuestas(Request $request)
    {
        $submodulo = 10; 
        return view('dashboard', compact('submodulo'));
    
    }
    public function AltaEncuestas(Request $request)
    {
        $submodulo = 11; 
        return view('dashboard', compact('submodulo'));
    }

    public function Documentos(Request $request)
    {
        $submodulo = 12; 
        return view('dashboard', compact('submodulo'));
    }

    public function Papeles(Request $request)
    {
        $submodulo = 13; 
        return view('dashboard', compact('submodulo'));
    }

    public function Seguimiento(Request $request)
    {
        $submodulo = 14; 
        return view('dashboard', compact('submodulo'));
    }

    public function CrearEncuesta(Request $request)
    {
        $submodulo = 15; 
        return view('dashboard', compact('submodulo'));
    }

    public function EstadisticaSolicitud(Request $request)
    {
        $submodulo = 16; 
        return view('dashboard', compact('submodulo'));
    }

    public function SeguimientoEmpleo(Request $request)
    {
        $submodulo = 17; 
        return view('dashboard', compact('submodulo'));
    }


    

    
}
