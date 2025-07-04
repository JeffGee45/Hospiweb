@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h2 class="text-2xl font-semibold leading-tight">Détails du soin pour {{ $soin->hospitalisation->patient->name }}</h2>

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 mt-6">
            <div class="mb-4">
                <p><strong class="text-gray-700">Type de soin:</strong> {{ $soin->type_soin }}</p>
            </div>
            <div class="mb-4">
                <p><strong class="text-gray-700">Description:</strong> {{ $soin->description }}</p>
            </div>
            <div class="mb-4">
                <p><strong class="text-gray-700">Date et Heure:</strong> {{ $soin->date_soin->format('d/m/Y H:i') }}</p>
            </div>
            <div class="mb-4">
                <p><strong class="text-gray-700">Effectué par:</strong> {{ $soin->user->name }}</p>
            </div>
            @if($soin->notes)
            <div class="mb-4">
                <p><strong class="text-gray-700">Notes:</strong> {{ $soin->notes }}</p>
            </div>
            @endif

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('infirmier.soins.edit', $soin->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Modifier</a>
                <a href="{{ route('infirmier.patients.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
