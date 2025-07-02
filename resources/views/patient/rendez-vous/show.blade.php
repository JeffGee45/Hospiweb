@extends('layouts.app')

@section('title', 'Détails du rendez-vous')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Détails du rendez-vous</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Rendez-vous du {{ $rendezVous->date_rendez_vous->format('d/m/Y') }}</h6>
            <span class="badge badge-{{ App\Helpers\StatusHelper::rdvStatusClass($rendezVous->statut) }} p-2">
                {{ ucfirst($rendezVous->statut) }}
            </span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Médecin:</strong> Dr. {{ $rendezVous->medecin->user->name }}</p>
                    <p><strong>Spécialité:</strong> {{ $rendezVous->medecin->specialite }}</p>
                    <p><strong>Date et Heure:</strong> {{ $rendezVous->date_rendez_vous->format('d/m/Y à H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Patient:</strong> {{ $rendezVous->patient->user->name }}</p>
                    <p><strong>Type de rendez-vous:</strong> {{ ucfirst($rendezVous->type_rendez_vous) }}</p>
                    <p><strong>Demandé le:</strong> {{ $rendezVous->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            <hr>
            <h5>Motif du rendez-vous</h5>
            <p>{{ $rendezVous->motif }}</p>

            @if($rendezVous->notes)
                <hr>
                <h5>Notes du médecin</h5>
                <p>{{ $rendezVous->notes }}</p>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('patient.rendez-vous.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
            @if(in_array($rendezVous->statut, ['en_attente', 'confirme']) && $rendezVous->date_rendez_vous > now())
                <form action="{{ route('patient.rendez-vous.annuler', $rendezVous->id) }}" method="POST" class="d-inline float-right" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler ce rendez-vous ?');">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> Annuler le rendez-vous
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
