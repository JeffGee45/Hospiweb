@php
    $isEdit = isset($user) && $user->exists;
    $passwordRequired = !$isEdit ? 'required' : '';
    $passwordHelper = $isEdit ? ' (Laissez vide pour ne pas changer)' : '';
    
    // Définir les rôles s'ils ne sont pas déjà définis
    if (!isset($roles)) {
        $roles = ['Admin', 'Médecin', 'Infirmier', 'Secrétaire', 'Pharmacien', 'Caissier'];
    }
    
    $roleColors = [
        'Admin' => 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-100',
        'Médecin' => 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100',
        'Medecin' => 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100', // Alias pour compatibilité
        'Secrétaire' => 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100',
        'Secretaire' => 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100', // Alias pour compatibilité
        'Infirmier' => 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-100',
        'Pharmacien' => 'bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-100',
        'Caissier' => 'bg-pink-100 dark:bg-pink-900 text-pink-800 dark:text-pink-100',
        'default' => 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200'
    ];
    
    // Récupérer la valeur du rôle en tenant compte de l'ancienne entrée (en cas d'erreur de validation)
    $selectedRole = old('role', $user->role ?? null);
    
    // Gérer les alias de rôles (pour la rétrocompatibilité)
    if ($selectedRole === 'Medecin') $selectedRole = 'Médecin';
    if ($selectedRole === 'Secretaire') $selectedRole = 'Secrétaire';
@endphp

<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
        <!-- En-tête -->
        <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-700">
            <h2 class="text-xl font-semibold text-white">
                <i class="fas fa-user-edit mr-2"></i>
                {{ $isEdit ? 'Modifier l\'utilisateur' : 'Nouvel utilisateur' }}
            </h2>
        </div>

        <!-- Formulaire -->
        <form action="{{ $isEdit ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nom -->
                <div class="space-y-1">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nom complet <span class="text-red-500">*</span>
                    </label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name ?? '') }}"
                               required
                               class="form-input block w-full pl-10 sm:text-sm rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Jean Dupont">
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="space-y-1">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Adresse email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email ?? '') }}"
                               required
                               class="form-input block w-full pl-10 sm:text-sm rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                               placeholder="jean.dupont@exemple.com">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rôle -->
                <div class="space-y-1">
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Rôle <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="role" 
                                name="role" 
                                required
                                class="form-select block w-full pl-10 pr-10 py-2 text-base border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Sélectionner un rôle</option>
                            @foreach($roles as $role)
                                @php
                                    $roleValue = $role;
                                    // Gérer les alias de rôles
                                    if ($role === 'Médecin') $roleValue = 'Médecin';
                                    if ($role === 'Secrétaire') $roleValue = 'Secrétaire';
                                    $selected = ($selectedRole === $role) ? 'selected' : '';
                                @endphp
                                <option value="{{ $roleValue }}" {{ $selected }}>
                                    {{ $role }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="space-y-1">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ $isEdit ? 'Nouveau mot de passe' : 'Mot de passe' }}
                        <span class="text-gray-500 text-xs">{{ $isEdit ? '(Laissez vide pour ne pas modifier)' : '' }}</span>
                        @if(!$isEdit)<span class="text-red-500">*</span>@endif
                    </label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               {{ $passwordRequired }}
                               class="form-input block w-full pl-10 sm:text-sm rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                               placeholder="••••••••">
                        <button type="button" 
                                onclick="togglePasswordVisibility('password')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                title="Afficher/Masquer">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @else
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Minimum 8 caractères</p>
                    @enderror
                </div>

                <!-- Confirmation mot de passe -->
                <div class="space-y-1">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Confirmer le mot de passe
                        @if(!$isEdit)<span class="text-red-500">*</span>@endif
                    </label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               {{ $passwordRequired }}
                               class="form-input block w-full pl-10 sm:text-sm rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                               placeholder="••••••••">
                        <button type="button" 
                                onclick="togglePasswordVisibility('password_confirmation')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                title="Afficher/Masquer">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:bg-gray-600">
                    <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
                </a>
                <button type="submit" class="ml-3 inline-flex items-center justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-{{ $isEdit ? 'save' : 'plus' }} mr-2"></i>
                    {{ $isEdit ? 'Enregistrer les modifications' : 'Créer l\'utilisateur' }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Fonction pour basculer la visibilité du mot de passe
    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.nextElementSibling.querySelector('i');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Mise en couleur dynamique des rôles
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        
        function updateRoleColor() {
            const selectedOption = roleSelect.options[roleSelect.selectedIndex];
            const role = selectedOption.value.toLowerCase();
            
            // Supprimer les classes de couleur précédentes
            Array.from(roleSelect.classList).forEach(className => {
                if (className.startsWith('bg-') || className.startsWith('text-') || className.startsWith('border-')) {
                    roleSelect.classList.remove(className);
                }
            });
            
            // Ajouter les classes de base
            roleSelect.classList.add('border', 'border-gray-300', 'dark:border-gray-600');
            
            // Ajouter la couleur en fonction du rôle sélectionné
            if (role) {
                const colorMap = {
                    'admin': ['bg-purple-100', 'text-purple-800', 'dark:bg-purple-900', 'dark:text-purple-100', 'border-purple-300'],
                    'medecin': ['bg-blue-100', 'text-blue-800', 'dark:bg-blue-900', 'dark:text-blue-100', 'border-blue-300'],
                    'secretaire': ['bg-green-100', 'text-green-800', 'dark:bg-green-900', 'dark:text-green-100', 'border-green-300'],
                    'infirmier': ['bg-yellow-100', 'text-yellow-800', 'dark:bg-yellow-900', 'dark:text-yellow-100', 'border-yellow-300'],
                    'pharmacien': ['bg-indigo-100', 'text-indigo-800', 'dark:bg-indigo-900', 'dark:text-indigo-100', 'border-indigo-300'],
                    'caissier': ['bg-pink-100', 'text-pink-800', 'dark:bg-pink-900', 'dark:text-pink-100', 'border-pink-300']
                };
                
                const colors = colorMap[role] || [];
                colors.forEach(color => roleSelect.classList.add(color));
            }
        }
        
        // Mettre à jour la couleur au chargement et lors du changement
        updateRoleColor();
        roleSelect.addEventListener('change', updateRoleColor);
    });
</script>
@endpush
<div class="col-span-2 sm:col-span-1">
    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
    <div class="mt-1 relative rounded-md shadow-sm">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <input type="password" id="password_confirmation" name="password_confirmation" {{ $passwordRequired }}
               class="form-input block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
               placeholder="••••••••">
    </div>
</div>

@push('scripts')
<script>
    // Mise à jour visuelle du sélecteur de rôle
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        
        function updateRoleBadge() {
            const selectedOption = roleSelect.options[roleSelect.selectedIndex];
            const colorClass = selectedOption.getAttribute('data-class');
            
            // Mettre à jour la couleur du sélecteur
            roleSelect.className = `form-select block w-full pl-3 pr-10 py-2 text-base focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md ${colorClass} font-medium`;
        }
        
        // Initialiser
        updateRoleBadge();
        
        // Mettre à jour lors du changement
        roleSelect.addEventListener('change', updateRoleBadge);
    });
</script>
@endpush
