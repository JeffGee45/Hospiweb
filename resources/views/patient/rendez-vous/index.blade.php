@extends('layouts.app')

@section('title', 'Mes Rendez-vous')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mes Rendez-vous</h1>
        <a href="{{ route('patient.rendez-vous.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Prendre un nouveau rendez-vous
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste de mes rendez-vous</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Médecin</th>
                            <th>Date et Heure</th>
                            <th>Motif</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rendezVous as $rdv)
                            <tr>
                                <td>Dr. {{ $rdv->medecin->user->name }}</td>
                                <td>{{ $rdv->date_rendez_vous->format('d/m/Y à H:i') }}</td>
                                <td>{{ Str::limit($rdv->motif, 50) }}</td>
                                <td>
                                    <span class="badge badge-{{ App\Helpers\StatusHelper::rdvStatusClass($rdv->statut) }}">
                                        {{ ucfirst($rdv->statut) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('patient.rendez-vous.show', $rdv->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(in_array($rdv->statut, ['en_attente', 'confirme']) && $rdv->date_rendez_vous > now())
                                        <form action="{{ route('patient.rendez-vous.annuler', $rdv->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler ce rendez-vous ?');">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Vous n'avez aucun rendez-vous pour le moment.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $rendezVous->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
