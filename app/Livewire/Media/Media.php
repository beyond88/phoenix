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
    public $perPage = 200;
    public $totalMediaCount = 0;
    public $hasMorePages = true;
    public $popupMedia;
    public $mode = 'list'; // Default mode
    public $selectAll = false;
    public $selectedMedia = [];
    public $bulkAction = ''; // Holds the selected action from the dropdown

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

        $mediaQuery = MediaModel::query();
        $this->totalMediaCount = $mediaQuery->count();

        $media = $mediaQuery->select('id', 'media_name', 'created_at', 'updated_at')
                                        ->orderBy('created_at', 'desc')
                                        ->paginate($this->perPage, ['*'], 'page', $this->page);

        $this->mediaItems = array_merge($this->mediaItems, $media->items());
        $this->hasMorePages = $media->hasMorePages();
        $this->page++;
    }

    public function loadMediaDetails($mediaId)
    {
        $this->popupMedia = MediaModel::find($mediaId);
    }

    public function render()
    {
        return view('livewire.media.media', [
            'mediaItems' => $this->mediaItems,
            'mode' => $this->mode,
        ]);
    }

    public function deleteMedia($mediaId)
    {
        try {

            $result = $this->getMediaUploader()->deleteMedia($mediaId);

            if (isset($result['success']) && $result['success']) {
                $this->mediaItems = array_filter($this->mediaItems, function($item) use ($mediaId) {
                    return $item['id'] != $mediaId;
                });

                session()->flash('success', $result['message']);
            } else {
                session()->flash('error', $result['message']);
            }

            //$this->render();

        } catch (\Exception $e) {
            session()->flash('error', 'Deletion failed: ' . $e->getMessage());
        }
    }

    public function getFormattedDate($date) {
        return $this->getMediaUploader()->getFormattedDate($date);
    }

    public function updatedSelectedMedia()
    {
        $this->selectAll = count($this->selectedMedia) === count($this->mediaItems);
    }

    public function applyBulkAction()
    {
        if ($this->bulkAction === 'delete') {
            if (!empty($this->selectedMedia)) {
                $successCount = 0;
                $failCount = 0;

                foreach ($this->selectedMedia as $mediaId) {
                    $result = $this->getMediaUploader()->deleteMedia($mediaId);

                    if (isset($result['success']) && $result['success']) {
                        $successCount++;
                        $this->mediaItems = collect($this->mediaItems)->filter(function($item) use ($mediaId) {
                            return $item->id != $mediaId;
                        });
                    } else {
                        $failCount++;
                    }
                }

                $this->selectedMedia = [];
                $this->selectAll = false;

                if ($successCount > 0) {
                    session()->flash('success', "$successCount media file(s) have been deleted successfully.");
                }
                if ($failCount > 0) {
                    session()->flash('error', "Failed to delete $failCount media file(s).");
                }
            } else {
                session()->flash('error', 'No media selected for deletion.');
            }

            if (collect($this->mediaItems)->isEmpty() && $this->page > 1) {
                $this->page--;
                $this->loadMore();
            }

            // Use dispatch instead of emit
            $this->dispatch('mediaDeleted');
        }

        $this->bulkAction = '';
    }

}