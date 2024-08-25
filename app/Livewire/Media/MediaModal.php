<?php

namespace App\Livewire\Media;

use Livewire\Component;
use App\Models\Media as MediaModel;

class MediaModal extends Component
{
    public $mediaItems = [];
    public $hasMorePages = true;
    public $page = 1;

    public function loadMore()
    {
        $media = MediaModel::select('id', 'media_name', 'created_at', 'updated_at')
                           ->paginate(12, ['*'], 'page', $this->page);

        $this->mediaItems = array_merge($this->mediaItems, $media->items());
        $this->hasMorePages = $media->hasMorePages();
        $this->page++;
    }

    public function render()
    {
        return view('livewire.media.media-modal');
    }

    public function mount()
    {
        $this->loadMore();
    }
}
