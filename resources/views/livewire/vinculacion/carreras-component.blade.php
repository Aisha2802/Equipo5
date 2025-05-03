<div>
    <h1 class="text-xl font-bold mb-4">Carreras</h1>

    @foreach ($carreras as $carrera)
        <div class="mb-6">
            <h2 class="text-lg font-semibold">{{ $carrera->nombre }}</h2>
            <ul class="ml-4">
                @foreach ($carrera->especialidades as $especialidad)
                    <li>{{ $especialidad->nombre }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>