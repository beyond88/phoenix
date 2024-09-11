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
            // Call the media deletion service
            $result = $this->getMediaUploader()->deleteMedia($mediaId);

            // Check if deletion was successful
            if (isset($result['success']) && $result['success']) {
                // Remove the deleted media from the mediaItems array
                $this->mediaItems = array_filter($this->mediaItems, function($item) use ($mediaId) {
                    return $item['id'] != $mediaId;
                });

                // Flash success message
                session()->flash('success', $result['message']);
            } else {
                // Flash warning/error message
                session()->flash('error', $result['message']);
            }

            // Re-render the component to reflect changes in the UI
            $this->render();

        } catch (\Exception $e) {
            session()->flash('error', 'Deletion failed: ' . $e->getMessage());
        }
    }

    public function getFormattedDate($date) {
        return $this->getMediaUploader()->getFormattedDate($date);
    }



}
