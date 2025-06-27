@php
    $isEdit = isset($user);
    $passwordRequired = !$isEdit ? 'required' : '';
    $passwordHelper = $isEdit ? ' (Laissez vide pour ne pas changer)' : '';
    
    $roleColors = [
        'Admin' => 'bg-purple-100 text-purple-800',
        'Medecin' => 'bg-blue-100 text-blue-800',
        'Secretaire' => 'bg-green-100 text-green-800',
        'Infirmier' => 'bg-yellow-100 text-yellow-800',
        'Pharmacien' => 'bg-indigo-100 text-indigo-800',
        'Caissier' => 'bg-pink-100 text-pink-800',
        'default' => 'bg-gray-100 text-gray-800'
    ];
@endphp

<!-- Nom -->
<div class="col-span-2 sm:col-span-1">
    <label for="name" class="form-label">Nom complet</label>
    <div class="mt-1 relative rounded-md shadow-sm">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
        </div>
        <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required
               class="form-input block w-full pl-10 sm:text-sm border-gray-300 rounded-md @error('name') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
               placeholder="Jean Dupont">
    </div>
    @error('name')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<!-- Email -->
<div class="col-span-2 sm:col-span-1">
    <label for="email" class="form-label">Adresse email</label>
    <div class="mt-1 relative rounded-md shadow-sm">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
        </div>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
               class="form-input block w-full pl-10 sm:text-sm border-gray-300 rounded-md @error('email') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
               placeholder="jean.dupont@exemple.com">
    </div>
    @error('email')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<!-- Rôle -->
<div class="col-span-2 sm:col-span-1">
    <label for="role" class="form-label">Rôle</label>
    <div class="mt-1 relative">
        <select id="role" name="role" required
                class="form-select block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md @error('role') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
            @foreach($roles as $role)
                @php
                    $color = $roleColors[$role] ?? $roleColors['default'];
                    $selected = old('role', $user->role ?? '') == $role ? 'selected' : '';
                @endphp
                <option value="{{ $role }}" {{ $selected }} data-class="{{ $color }}">
                    {{ $role }}
                </option>
            @endforeach
        </select>
        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>
    @error('role')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<!-- Mot de passe -->
<div class="col-span-2 sm:col-span-1">
    <label for="password" class="form-label">Mot de passe {{ $passwordHelper }}</label>
    <div class="mt-1 relative rounded-md shadow-sm">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        <input type="password" id="password" name="password" {{ $passwordRequired }}
               class="form-input block w-full pl-10 sm:text-sm border-gray-300 rounded-md @error('password') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
               placeholder="••••••••">
    </div>
    @error('password')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @else
        <p class="mt-1 text-xs text-gray-500">Minimum 8 caractères</p>
    @enderror
</div>

<!-- Confirmation mot de passe -->
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
