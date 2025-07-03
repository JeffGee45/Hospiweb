@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Mon Profil</h2>
                    {{-- <div class="flex space-x-4">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Modifier le profil
                        </a>
                    </div> --}}
                </div>
                
                @if (session('message'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('message') }}
                    </div>
                @endif
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Photo de profil -->
                    <div class="lg:col-span-1">
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Photo de profil</h3>
                            <livewire:profile-photo-upload :user="$user" :editable="false" />
                        </div>
                    </div>
                    
                    <!-- Informations de l'utilisateur -->
                    <div class="lg:col-span-2">
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6 bg-gray-50">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Informations du compte
                                </h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                    Détails personnels et informations de connexion.
                                </p>
                            </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            <!-- Informations de base -->
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Nom complet
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $user->name }}
                                </dd>
                            </div>
                            
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Adresse email
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $user->email }}
                                </dd>
                            </div>
                            
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Téléphone
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $user->telephone ?? 'Non renseigné' }}
                                </dd>
                            </div>
                            
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Rôle
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ ucfirst($user->role) }}
                                </dd>
                            </div>
                            
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Compte créé le
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $user->created_at->format('d/m/Y à H:i') }}
                                </dd>
                            </div>
                            
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Dernière connexion
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Jamais' }}
                                </dd>
                            </div>
                            
                            @if($user->adresse)
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Adresse
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $user->adresse }}
                                    @if($user->code_postal || $user->ville)
                                        <br>
                                        {{ $user->code_postal }} {{ $user->ville }}
                                    @endif
                                    @if($user->pays)
                                        <br>
                                        {{ $user->pays }}
                                    @endif
                                </dd>
                            </div>
                            @endif
                        </dl>
                        
                        <!-- Actions -->
                        <div class="flex justify-end space-x-4 px-4 py-3 bg-gray-50 text-right sm:px-6 rounded-b-lg">
                            <!-- Bouton Changer de mot de passe masqué pour le moment -->
                            @if(false)
                            <a href="#" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 opacity-50 cursor-not-allowed" disabled>
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                Changer de mot de passe
                            </a>
                            @endif
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                Modifier le profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
