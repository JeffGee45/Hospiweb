<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfilePhotoUpload extends Component
{
    use WithFileUploads;

    public $photo;
    public $user;
    public $isUploading = false;
    public $uploadProgress = 0;
    public $tempUrl;

    protected $listeners = ['photoUpdated' => '$refresh'];

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'required|image|max:2048', // 2MB Max
        ]);

        $this->isUploading = true;
        $this->uploadProgress = 33;

        // Simuler une progression (à remplacer par une véritable logique de téléchargement)
        $this->dispatch('uploadProgress', progress: $this->uploadProgress);
        
        // Enregistrer la photo
        $path = $this->photo->store('profile-photos', 'public');
        
        // Mettre à jour la photo de l'utilisateur
        $this->user->update([
            'photo' => $path
        ]);

        $this->uploadProgress = 100;
        $this->isUploading = false;
        $this->dispatch('uploadComplete');
        $this->dispatch('photoUpdated');
        
        session()->flash('message', 'Photo de profil mise à jour avec succès!');
    }

    public function removePhoto()
    {
        if ($this->user->photo && Storage::disk('public')->exists($this->user->photo)) {
            Storage::disk('public')->delete($this->user->photo);
        }

        $this->user->update(['photo' => null]);
        $this->dispatch('photoUpdated');
        
        session()->flash('message', 'Photo de profil supprimée avec succès!');
    }

    public function render()
    {
        return view('livewire.profile-photo-upload', [
            'user' => $this->user
        ]);
    }
}
