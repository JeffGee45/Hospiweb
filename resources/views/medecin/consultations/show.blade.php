@extends('layouts.app')

@section('title', 'Détails de la consultation')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Consultation du {{ $consultation->date_consultation->format('d/m/Y') }}
            </h1>
            <p class="text-gray-600">
                {{ $patient->prenom }} {{ $patient->nom }} - {{ $patient->date_naissance->format('d/m/Y') }} ({{ $patient->age }} ans)
            </p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('medecin.patients.consultations.index', $patient) }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour aux consultations
            </a>
            <a href="#" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Exporter en PDF
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p class="font-bold">Succès</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Informations générales
            </h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Date et heure</h4>
                    <p class="mt-1 text-sm text-gray-900">
                        {{ $consultation->date_consultation->format('d/m/Y H:i') }}
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Médecin</h4>
                    <p class="mt-1 text-sm text-gray-900">
                        Dr. {{ $consultation->medecin->prenom }} {{ $consultation->medecin->nom }}
                    </p>
                </div>
                <div class="md:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500">Motif de la consultation</h4>
                    <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                        {{ $consultation->motif }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Diagnostic
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                @if($consultation->diagnostic)
                    <div class="prose max-w-none">
                        {!! nl2br(e($consultation->diagnostic)) !!}
                    </div>
                @else
                    <p class="text-sm text-gray-500 italic">Aucun diagnostic renseigné.</p>
                @endif
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Traitement prescrit
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                @if($consultation->traitement)
                    <div class="prose max-w-none">
                        {!! nl2br(e($consultation->traitement)) !!}
                    </div>
                @else
                    <p class="text-sm text-gray-500 italic">Aucun traitement prescrit.</p>
                @endif
            </div>
        </div>
    </div>

    @if($consultation->notes)
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Notes complémentaires
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="prose max-w-none">
                    {!! nl2br(e($consultation->notes)) !!}
                </div>
            </div>
        </div>
    @endif

    <div class="flex justify-between items-center mt-8">
        <div class="text-sm text-gray-500">
            Créée le {{ $consultation->created_at->format('d/m/Y à H:i') }}
            @if($consultation->created_at != $consultation->updated_at)
                <br>Dernière mise à jour le {{ $consultation->updated_at->format('d/m/Y à H:i') }}
            @endif
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('medecin.patients.consultations.edit', [$patient, $consultation]) }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Modifier
            </a>
            <form action="{{ route('medecin.patients.consultations.destroy', [$patient, $consultation]) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette consultation ? Cette action est irréversible.')">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Scripts spécifiques à la page de détail de la consultation
    document.addEventListener('DOMContentLoaded', function() {
        // Initialisation des tooltips si nécessaire
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
@endsection
