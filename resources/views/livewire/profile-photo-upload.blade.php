<div class="space-y-4">
    <div class="flex items-center space-x-6">
        <!-- Photo actuelle -->
        <div class="shrink-0">
            @if($user->photo)
                <img class="h-24 w-24 rounded-full object-cover" 
                     src="{{ asset('storage/' . $user->photo) }}" 
                     alt="Photo de profil">
            @else
                <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center">
                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            @endif
        </div>

        <!-- Actions de téléchargement -->
        <div class="space-y-2">
            <div>
                <label class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 cursor-pointer">
                    <span>Télécharger une photo</span>
                    <input type="file" class="hidden" wire:model="photo" accept="image/*">
                </label>
            </div>
            
            @if($user->photo)
                <button type="button" 
                        wire:click="removePhoto"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Supprimer la photo
                </button>
            @endif
            
            @error('photo')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Barre de progression -->
    @if($isUploading)
        <div class="mt-4">
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $uploadProgress }}%"></div>
            </div>
            <p class="mt-1 text-sm text-gray-500">Téléchargement en cours... {{ $uploadProgress }}%</p>
        </div>
    @endif

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
