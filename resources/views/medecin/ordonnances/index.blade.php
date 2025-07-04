@extends('layouts.app')

@section('title', 'Mes ordonnances')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Mes ordonnances</h1>
        <a href="{{ route('medecin.ordonnances.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>Nouvelle ordonnance
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Liste des ordonnances
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Consultez et gérez les ordonnances que vous avez créées.
            </p>
        </div>
        
        @if($ordonnances->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Patient
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Médicaments
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($ordonnances as $ordonnance)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $ordonnance->patient->prenom }} {{ $ordonnance->patient->nom }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $ordonnance->patient->date_naissance->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $ordonnance->date_ordonnance->format('d/m/Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $ordonnance->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        @foreach($ordonnance->medicaments->take(2) as $medicament)
                                            <div>{{ $medicament->nom }}</div>
                                        @endforeach
                                        @if($ordonnance->medicaments->count() > 2)
                                            <div class="text-blue-600">+{{ $ordonnance->medicaments->count() - 2 }} autres</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('medecin.ordonnances.show', $ordonnance) }}" class="text-blue-600 hover:text-blue-900 mr-4">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>
                                    <a href="{{ route('medecin.ordonnances.edit', $ordonnance) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    <a href="{{ route('medecin.ordonnances.pdf', $ordonnance) }}" class="text-red-600 hover:text-red-900" target="_blank">
                                        <i class="fas fa-file-pdf"></i> PDF
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $ordonnances->links() }}
            </div>
        @else
            <div class="px-6 py-4 text-center text-gray-500">
                <i class="fas fa-file-prescription text-4xl mb-2 text-gray-300"></i>
                <p class="text-lg">Aucune ordonnance trouvée.</p>
                <p class="text-sm mt-2">Commencez par créer votre première ordonnance.</p>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
    }
    .pagination > * {
        margin: 0 0.25rem;
        padding: 0.25rem 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.25rem;
    }
    .pagination .active {
        background-color: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }
    .pagination .disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endpush

@push('scripts')
<script>
    // Scripts spécifiques à la page si nécessaire
    document.addEventListener('DOMContentLoaded', function() {
        // Ajoutez ici du code JavaScript si nécessaire
    });
</script>
@endpush
@endsection
