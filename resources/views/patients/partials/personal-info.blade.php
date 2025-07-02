@props(['patient'])

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Informations personnelles</h2>
    <div class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Date de naissance</p>
                <p class="font-medium">{{ $patient->date_naissance->format('d/m/Y') }} ({{ $patient->age }} ans)</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Lieu de naissance</p>
                <p class="font-medium">{{ $patient->lieu_naissance ?? 'Non renseigné' }}</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Téléphone</p>
                <p class="font-medium">{{ $patient->telephone ?? 'Non renseigné' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Profession</p>
                <p class="font-medium">{{ $patient->profession ?? 'Non renseignée' }}</p>
            </div>
        </div>
        
        <div>
            <p class="text-sm text-gray-500">Adresse</p>
            <p class="font-medium">{{ $patient->adresse ?? 'Non renseignée' }}</p>
        </div>
        
        <div class="pt-4 border-t border-gray-100">
            <h3 class="text-md font-medium text-gray-700 mb-2">Contact d'urgence</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Nom</p>
                    <p class="font-medium">{{ $patient->nom_contact_urgence ?? 'Non renseigné' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Téléphone</p>
                    <p class="font-medium">{{ $patient->telephone_contact_urgence ?? 'Non renseigné' }}</p>
                </div>
                @if($patient->lien_contact_urgence)
                <div>
                    <p class="text-sm text-gray-500">Lien</p>
                    <p class="font-medium">{{ $patient->lien_contact_urgence }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
