@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier l'utilisateur : {{ $user->name }}</h1>
    <form action="{{ route('users.update', $user) }}" method="POST">
        @method('PUT')
        @include('admin.users._form')
    </form>
</div>
@endsection
