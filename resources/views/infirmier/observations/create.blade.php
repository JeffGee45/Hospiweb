@extends('infirmier.observations.form', [
    'selectedPatient' => $selectedPatient ?? null,
    'patients' => $patients ?? [],
])
