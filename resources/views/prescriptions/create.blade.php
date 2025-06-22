@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Créer une Prescription pour la Consultation du {{ \Carbon\Carbon::parse($consultation->date_consultation)->format('d/m/Y') }}</h1>

        <form action="{{ route('consultations.prescriptions.store', $consultation) }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="date_prescription" class="block text-gray-700 text-sm font-bold mb-2">Date de Prescription</label>
                <input type="date" id="date_prescription" name="date_prescription" value="{{ old('date_prescription', now()->format('Y-m-d')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('date_prescription') border-red-500 @enderror">
                @error('date_prescription')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <hr class="my-6">

            <h2 class="text-xl font-semibold text-gray-700 mb-4">Médicaments</h2>
            <div id="medicaments-container">
                <!-- Les lignes de médicaments seront ajoutées ici par JS -->
            </div>

            @if ($errors->has('medicaments'))
                <p class="text-red-500 text-xs italic mt-2">{{ $errors->first('medicaments') }}</p>
            @endif

            <button type="button" id="add-medicament" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Ajouter un médicament
            </button>

            <div class="flex items-center justify-between mt-8">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Enregistrer la Prescription
                </button>
                <a href="{{ route('consultations.show', $consultation->id) }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('medicaments-container');
    const addButton = document.getElementById('add-medicament');
    let medicamentIndex = 0;

    function addMedicamentRow() {
        const medicamentRow = document.createElement('div');
        medicamentRow.classList.add('medicament-row', 'grid', 'grid-cols-12', 'gap-4', 'mb-4', 'items-center');
        medicamentRow.innerHTML = `
            <div class="col-span-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nom du médicament</label>
                <input type="text" name="medicaments[${medicamentIndex}][nom_medicament]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="col-span-3">
                <label class="block text-gray-700 text-sm font-bold mb-2">Dosage</label>
                <input type="text" name="medicaments[${medicamentIndex}][dosage]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="col-span-3">
                <label class="block text-gray-700 text-sm font-bold mb-2">Durée</label>
                <input type="text" name="medicaments[${medicamentIndex}][duree]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="col-span-2 flex items-end">
                <button type="button" class="remove-medicament bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Retirer
                </button>
            </div>
        `;
        container.appendChild(medicamentRow);
        medicamentIndex++;
    }

    addButton.addEventListener('click', addMedicamentRow);

    container.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-medicament')) {
            e.target.closest('.medicament-row').remove();
        }
    });

    // Ajouter une première ligne au chargement
    addMedicamentRow();
});
</script>
@endsection
