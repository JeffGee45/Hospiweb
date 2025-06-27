@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer un nouvel utilisateur</h1>
    <form action="{{ route('users.store') }}" method="POST">
        @include('admin.users._form')
    </form>
</div>
@endsection
