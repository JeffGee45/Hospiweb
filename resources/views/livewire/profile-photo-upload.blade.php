<div class="space-y-4">
    <div class="flex flex-col items-center space-y-4 sm:flex-row sm:space-x-6 sm:space-y-0">
        <!-- Photo actuelle ou aperçu -->
        <div class="shrink-0 flex flex-col items-center">
            <div class="relative">
                @if($previewImage)
                    <!-- Aperçu de la nouvelle image -->
                    <img class="h-32 w-32 rounded-full object-cover border-4 border-blue-300 shadow-md" 
                         src="{{ $previewImage }}" 
                         alt="Nouvelle photo de profil">
                @elseif($user->photo)
                    <!-- Photo actuelle -->
                    <img class="h-32 w-32 rounded-full object-cover border-4 border-white shadow" 
                         src="{{ asset('storage/' . $user->photo) }}?{{ time() }}" 
                         alt="Photo de profil de {{ $user->name }}">
                @else
                    <!-- Aucune photo - avatar par défaut -->
                    <div class="h-32 w-32 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center shadow">
                        <svg class="h-16 w-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                @endif
                
                <!-- Indicateur de chargement -->
                @if($isUploading)
                    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30 rounded-full">
                        <svg class="animate-spin h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                @endif
            </div>
            
            <!-- Indications format photo -->
            <p class="mt-2 text-xs text-gray-500 text-center">Format recommandé : JPG, PNG<br>Min. 200x200 px</p>
        </div>

        @if($editable)
            <!-- Actions de téléchargement -->
            <div class="space-y-3 w-full sm:w-auto">
                <div class="flex flex-col space-y-2">
                    <label class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 cursor-pointer transition duration-150 ease-in-out">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        <span>Choisir une photo</span>
                        <input type="file" class="hidden" wire:model="photo" accept="image/jpeg,image/png">
                    </label>
                    
                    @if($user->photo)
                        <button type="button" 
                                wire:click="removePhoto"
                                wire:confirm="Êtes-vous sûr de vouloir supprimer votre photo de profil ?"
                                class="inline-flex items-center justify-center px-4 py-2 bg-white border border-red-300 rounded-md font-medium text-sm text-red-700 shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Supprimer la photo
                        </button>
                    @endif
                </div>
                
                <!-- Messages d'erreur -->
                @error('photo')
                    <div class="mt-2 p-3 bg-red-50 border-l-4 border-red-400 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">{{ $message }}</p>
                            </div>
                        </div>
                    </div>
                @enderror
                
                <!-- Barre de progression -->
                @if($isUploading)
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $uploadProgress }}%"></div>
                    </div>
                    <p class="text-xs text-gray-600">Téléversement en cours... {{ $uploadProgress }}%</p>
                @endif
                
                <!-- Bouton Annuler la sélection -->
                @if($previewImage)
                    <button type="button"
                            wire:click="resetPreview"
                            class="mt-2 inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-0.5 mr-1.5 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Annuler la sélection
                    </button>
                @endif
            </div>
        @else
            <!-- Afficher uniquement les informations de l'utilisateur -->
            <div class="space-y-2">
                <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                <p class="text-sm text-gray-500">{{ $user->role }}</p>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>
        @endif
        </div>
    </div>
</div>

    <!-- Message de confirmation -->
    @if(session()->has('message'))
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 5000)"
             class="p-4 mt-4 text-sm text-green-700 bg-green-100 rounded-lg">
            {{ session('message') }}
        </div>
    @endif
    
    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                @this.on('uploadProgress', (progress) => {
                    // Mise à jour de la barre de progression
                    @this.set('uploadProgress', progress);
                });
                
                @this.on('uploadComplete', () => {
                    // Réinitialisation après téléchargement
                    setTimeout(() => {
                        @this.set('uploadProgress', 0);
                        @this.set('isUploading', false);
                    }, 1000);
                });
            });
        </script>
    @endpush
</div>
