@csrf
<div class="mb-3">
    <label for="name" class="form-label">Nom</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="role" class="form-label">Rôle</label>
    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
        @foreach($roles as $role)
            <option value="{{ $role }}" {{ isset($user) && $user->role == $role ? 'selected' : '' }}>{{ $role }}</option>
        @endforeach
    </select>
    @error('role')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="password" class="form-label">Mot de passe</label>
    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" {{ isset($user) ? '' : 'required' }}>
    @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" {{ isset($user) ? '' : 'required' }}>
</div>
<button type="submit" class="btn btn-primary">{{ isset($user) ? 'Mettre à jour' : 'Créer' }}</button>
<a href="{{ route('users.index') }}" class="btn btn-secondary">Annuler</a>
