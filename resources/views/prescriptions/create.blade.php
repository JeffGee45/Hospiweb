@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-prescription mr-2 text-blue-600"></i>
                    Nouvelle Prescription - Consultation du {{ \Carbon\Carbon::parse($consultation->date_consultation)->format('d/m/Y') }}
                </h1>
                <div class="text-sm text-gray-600">
                    <span class="font-semibold">Patient :</span> 
                    {{ $consultation->patient->prenom }} {{ $consultation->patient->nom }}
                </div>
            </div>

            <form action="{{ route('consultations.prescriptions.store', $consultation) }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date_prescription" class="block text-gray-700 text-sm font-bold mb-2">
                            <i class="far fa-calendar-alt mr-1"></i> Date de Prescription
                        </label>
                        <input type="date" id="date_prescription" name="date_prescription"
                            value="{{ old('date_prescription', now()->format('Y-m-d')) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('date_prescription') border-red-500 @enderror">
                        @error('date_prescription')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="validite" class="block text-gray-700 text-sm font-bold mb-2">
                            <i class="far fa-clock mr-1"></i> Validité de l'ordonnance
                        </label>
                        <select id="validite" name="validite" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="3">3 mois</option>
                            <option value="1" selected>1 mois</option>
                            <option value="6">6 mois</option>
                            <option value="12">1 an</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-700">
                            <i class="fas fa-pills mr-2 text-blue-600"></i>Médicaments prescrits
                        </h2>
                        <button type="button" id="add-medicament"
                            class="flex items-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Ajouter un médicament
                        </button>
                    </div>

                    <div id="medicaments-container" class="space-y-4">
                        <!-- Les lignes de médicaments seront ajoutées ici par JS -->
                    </div>

                    @if ($errors->has('medicaments'))
                        <p class="text-red-500 text-sm italic mt-2">{{ $errors->first('medicaments') }}</p>
                    @endif
                </div>

                <div class="mt-8">
                    <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="far fa-edit mr-1"></i> Notes complémentaires
                    </label>
                    <textarea id="notes" name="notes" rows="3"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('notes') }}</textarea>
                </div>

                <div class="flex items-center justify-between pt-6 border-t mt-8">
                    <a href="{{ route('consultations.show', $consultation->id) }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour
                    </a>
                    <div class="space-x-3">
                        <button type="button" id="save-draft"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            <i class="far fa-save mr-2"></i>
                            Enregistrer comme brouillon
                        </button>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-check-circle mr-2"></i>
                            Valider la prescription
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Template pour une ligne de médicament -->
    <template id="medicament-template">
        <div class="medicament-row bg-gray-50 p-4 rounded-lg border border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                <div class="md:col-span-4">
                    <label class="block text-gray-700 text-sm font-medium mb-1">Médicament</label>
                    <div class="relative">
                        <input type="text" name="medicaments[INDEX][nom_medicament]" 
                            class="medicament-nom shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"
                            placeholder="Commencez à taper le nom du médicament" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-medium mb-1">Dosage</label>
                    <input type="text" name="medicaments[INDEX][dosage]" 
                        class="medicament-dosage shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"
                        placeholder="Ex: 1 comprimé">
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-medium mb-1">Fréquence</label>
                    <select name="medicaments[INDEX][frequence]" 
                        class="medicament-frequence shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                        <option value="1x/jour">1 fois/jour</option>
                        <option value="2x/jour" selected>2 fois/jour</option>
                        <option value="3x/jour">3 fois/jour</option>
                        <option value="4x/jour">4 fois/jour</option>
                        <option value="Toutes les 6h">Toutes les 6h</option>
                        <option value="Toutes les 8h">Toutes les 8h</option>
                        <option value="Toutes les 12h">Toutes les 12h</option>
                        <option value="Si douleur">Si douleur</option>
                        <option value="Au coucher">Au coucher</option>
                    </select>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-medium mb-1">Durée</label>
                    <input type="text" name="medicaments[INDEX][duree]" 
                        class="medicament-duree shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"
                        placeholder="Ex: 7 jours">
                </div>
                
                <div class="md:col-span-1">
                    <label class="block text-gray-700 text-sm font-medium mb-1">Quantité</label>
                    <input type="number" name="medicaments[INDEX][quantite]" min="1" value="1"
                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                </div>
                
                <div class="md:col-span-1 flex items-end justify-end">
                    <button type="button" class="remove-medicament text-red-600 hover:text-red-800 p-2">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
            
            <div class="mt-3">
                <label class="block text-gray-700 text-sm font-medium mb-1">Instructions spéciales</label>
                <input type="text" name="medicaments[INDEX][instructions]" 
                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"
                    placeholder="Ex: Prendre pendant les repas">
            </div>
        </div>
    </template>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.min.css">
        <style>
            .medicament-row {
                transition: all 0.2s ease-in-out;
            }
            .medicament-row:hover {
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }
            .remove-medicament {
                transition: transform 0.2s;
            }
            .remove-medicament:hover {
                transform: scale(1.1);
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('medicaments-container');
                const addButton = document.getElementById('add-medicament');
                const template = document.getElementById('medicament-template');
                let medicamentIndex = 0;
                
                // Liste des médicaments courants avec leurs dosages et durées par défaut
                const medicaments = [
                    { 
                        nom: 'Paracétamol 1000mg', 
                        dosage: '1 comprimé', 
                        duree: '7 jours',
                        frequence: '3x/jour',
                        instructions: 'En cas de douleur, à renouveler si besoin après 6h',
                        classe: 'Analgésique, Antipyrétique'
                    },
                    { 
                        nom: 'Ibuprofène 400mg', 
                        dosage: '1 comprimé', 
                        duree: '5 jours',
                        frequence: '3x/jour',
                        instructions: 'À prendre pendant les repas',
                        classe: 'Anti-inflammatoire non stéroïdien'
                    },
                    { 
                        nom: 'Amoxicilline 1g', 
                        dosage: '1 comprimé', 
                        duree: '7 jours',
                        frequence: '2x/jour',
                        instructions: 'À distance des repas',
                        classe: 'Antibiotique bêta-lactamine'
                    },
                    { 
                        nom: 'Doliprane 1000mg', 
                        dosage: '1 comprimé', 
                        duree: '5 jours',
                        frequence: '3x/jour',
                        instructions: 'En cas de fièvre ou douleur',
                        classe: 'Analgésique, Antipyrétique'
                    },
                    { 
                        nom: 'Spasfon 80mg', 
                        dosage: '2 comprimés', 
                        duree: '3 jours',
                        frequence: '3x/jour',
                        instructions: 'À sucer lentement',
                        classe: 'Antispasmodique'
                    },
                    { 
                        nom: 'Voltarène 50mg', 
                        dosage: '1 comprimé', 
                        duree: '5 jours',
                        frequence: '2x/jour',
                        instructions: 'Pendant les repas avec un grand verre d\'eau',
                        classe: 'Anti-inflammatoire non stéroïdien'
                    },
                    { 
                        nom: 'Gaviscon menthe', 
                        dosage: '1 à 2 cuillères à soupe', 
                        duree: '7 jours',
                        frequence: 'Après les repas et au coucher',
                        instructions: 'Bien agiter avant emploi',
                        classe: 'Anti-acide'
                    },
                    { 
                        nom: 'Smecta', 
                        dosage: '3 sachets par jour', 
                        duree: '3 jours',
                        frequence: '3x/jour',
                        instructions: 'Diluer dans un demi-verre d\'eau',
                        classe: 'Antidiarrhéique'
                    },
                    { 
                        nom: 'Mopral 20mg', 
                        dosage: '1 gélule', 
                        duree: '14 jours',
                        frequence: '1x/jour',
                        instructions: 'Le matin à jeun',
                        classe: 'Inhibiteur de la pompe à protons'
                    },
                    { 
                        nom: 'Aerius 5mg', 
                        dosage: '1 comprimé', 
                        duree: '7 jours',
                        frequence: '1x/jour',
                        instructions: 'Le soir au coucher',
                        classe: 'Antihistaminique H1'
                    }
                ];

                // Ajouter une ligne de médicament
                function addMedicamentRow(medicamentData = null) {
                    const newRow = document.createElement('div');
                    newRow.className = 'medicament-row';
                    newRow.innerHTML = template.innerHTML.replace(/INDEX/g, medicamentIndex);
                    container.appendChild(newRow);
                    
                    // Initialiser l'autocomplétion pour ce médicament
                    initializeAutocomplete(
                        newRow.querySelector('.medicament-nom'),
                        newRow.querySelector('.medicament-dosage'),
                        newRow.querySelector('.medicament-duree'),
                        newRow.querySelector('.medicament-frequence'),
                        newRow.querySelector('input[name$="[instructions]"]')
                    );
                    
                    // Remplir avec les données si fournies
                    if (medicamentData) {
                        newRow.querySelector('.medicament-nom').value = medicamentData.nom || '';
                        newRow.querySelector('.medicament-dosage').value = medicamentData.dosage || '';
                        newRow.querySelector('.medicament-duree').value = medicamentData.duree || '';
                        newRow.querySelector('.medicament-frequence').value = medicamentData.frequence || '2x/jour';
                        newRow.querySelector('input[name$="[quantite]"').value = medicamentData.quantite || '1';
                        newRow.querySelector('input[name$="[instructions]"').value = medicamentData.instructions || '';
                    }
                    
                    medicamentIndex++;
                    return newRow;
                }

                // Initialiser l'autocomplétion pour un champ de médicament
                function initializeAutocomplete(nomInput, dosageInput, dureeInput, frequenceSelect, instructionsInput) {
                    new autoComplete({
                        selector: () => nomInput,
                        placeHolder: "Rechercher un médicament...",
                        data: {
                            src: medicaments,
                            cache: true,
                            keys: ["nom", "classe"]
                        },
                        resultsList: {
                            element: (list, data) => {
                                if (data.results.length > 0) {
                                    const info = document.createElement("p");
                                    info.setAttribute("class", "p-2 text-xs text-gray-500 border-t mt-1");
                                    info.innerHTML = `Affichage de <strong>${data.results.length}</strong> résultat(s) sur <strong>${data.matches.length}</strong>`;
                                    list.prepend(info);
                                }
                            },
                            noResults: true,
                            maxResults: 10,
                            tabSelect: true
                        },
                        resultItem: {
                            element: (item, data) => {
                                // Style pour chaque élément de résultat
                                item.style = "display: flex; justify-content: space-between; width: 100%;";
                                item.innerHTML = `
                                    <span>${data.match}</span>
                                    <span class="text-xs text-gray-500">${data.value.classe}</span>
                                `;
                            },
                            highlight: true
                        },
                        events: {
                            input: {
                                selection: (event) => {
                                    const selection = event.detail.selection.value;
                                    nomInput.value = selection.nom;
                                    if (dosageInput) dosageInput.value = selection.dosage || '';
                                    if (dureeInput) dureeInput.value = selection.duree || '';
                                    if (frequenceSelect) frequenceSelect.value = selection.frequence || '2x/jour';
                                    if (instructionsInput) instructionsInput.value = selection.instructions || '';
                                    
                                    // Mettre le focus sur le champ suivant
                                    if (dosageInput && !dosageInput.value) {
                                        dosageInput.focus();
                                    } else if (dureeInput && !dureeInput.value) {
                                        dureeInput.focus();
                                    }
                                }
                            }
                        }
                    });
                    
                    // Ajouter la touche Entrée pour ajouter un nouveau médicament
                    nomInput.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' && nomInput.value.trim() !== '') {
                            e.preventDefault();
                            addMedicamentRow();
                            // Mettre le focus sur le nom du nouveau médicament
                            const newRow = container.lastElementChild;
                            if (newRow) {
                                const newInput = newRow.querySelector('.medicament-nom');
                                if (newInput) newInput.focus();
                            }
                        }
                    });
                }

                // Gestionnaire pour le bouton d'ajout
                addButton.addEventListener('click', () => addMedicamentRow());

                // Gestionnaire pour la suppression
                container.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-medicament')) {
                        const row = e.target.closest('.medicament-row');
                        if (row && container.querySelectorAll('.medicament-row').length > 1) {
                            row.style.opacity = '0';
                            setTimeout(() => row.remove(), 200);
                        } else if (row) {
                            // Réinitialiser le formulaire si c'est le dernier élément
                            const inputs = row.querySelectorAll('input, select');
                            inputs.forEach(input => {
                                if (input.type !== 'button' && input.type !== 'submit') {
                                    input.value = '';
                                    if (input.tagName === 'SELECT') {
                                        input.selectedIndex = 1; // 2ème option par défaut (2x/jour)
                                    }
                                }
                            });
                        }
                    }
                });

                // Sauvegarder comme brouillon
                document.getElementById('save-draft').addEventListener('click', function() {
                    // Ici, vous pourriez ajouter la logique pour sauvegarder comme brouillon
                    alert('Fonctionnalité de brouillon à implémenter');
                });

                // Ajouter une première ligne vide au chargement
                addMedicamentRow();
                
                // Raccourci clavier Ctrl+Entrée pour ajouter un nouveau médicament
                document.addEventListener('keydown', function(e) {
                    if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                        e.preventDefault();
                        addMedicamentRow();
                    }
                });
            });
        </script>
    @endpush
@endsection
