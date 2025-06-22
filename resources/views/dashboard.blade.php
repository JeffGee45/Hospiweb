@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ __('messages.Dashboard') }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Nombre de Patients</h2>
            <p class="text-4xl font-bold text-blue-600 mt-2">{{ $patients->count() }}</p>
        </div>
        
        {{-- Vous pouvez ajouter d'autres cartes ici --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Rendez-vous Aujourd'hui</h2>
            <p class="text-4xl font-bold text-green-600 mt-2">0</p> {{-- Logique à implémenter --}}
        </div>

    </div>

    {{-- Vous pouvez ajouter une liste des derniers patients ici si vous le souhaitez --}}

</div>
@endsection
