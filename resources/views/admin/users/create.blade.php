@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Créer un nouvel utilisateur</h1>
            <p class="text-gray-600 mt-1">Remplissez les informations pour créer un nouveau compte utilisateur</p>
        </div>
        <a href="{{ route('users.index') }}" class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour à la liste
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <form action="{{ route('users.store') }}" method="POST" class="p-6">
            @csrf
            <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2">
                @include('admin.users._form')
            </div>
            
            <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Annuler
                </a>
                <button type="submit" class="ml-3 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Créer l'utilisateur
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    /* Style personnalisé pour les champs de formulaire */
    .form-input, .form-select, .form-textarea {
        transition: all 0.2s ease-in-out;
    }
    
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 1px #3b82f6;
    }
    
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #4b5563;
        margin-bottom: 0.5rem;
    }
    
    .form-helper {
        display: block;
        margin-top: 0.25rem;
        font-size: 0.75rem;
        color: #6b7280;
    }
</style>
@endpush
@endsection
