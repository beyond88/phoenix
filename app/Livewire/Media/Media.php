<?php

namespace App\Livewire\Media;

use Livewire\Component;
use App\Services\MediaUploader;
use App\Models\Media as MediaModel;

class Media extends Component
{
    /**
     * The media uploader service instance.
     *
     * @var MediaUploader
     */
    protected $mediaUploader;

    public $mediaItems = [];
    public $page = 1;
    public $hasMorePages = true;
    public $selectedMedia;
    public $mode = 'list'; // Default mode

    protected function getMediaUploader(): MediaUploader
    {
        return app(MediaUploader::class);
    }

    public function getMediaPlaceholderIcon($mediaFileName)
    {
        return $this->getMediaUploader()->getMediaPlaceholderIcon($mediaFileName);
    }

    public function mount()
    {
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

    public function deleteMedia($mediaId)
    {
        try {
            $result = $this->getMediaUploader()->deleteMedia($mediaFileName);

            if ($result['success']) {
                session()->flash('message', 'Media deleted successfully!');
                session()->flash('type', 'success');
            } else {
                session()->flash('message', 'Media record deleted successfully, but the file was not found in storage.');
                session()->flash('type', 'warning');
            }
        } catch (\Exception $e) {
            session()->flash('message', 'Deletion failed: ' . $e->getMessage());
            session()->flash('type', 'error');
        }
    }
}
