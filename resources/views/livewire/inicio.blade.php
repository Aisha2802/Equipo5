<div
    class="welcome-container bg-gradient-to-br from-blue-100 to-blue-50 p-8 rounded-lg shadow-lg border border-blue-200">
    @if (auth()->user()->role == 'vinculacion')
        <div class="text-center">
            <h1 class="text-4xl font-extrabold text-blue-900 mb-6">👋 ¡Bienvenido/a al Sistema de Vinculación!</h1>

            <div class="bg-white p-8 rounded-lg shadow-xl max-w-3xl mx-auto border-t-4 border-blue-600">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Gestión de Empresas -->
                    <div class="bg-blue-50 p-5 rounded-lg border border-blue-200">
                        <div class="flex items-center mb-3">
                            <span class="bg-blue-100 p-3 rounded-full mr-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </span>
                            <h3 class="text-lg font-bold text-blue-800">Gestión de Empresas</h3>
                        </div>
                        <p class="text-gray-700">Da de alta nuevas empresas colaboradoras y gestiona las existentes para
                            crear oportunidades de vinculación.</p>
                    </div>

                    <!-- Encuestas -->
                    <div class="bg-purple-50 p-5 rounded-lg border border-purple-200">
                        <div class="flex items-center mb-3">
                            <span class="bg-purple-100 p-3 rounded-full mr-3">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <h3 class="text-lg font-bold text-purple-800">Encuestas</h3>
                        </div>
                        <p class="text-gray-700">Crea y habilita encuestas para evaluar procesos de vinculación y
                            obtener retroalimentación valiosa.</p>
                    </div>

                    <!-- Documentos -->
                    <div class="bg-green-50 p-5 rounded-lg border border-green-200">
                        <div class="flex items-center mb-3">
                            <span class="bg-green-100 p-3 rounded-full mr-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </span>
                            <h3 class="text-lg font-bold text-green-800">Documentos Estudiantiles</h3>
                        </div>
                        <p class="text-gray-700">Revisa y valida los documentos enviados por los estudiantes para sus
                            procesos de residencia profesional.</p>
                    </div>

                    <!-- Vinculación -->
                    <div class="bg-yellow-50 p-5 rounded-lg border border-yellow-200">
                        <div class="flex items-center mb-3">
                            <span class="bg-yellow-100 p-3 rounded-full mr-3">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </span>
                            <h3 class="text-lg font-bold text-yellow-800">Procesos de Vinculación</h3>
                        </div>
                        <p class="text-gray-700">Coordina y supervisa los procesos de vinculación entre estudiantes y
                            empresas.</p>
                    </div>
                </div>

                <div class="mt-8 bg-blue-100 border-l-4 border-blue-500 p-4 rounded">
                    <p class="text-blue-800 font-medium">📌 Recuerda: Tu rol es fundamental para conectar el talento
                        estudiantil con las oportunidades profesionales adecuadas.</p>
                </div>
            </div>
        </div>
    @elseif(auth()->user()->role == 'jefe')
    <div class="text-center max-w-4xl mx-auto">
        <!-- Encabezado principal -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 rounded-t-xl shadow-lg">
            <h1 class="text-4xl font-extrabold text-blue-900 text-center mb-6">👋 ¡Bienvenido/a al Sistema de Vinculación!
            </h1>
        </div>
        
        <!-- Tarjeta de contenido -->
        <div class="bg-white p-8 rounded-b-xl shadow-lg border border-gray-200">
            <!-- Icono y mensaje central -->
            <div class="flex justify-center mb-6">
                <div class="bg-blue-100 p-4 rounded-full">
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Gestión y Supervisión</h2>
            
            <p class="text-gray-600 mb-6">
                Desde este panel podrás realizar seguimiento a los estudiantes en residencias profesionales.
            </p>
        </div>
    </div>

    @else
        <h1 class="text-4xl font-extrabold text-blue-900 text-center mb-6">👋 ¡Bienvenido/a al Sistema de Vinculación!
        </h1>

        <p class="text-lg text-gray-700 text-center">
            Conecta con oportunidades profesionales y encuentra el camino ideal para tu crecimiento.
        </p>

        <div class="bg-white p-6 rounded-md shadow-md border-l-4 border-blue-600 mt-6">
            <p class="flex items-center text-gray-800 font-semibold">
                <span class="text-blue-600 text-2xl mr-2">🎓</span>
                <span>¿Eres estudiante? Encuentra residencias y prácticas profesionales.</span>
            </p>
            <p class="flex items-center text-gray-800 font-semibold mt-3">
                <span class="text-blue-600 text-2xl mr-2">🏢</span>
                <span>¿Eres empresa? Descubre talento joven para potenciar tu equipo.</span>
            </p>
        </div>

        <p class="text-gray-600 text-center mt-6">
            Explora nuestras opciones y comienza tu viaje hacia el éxito profesional. ¡Estamos aquí para ayudarte!
        </p>

        <div class="text-center mt-6">
            @auth
                @if (auth()->user()->role === 'aspirante')
                    <a href="{{ route('dashboard.estudiantes') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg shadow-md transition-all">
                        🚀 Explorar Oportunidades
                    </a>
                @elseif(auth()->user()->role === 'empresa')
                    <a href="{{ route('dashboard.solicitud') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg shadow-md transition-all">
                        🚀 Explorar Oportunidades
                    </a>
                @else
                    <a href="#"
                        class="bg-gray-400 cursor-not-allowed text-white font-bold py-3 px-6 rounded-lg text-lg shadow-md">
                        🚀 Explorar Oportunidades
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg shadow-md transition-all">
                    🚀 Explorar Oportunidades
                </a>
            @endauth
        </div>
    @endif
</div>
