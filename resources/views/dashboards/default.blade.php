@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tableau de bord</h1>
    <p>Bienvenue, {{ $user->name }} !</p>
    <p>Votre rôle n'a pas de tableau de bord spécifique.</p>
</div>
@endsection
