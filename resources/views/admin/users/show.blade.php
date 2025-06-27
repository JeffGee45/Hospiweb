@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails de l'utilisateur</h1>
    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $user->name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ $user->email }}</h6>
            <p class="card-text">
                <strong>Rôle :</strong> {{ $user->role }}<br>
                <strong>Créé le :</strong> {{ $user->created_at->format('d/m/Y H:i') }}<br>
                <strong>Dernière mise à jour :</strong> {{ $user->updated_at->format('d/m/Y H:i') }}
            </p>
            <div class="mt-3">
                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">Modifier</a>
                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</button>
                </form>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Retour à la liste</a>
            </div>
        </div>
    </div>
</div>
@endsection
