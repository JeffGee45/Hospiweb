<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class FileUploader extends Component
{
    use WithFileUploads;

    public $file;
    public $path;
    public $url;
    public $directory;
    public $originalName;
    public $isUploaded = false;

    protected $rules = [
        'file' => 'required|file|max:10240', // 10MB max
    ];

    public function mount($directory = 'uploads')
    {
        $this->directory = $directory;
    }

    public function updatedFile()
    {
        $this->validate();
        
        try {
            $this->originalName = $this->file->getClientOriginalName();
            $filename = uniqid() . '_' . time() . '.' . $this->file->getClientOriginalExtension();
            
            $this->path = $this->file->storeAs(
                $this->directory, $filename, 'public'
            );
            
            $this->url = Storage::url($this->path);
            $this->isUploaded = true;
            
            $this->emit('fileUploaded', [
                'path' => $this->path,
                'url' => $this->url,
                'original_name' => $this->originalName,
            ]);
            
        } catch (\Exception $e) {
            $this->addError('file', 'Erreur lors du téléchargement du fichier: ' . $e->getMessage());
        }
    }

    public function removeFile()
    {
        if ($this->path && Storage::disk('public')->exists($this->path)) {
            Storage::disk('public')->delete($this->path);
        }
        
        $this->reset(['file', 'path', 'url', 'originalName', 'isUploaded']);
        $this->emit('fileRemoved');
    }

    public function render()
    {
        return view('livewire.file-uploader');
    }
}
