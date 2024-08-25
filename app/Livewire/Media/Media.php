<?php

namespace App\Livewire\Media;

use Livewire\Component;
use App\Models\Media as MediaModel;

class Media extends Component
{
    public $mediaItems = [];
    public $page = 1;
    public $hasMorePages = true;

    public function mount()
    {
        $this->loadMore();
    }

    public function loadMore()
    {
        if (!$this->hasMorePages) {
            return;
        }

        $media = MediaModel::select('id', 'media_name', 'created_at', 'updated_at')
                           ->paginate(24, ['*'], 'page', $this->page);

        $this->mediaItems = array_merge($this->mediaItems, $media->items());
        $this->hasMorePages = $media->hasMorePages();
        $this->page++;
    }

    public function render()
    {
        return view('livewire.media.media');
    }
}