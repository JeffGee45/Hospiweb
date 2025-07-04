@extends('medecin.ordonnances.form', [
    'ordonnance' => $ordonnance,
    'patients' => collect([$ordonnance->patient]),
    'consultations' => collect([$ordonnance->consultation])
])

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Désactiver les champs de sélection en mode édition
        const patientSelect = document.getElementById('patient_id');
        const consultationSelect = document.getElementById('consultation_id');
        
        if (patientSelect) patientSelect.disabled = true;
        if (consultationSelect) consultationSelect.disabled = true;
    });
</script>
@endpush
