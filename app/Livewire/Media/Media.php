<?php

namespace App\Livewire\Media;

use Livewire\Component;
use App\Models\Media as MediaModel;

class Media extends Component
{
    public $mediaItems = [];
    public $page = 1;
    public $hasMorePages = true;
    public $selectedMedia;
    public $mode = 'list'; // Default mode

    public function mount()
    {
        // Get the 'mode' query parameter from the URL, default to 'list' if not set
        $this->mode = request()->query('mode', 'list');
        
        $this->loadMore();
    }

    public function loadMore()
    {
        if (!$this->hasMorePages) {
            return;
        }

        $media = MediaModel::select('id', 'media_name', 'created_at', 'updated_at')
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(24, ['*'], 'page', $this->page);

        $this->mediaItems = array_merge($this->mediaItems, $media->items());
        $this->hasMorePages = $media->hasMorePages();
        $this->page++;
    }

    public function loadMediaDetails($mediaId)
    {
        $this->selectedMedia = MediaModel::find($mediaId);
    }

    public function render()
    {
        return view('livewire.media.media', [
            'mediaItems' => $this->mediaItems,
            'mode' => $this->mode, // Pass the mode to the view
        ]);
    }
}
