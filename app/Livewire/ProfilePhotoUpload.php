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
    public $previewImage;
    public $editable = false;

    protected $listeners = ['photoUpdated' => '$refresh'];

    public function mount($user, $editable = false)
    {
        $this->user = $user;
        $this->editable = $editable;
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'required|image|max:2048|dimensions:min_width=100,min_height=100',
        ], [
            'photo.dimensions' => 'La photo doit faire au moins 100x100 pixels',
            'photo.max' => 'La photo ne doit pas dépasser 2 Mo',
            'photo.image' => 'Le fichier doit être une image valide',
        ]);
        
        // Créer un aperçu de l'image
        $this->previewImage = $this->photo->temporaryUrl();

        $this->isUploading = true;
        $this->uploadProgress = 10;
        $this->dispatch('uploadProgress', progress: $this->uploadProgress);
        
        try {
            // Supprimer l'ancienne photo si elle existe
            if ($this->user->photo && Storage::disk('public')->exists($this->user->photo)) {
                Storage::disk('public')->delete($this->user->photo);
            }
            
            $this->uploadProgress = 50;
            $this->dispatch('uploadProgress', progress: $this->uploadProgress);
            
            // Enregistrer la nouvelle photo
            $path = $this->photo->store('profile-photos', 'public');
            
            // Mettre à jour la photo de l'utilisateur
            $this->user->update(['photo' => $path]);
            
            $this->uploadProgress = 100;
            $this->dispatch('uploadComplete');
            
            session()->flash('message', 'Photo de profil mise à jour avec succès !');
        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue lors du téléchargement de la photo.');
        }
        
        $this->isUploading = false;
        $this->dispatch('photoUpdated');
        $this->reset('photo');
    }

    public function removePhoto()
    {
        try {
            if ($this->user->photo) {
                if (Storage::disk('public')->exists($this->user->photo)) {
                    Storage::disk('public')->delete($this->user->photo);
                }
                $this->user->update(['photo' => null]);
                $this->reset('previewImage');
                session()->flash('message', 'Photo de profil supprimée avec succès !');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue lors de la suppression de la photo.');
        }
        
        $this->dispatch('photoUpdated');
    }
    
    public function resetPreview()
    {
        $this->reset('previewImage', 'photo');
    }

    public function render()
    {
        return view('livewire.profile-photo-upload', [
            'user' => $this->user->fresh()
        ]);
    }
}
