@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Rapports et Statistiques</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Patients -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-600 mb-2">Total des Patients</h2>
                <p class="text-4xl font-bold text-blue-600">{{ $stats['total_patients'] }}</p>
            </div>

            <!-- Hospitalisations en cours -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-600 mb-2">Hospitalisations Actives</h2>
                <p class="text-4xl font-bold text-green-600">{{ $stats['hospitalisations_en_cours'] }}</p>
            </div>
        </div>

        <div class="mt-10 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Télécharger les Rapports</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('rapports.export.consultations') }}"
                    class="inline-flex items-center gap-2 px-4 py-3 rounded-lg bg-blue-600 text-white font-bold shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 16v-8m0 8l-4-4m4 4l4-4m-8 8h8a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Consultations / Médecin
                </a>
                <a href="{{ route('rapports.export.hospitalisations') }}"
                    class="inline-flex items-center gap-2 px-4 py-3 rounded-lg bg-green-600 text-white font-bold shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-300 transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 16v-8m0 8l-4-4m4 4l4-4m-8 8h8a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Hospitalisations en Cours
                </a>
                <a href="{{ route('rapports.export.medicaments') }}"
                    class="inline-flex items-center gap-2 px-4 py-3 rounded-lg bg-purple-600 text-white font-bold shadow hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-300 transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 16v-8m0 8l-4-4m4 4l4-4m-8 8h8a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Médicaments Prescrits
                </a>
                <a href="{{ route('rapports.export.patients') }}"
                    class="inline-flex items-center gap-2 px-4 py-3 rounded-lg bg-red-600 text-white font-bold shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 16v-8m0 8l-4-4m4 4l4-4m-8 8h8a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Statistiques Patients
                </a>
            </div>
        </div>

        <div class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Consultations par médecin -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Consultations par Médecin</h3>
                <ul class="space-y-2">
                    @forelse($stats['consultations_par_medecin'] as $medecin)
                        <li class="flex justify-between items-center">
                            <span>Dr. {{ $medecin->name }}</span>
                            <span class="font-bold text-blue-600">{{ $medecin->consultations_count }}</span>
                        </li>
                    @empty
                        <li>Aucune consultation enregistrée.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Médicaments les plus prescrits -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Top 5 des Médicaments Prescrits</h3>
                <ul class="space-y-2">
                    @forelse($stats['medicaments_plus_prescrits'] as $medicament)
                        <li class="flex justify-between items-center">
                            <span>{{ $medicament->nom_medicament }}</span>
                            <span class="font-bold text-purple-600">{{ $medicament->total }}</span>
                        </li>
                    @empty
                        <li>Aucun médicament prescrit.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
