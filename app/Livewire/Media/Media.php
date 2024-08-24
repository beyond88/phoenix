<?php

namespace App\Livewire\Media;

use Livewire\Component;
use App\Models\Media as MediaModel;

class Media extends Component
{
    public $mediaItems;

    public function render()
    {
        $this->mediaItems = MediaModel::select('id', 'media_name', 'created_at', 'updated_at')->get();
        return view('livewire.media.media');
    }
}
