@props(['patient'])

<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Informations médicales</h2>
        <button type="button" class="text-blue-600 hover:text-blue-800 text-sm font-medium"
                onclick="document.getElementById('editMedicalInfo').classList.toggle('hidden')">
            <i class="fas fa-edit mr-1"></i> Modifier
        </button>
    </div>
    
    <!-- Vue des informations -->
    <div id="viewMedicalInfo">
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Groupe sanguin</p>
                    <p class="font-medium">{{ $patient->groupe_sanguin ?? 'Non renseigné' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Allergies</p>
                    <p class="font-medium">{{ $patient->allergies_formatted }}</p>
                </div>
            </div>
            
            <div>
                <p class="text-sm text-gray-500">Antécédents médicaux</p>
                <div class="whitespace-pre-line font-medium">{{ $patient->antecedents_formatted }}</div>
            </div>
            
            <div>
                <p class="text-sm text-gray-500">Traitements en cours</p>
                <div class="whitespace-pre-line font-medium">{{ $patient->traitements_formatted }}</div>
            </div>
        </div>
    </div>
    
    <!-- Formulaire d'édition -->
    <div id="editMedicalInfo" class="hidden">
        <form action="{{ route('patients.update', $patient) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="groupe_sanguin" class="block text-sm font-medium text-gray-700">Groupe sanguin</label>
                        <select id="groupe_sanguin" name="groupe_sanguin" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Sélectionner...</option>
                            <option value="A+" {{ $patient->groupe_sanguin === 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ $patient->groupe_sanguin === 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ $patient->groupe_sanguin === 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ $patient->groupe_sanguin === 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="AB+" {{ $patient->groupe_sanguin === 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ $patient->groupe_sanguin === 'AB-' ? 'selected' : '' }}>AB-</option>
                            <option value="O+" {{ $patient->groupe_sanguin === 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ $patient->groupe_sanguin === 'O-' ? 'selected' : '' }}>O-</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label for="allergies" class="block text-sm font-medium text-gray-700">Allergies (une par ligne)</label>
                    <textarea id="allergies" name="allergies" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ is_array($patient->allergies) ? implode("\n", $patient->allergies) : $patient->allergies }}</textarea>
                </div>
                
                <div>
                    <label for="antecedents_medicaux" class="block text-sm font-medium text-gray-700">Antécédents médicaux</label>
                    <textarea id="antecedents_medicaux" name="antecedents_medicaux" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ is_array($patient->antecedents_medicaux) ? implode("\n", $patient->antecedents_medicaux) : $patient->antecedents_medicaux }}</textarea>
                </div>
                
                <div>
                    <label for="traitements_en_cours" class="block text-sm font-medium text-gray-700">Traitements en cours</label>
                    <textarea id="traitements_en_cours" name="traitements_en_cours" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ is_array($patient->traitements_en_cours) ? implode("\n", $patient->traitements_en_cours) : $patient->traitements_en_cours }}</textarea>
                </div>
                
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" onclick="document.getElementById('editMedicalInfo').classList.add('hidden');" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Annuler
                    </button>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Enregistrer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
