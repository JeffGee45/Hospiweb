@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- En-tête avec dégradé -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-white">Gestion des Patients</h1>
                    <p class="mt-2 text-blue-100">Consultez et gérez les dossiers des patients</p>
                </div>
                @php
                    $createRoute = auth()->user()->role === 'Admin' ? route('admin.patients.create') : (auth()->user()->role === 'Secrétaire' ? route('secretaire.patients.create') : null);
                @endphp
                @if($createRoute)
                <div class="mt-4 md:mt-0">
                    <a href="{{ $createRoute }}" 
                       class="inline-flex items-center px-5 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Nouveau patient
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Cartes de statistiques -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-6">
            <!-- Total des patients -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Total des patients
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ $stats['total'] }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'actif', 'page' => 1]) }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Voir tous les patients
                        </a>
                    </div>
                </div>
            </div>

            <!-- Patients guéris -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Patients guéris
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ $stats['gueris'] }}
                                    </div>
                                    <div class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                                        <span class="sr-only">
                                            Pourcentage
                                        </span>
                                        {{ $stats['total'] > 0 ? round(($stats['gueris'] / $stats['total']) * 100) : 0 }}%
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'guéri', 'page' => 1]) }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Voir les patients guéris
                        </a>
                    </div>
                </div>
            </div>

            <!-- Patients malades -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Patients malades
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ $stats['malades'] }}
                                    </div>
                                    <div class="ml-2 flex items-baseline text-sm font-semibold text-yellow-600">
                                        <span class="sr-only">
                                            Pourcentage
                                        </span>
                                        {{ $stats['total'] > 0 ? round(($stats['malades'] / $stats['total']) * 100) : 0 }}%
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'malade', 'page' => 1]) }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Voir les patients malades
                        </a>
                    </div>
                </div>
            </div>

            <!-- Décédés -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Décédés
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ $stats['decedes'] }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'décédé', 'page' => 1]) }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Voir les dossiers
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barre de recherche et filtres -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            @php
                $indexRoute = auth()->user()->role === 'Admin' ? route('admin.patients.index') : (auth()->user()->role === 'Secrétaire' ? route('secretaire.patients.index') : null);
            @endphp
            @if($indexRoute)
            <form method="GET" action="{{ $indexRoute }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Recherche -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" 
                               name="q" 
                               value="{{ $search }}" 
                               placeholder="Rechercher un patient..."
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Groupe sanguin -->
                    <div>
                        <select name="groupe_sanguin" onchange="this.form.submit()" 
                                class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
                            <option value="">Tous les groupes sanguins</option>
                            @foreach($groupesSanguins as $groupe)
                                <option value="{{ $groupe }}" {{ $groupeSanguin == $groupe ? 'selected' : '' }}>{{ $groupe }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Période -->
                    <div class="grid grid-cols-2 gap-2">
                        <input type="date" name="date_debut" value="{{ $dateDebut }}" onchange="this.form.submit()" 
                               class="block w-full pl-3 pr-3 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm"
                               placeholder="Date début">
                        <input type="date" name="date_fin" value="{{ $dateFin }}" onchange="this.form.submit()"
                               class="block w-full pl-3 pr-3 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm"
                               placeholder="Date fin">
                    </div>

                    <!-- Bouton de réinitialisation -->
                    <div class="flex items-center">
                        <a href="{{ $indexRoute }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Réinitialiser
                        </a>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-4 items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <label for="status" class="mr-2 text-sm font-medium text-gray-700">Statut :</label>
                            <select id="status" name="status" onchange="this.form.submit()" 
                                    class="block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
                                <option value="">Tous</option>
                                <option value="guéri" {{ $status == 'guéri' ? 'selected' : '' }}>Guéri</option>
                                <option value="malade" {{ $status == 'malade' ? 'selected' : '' }}>Malade</option>
                                <option value="décédé" {{ $status == 'décédé' ? 'selected' : '' }}>Décédé</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center">
                            <label for="sort" class="mr-2 text-sm font-medium text-gray-700">Trier par :</label>
                            <select id="sort" name="tri" onchange="this.form.submit()" 
                                    class="block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
                                <option value="recent" {{ $tri == 'recent' ? 'selected' : '' }}>Plus récent</option>
                                <option value="ancien" {{ $tri == 'ancien' ? 'selected' : '' }}>Plus ancien</option>
                                <option value="nom_asc" {{ $tri == 'nom_asc' ? 'selected' : '' }}>Nom (A-Z)</option>
                                <option value="nom_desc" {{ $tri == 'nom_desc' ? 'selected' : '' }}>Nom (Z-A)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="text-sm text-gray-500">
                        {{ $patients->total() }} {{ Str::plural('patient', $patients->total()) }} trouvé(s)
                    </div>
                </div>
            </form>
            @endif
        </div>

        <!-- Message de succès -->
        @if ($message = Session::get('success'))
            <div class="rounded-md bg-green-50 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ $message }}</p>
                    </div>
                </div>
            </div>
        @endif
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <!-- En-tête du tableau (visible sur desktop) -->
            <div class="hidden md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Patient
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Informations
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dernière consultation
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($patients as $patient)
                        <tr class="hover:bg-gray-50">
                            <!-- Colonne Patient -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold">
                                        {{ strtoupper(substr($patient->prenom, 0, 1)) }}{{ strtoupper(substr($patient->nom, 0, 1)) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $patient->prenom }} {{ $patient->nom }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            #{{ $patient->numero_dossier }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Colonne Informations -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        {{ $patient->email ?? 'Non renseigné' }}
                                    </div>
                                    <div class="flex items-center mt-1">
                                        <svg class="h-4 w-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {{ $patient->telephone ?? 'Non renseigné' }}
                                    </div>
                                    <div class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $patient->groupe_sanguin ?? 'GS non renseigné' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <!-- Dernière consultation -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($patient->latestConsultation)
                                    <div class="text-sm text-gray-900">
                                        {{ $patient->latestConsultation->date_consultation->format('d/m/Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $patient->latestConsultation->motif ?? 'Sans motif' }}
                                    </div>
                                    @if($patient->latestConsultation->medecin)
                                    <div class="text-xs text-gray-500 mt-1">
                                        Dr. {{ $patient->latestConsultation->medecin->prenom }} {{ $patient->latestConsultation->medecin->nom }}
                                    </div>
                                    @endif
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Aucune consultation
                                    </span>
                                @endif
                            </td>
                            <!-- Statut -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'guéri' => 'bg-gradient-to-r from-green-500 to-emerald-500',
                                        'malade' => 'bg-gradient-to-r from-amber-500 to-orange-500',
                                        'décédé' => 'bg-gradient-to-r from-red-500 to-rose-500',
                                        'default' => 'bg-gray-200 text-gray-800'
                                    ];
                                    $statusKey = strtolower($patient->statut ?? '');
                                    $color = $statusColors[$statusKey] ?? $statusColors['default'];
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full text-white {{ $color }}">
                                    {{ ucfirst($patient->statut) }}
                                </span>
                                <div class="text-xs text-gray-500 mt-1">
                                    Inscrit le {{ $patient->created_at->format('d/m/Y') }}
                                </div>
                                @if($patient->date_naissance)
                                <div class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($patient->date_naissance)->age }} ans
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    @php
                                        $showRoute = auth()->user()->role === 'Admin' ? route('admin.patients.show', $patient->id) : (auth()->user()->role === 'Secrétaire' ? route('secretaire.patients.show', $patient->id) : null);
                                    @endphp
                                    @if($showRoute)
                                    <a href="{{ $showRoute }}" 
                                       class="text-blue-600 hover:text-blue-900 p-1 rounded-full hover:bg-blue-50"
                                       title="Voir le dossier">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    @endif

                                    @php
                                        $editRoute = auth()->user()->role === 'Admin' ? route('admin.patients.edit', $patient->id) : (auth()->user()->role === 'Secrétaire' ? route('secretaire.patients.edit', $patient->id) : null);
                                    @endphp
                                    @if($editRoute)
                                    <a href="{{ $editRoute }}" 
                                       class="text-green-600 hover:text-green-900 p-1 rounded-full hover:bg-green-50"
                                       title="Modifier">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    @endif

                                    @if(auth()->user()->role === 'Admin')
                                    <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST" class="inline-block"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement le patient {{ addslashes($patient->prenom) }} {{ addslashes($patient->nom) }} ? Toutes les données associées seront perdues.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 p-1 rounded-full hover:bg-red-50"
                                                title="Supprimer">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Aucun patient trouvé.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div> <!-- Fermeture du conteneur de la table desktop -->

        <!-- Vue mobile (cartes) -->
        <div class="md:hidden space-y-4">
            @forelse ($patients as $patient)
            <div class="bg-white shadow overflow-hidden rounded-lg border border-gray-200">
                <!-- En-tête de la carte -->
                <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center min-w-0">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold">
                                {{ strtoupper(substr($patient->prenom, 0, 1)) }}{{ strtoupper(substr($patient->nom, 0, 1)) }}
                            </div>
                            <div class="ml-3 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $patient->prenom }} {{ $patient->nom }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ $patient->email ?? 'Aucun email' }}</p>
                            </div>
                        </div>
                        <div class="ml-2 flex-shrink-0">
                            @php
                                $statusColors = [
                                    'guéri' => 'bg-gradient-to-r from-green-500 to-emerald-500',
                                    'malade' => 'bg-gradient-to-r from-amber-500 to-orange-500',
                                    'décédé' => 'bg-gradient-to-r from-red-500 to-rose-500',
                                    'default' => 'bg-gray-200 text-gray-800'
                                ];
                                $statusKey = strtolower($patient->statut ?? '');
                                $color = $statusColors[$statusKey] ?? $statusColors['default'];
                            @endphp
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full text-white {{ $color }}">
                                {{ ucfirst($patient->statut) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Corps de la carte -->
                <div class="px-4 py-4">
                    <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                        <div>
                            <p class="text-gray-500 font-medium">Naissance</p>
                            <p class="text-gray-900">{{ $patient->date_naissance ? \Carbon\Carbon::parse($patient->date_naissance)->format('d/m/Y') : 'N/D' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 font-medium">Téléphone</p>
                            <p class="text-gray-900">{{ $patient->telephone ?? 'N/D' }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-gray-500 font-medium">Dernière consultation</p>
                            @if ($patient->latestConsultation)
                                <p class="text-gray-900">{{ \Carbon\Carbon::parse($patient->latestConsultation->date_consultation)->format('d/m/Y') }}</p>
                            @else
                                <p class="text-gray-900">Aucune</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Pied de la carte avec actions -->
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                    <div class="flex justify-end space-x-2">
                        @php
                            $showRoute = auth()->user()->role === 'Admin' ? route('admin.patients.show', $patient->id) : (auth()->user()->role === 'Secrétaire' ? route('secretaire.patients.show', $patient->id) : null);
                        @endphp
                        @if($showRoute)
                        <a href="{{ $showRoute }}" class="text-blue-600 hover:text-blue-900 p-1 rounded-full hover:bg-blue-50" title="Voir">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </a>
                        @endif

                        @php
                            $editRoute = auth()->user()->role === 'Admin' ? route('admin.patients.edit', $patient->id) : (auth()->user()->role === 'Secrétaire' ? route('secretaire.patients.edit', $patient->id) : null);
                        @endphp
                        @if($editRoute)
                        <a href="{{ $editRoute }}" class="text-green-600 hover:text-green-900 p-1 rounded-full hover:bg-green-50" title="Modifier">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </a>
                        @endif

                        @if(auth()->user()->role === 'Admin')
                        <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement le patient {{ addslashes($patient->prenom) }} {{ addslashes($patient->nom) }} ? Toutes les données associées seront perdues.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 p-1 rounded-full hover:bg-red-50" title="Supprimer">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <p class="text-gray-500">Aucun patient trouvé.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $patients->links() }}
        </div>
    </div>
@endsection
