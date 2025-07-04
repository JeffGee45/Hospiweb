@extends('medecin.ordonnances.form', [
    'ordonnance' => new App\Models\Ordonnance([
        'date_ordonnance' => now()
    ]),
    'patients' => $patients ?? [],
    'consultations' => $consultations ?? [],
    'selectedPatient' => $selectedPatient ?? null,
    'consultation' => $consultation ?? null
])
