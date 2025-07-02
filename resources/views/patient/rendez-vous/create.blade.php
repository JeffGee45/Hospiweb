@extends('layouts.app')

@section('title', 'Prendre un rendez-vous')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Prendre un rendez-vous</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulaire de demande de rendez-vous</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('patient.rendez-vous.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="medecin_id">Choisir un médecin</label>
                    <select class="form-control @error('medecin_id') is-invalid @enderror" id="medecin_id" name="medecin_id" required>
                        <option value="">-- Sélectionnez un médecin --</option>
                        @foreach ($medecins as $medecin)
                            <option value="{{ $medecin->id }}" {{ old('medecin_id') == $medecin->id ? 'selected' : '' }}>
                                Dr. {{ $medecin->user->name }} (Spécialité: {{ $medecin->specialite }})
                            </option>
                        @endforeach
                    </select>
                    @error('medecin_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="date_rendez_vous">Date et heure du rendez-vous</label>
                    <input type="datetime-local" class="form-control @error('date_rendez_vous') is-invalid @enderror" id="date_rendez_vous" name="date_rendez_vous" value="{{ old('date_rendez_vous') }}" required>
                    @error('date_rendez_vous')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="motif">Motif du rendez-vous</label>
                    <textarea class="form-control @error('motif') is-invalid @enderror" id="motif" name="motif" rows="4" required>{{ old('motif') }}</textarea>
                    @error('motif')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Envoyer la demande</button>
                <a href="{{ route('patient.rendez-vous.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection
