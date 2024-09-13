<?php

namespace App\Livewire\Media;

use Livewire\Component;
use App\Services\MediaUploader;
use App\Models\Media as MediaModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

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
    public $perPage = 5;
    public $totalMediaCount = 0;
    public $hasMorePages = true;
    public $popupMedia;
    public $mode = 'list'; // Default mode
    public $selectAll = false;
    public $selectedMedia = [];
    public $bulkAction = ''; // Holds the selected action from the dropdown
    public string $search = '';

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
        $this->loadMedia();
    }

    public function loadMedia(): void
    {
        $this->mediaItems = collect();
        $this->page = 1;
        $this->hasMorePages = true;
        $this->loadMore();
    }

    public function loadMore()
    {
        if (!$this->hasMorePages) {
            return;
        }

        $mediaQuery = MediaModel::query();

        if ($this->search) {
            $mediaQuery->where('media_name', 'like', '%' . $this->search . '%');
        }

        
        $media = $mediaQuery->select('id', 'media_name', 'created_at', 'updated_at')
        ->orderBy('created_at', 'desc')
        ->paginate($this->perPage, ['*'], 'page', $this->page);
        
        // $this->mediaItems = array_merge($this->mediaItems, $media->items());
        $this->totalMediaCount = $mediaQuery->count();
        $this->mediaItems = $this->mediaItems->merge($media->items());
        $this->hasMorePages = $media->hasMorePages();
        $this->page++;
    }

    public function loadMediaDetails($mediaId)
    {
        $this->popupMedia = MediaModel::find($mediaId);
    }

    public function updatedSearch()
    {
        $this->loadMedia();
    }

    public function render()
    {
        logger($this->mediaItems);
        return view('livewire.media.media', [
            'mediaItems' => $this->mediaItems,
            'mode' => $this->mode,
            'isEmptyResult' => $this->mediaItems->isEmpty() && $this->totalMediaCount === 0,
        ]);
    }

    public function deleteMedia($mediaId)
    {
        try {

            $result = $this->getMediaUploader()->deleteMedia($mediaId);

            if (isset($result['success']) && $result['success']) {
                $this->mediaItems = collect($this->mediaItems)->filter(function($item) use ($mediaId) {
                    return $item->id != $mediaId;
                });

                session()->flash('success', $result['message']);
            } else {
                session()->flash('error', $result['message']);
            }

            $this->updateTotalMediaCount();
            $this->render();

        } catch (\Exception $e) {
            session()->flash('error', 'Deletion failed: ' . $e->getMessage());
        }
    }

    public function getFormattedDate($date) {
        return $this->getMediaUploader()->getFormattedDate($date);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            // Select all media items when selectAll is true
            $this->selectedMedia = $this->mediaItems->pluck('id')->toArray();
        } else {
            // Deselect all media items when selectAll is false
            $this->selectedMedia = [];
        }
    }

    public function updatedSelectedMedia()
    {
        $this->selectAll = count($this->selectedMedia) === count($this->mediaItems);
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedMedia = $this->mediaItems->pluck('id')->toArray();
        } else {
            $this->selectedMedia = [];
        }
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


            $this->dispatch('mediaDeleted');
        }

        $this->updateTotalMediaCount();
        $this->bulkAction = '';
    }

    protected function updateTotalMediaCount(): void
    {
        $this->totalMediaCount = MediaModel::count();
    }

}