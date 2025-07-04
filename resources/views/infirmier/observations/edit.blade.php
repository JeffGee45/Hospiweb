@extends('infirmier.observations.form', [
    'observation' => $observation,
    'selectedPatient' => $observation->patient,
    'patients' => $patients ?? collect([$observation->patient])
])
