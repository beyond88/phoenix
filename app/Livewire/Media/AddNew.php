<?php

namespace App\Livewire\Media;

use Livewire\Component;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class AddNew extends Component
{
    use WithFileUploads;

    public $file;

    public function updatedFile()
    {
        $this->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);
    }

    public function upload()
    {
        $this->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $path = $this->file->store('uploads', 'public');

        session()->flash('message', 'File uploaded successfully.');
    }

    public function render()
    {
        return view('livewire.media.add-new');
    }
}
