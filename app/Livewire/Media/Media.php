<?php
namespace App\Livewire\Media;

use Livewire\Component;
use App\Services\MediaUploader;
use App\Models\Media as MediaModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Media extends Component
{
    /**
     * The media uploader service instance.
     *
     * @var MediaUploader
     */
    protected $mediaUploader;

    /**
     * Array to hold media items.
     *
     * @var array
     */
    public $mediaItems = [];

    /**
     * Current page for media pagination.
     *
     * @var int
     */
    public $page = 1;

    /**
     * Number of media items per page.
     *
     * @var int
     */
    public $perPage = 20;

    /**
     * Total number of media items.
     *
     * @var int
     */
    public $totalMediaCount = 0;

    /**
     * Boolean flag indicating if more pages are available.
     *
     * @var bool
     */
    public $hasMorePages = true;

    /**
     * Holds the details of the selected media for the popup.
     *
     * @var mixed
     */
    public $popupMedia;

    /**
     * The view mode (list or grid).
     *
     * @var string
     */
    public $mode = 'list';

    /**
     * Flag to select or deselect all media items.
     *
     * @var bool
     */
    public $selectAll = false;

    /**
     * Array of selected media IDs.
     *
     * @var array
     */
    public $selectedMedia = [];

    /**
     * The selected bulk action.
     *
     * @var string
     */
    public $bulkAction = '';

    /**
     * Search query for filtering media.
     *
     * @var string
     */
    public string $search = '';

    /**
     * Field to sort the media items by.
     *
     * @var string
     */
    public $sortField = 'media_name';

    /**
     * Sort direction for media items (asc or desc).
     *
     * @var string
     */
    public $sortDirection = 'desc';

     /**
     * Collection of months for filtering by date.
     *
     * @var mixed
     */
    public $months;

    /**
     * Count of distinct months.
     *
     * @var int
     */
    public $monthCount;

    /**
     * The selected date filter.
     *
     * @var string
     */
    public $selectedDate = 'all';

    /**
     * Returns the media uploader service instance.
     *
     * @return MediaUploader
     */
    protected function getMediaUploader(): MediaUploader
    {
        return app(MediaUploader::class);
    }

    /**
     * Retrieves the media placeholder icon based on the file name.
     *
     * @param string $mediaFileName
     * @return string
     */
    public function getMediaPlaceholderIcon($mediaFileName)
    {
        return $this->getMediaUploader()->getMediaPlaceholderIcon($mediaFileName);
    }

    /**
     * Deletes a media item by ID.
     *
     * @param int $mediaId
     * @return void
     */
    public function deleteMedia($mediaId)
    {
        try {
            $result = $this->performMediaDeletion($mediaId);
            
            if ($this->isDeletionSuccessful($result)) {
                $this->removeMediaFromList($mediaId);
                $this->flashSuccessMessage($result['message']);
            } else {
                $this->flashErrorMessage($result['message']);
            }
    
            $this->updateTotalMediaCount();
            $this->render();
            
        } catch (\Exception $e) {
            $this->handleDeletionException($e);
        }
    }
    
    /**
     * Perform the media deletion operation.
     *
     * @param int $mediaId
     * @return array
     */
    protected function performMediaDeletion($mediaId)
    {
        return $this->getMediaUploader()->deleteMedia($mediaId);
    }
    
    /**
     * Check if the deletion was successful.
     *
     * @param array $result
     * @return bool
     */
    protected function isDeletionSuccessful($result)
    {
        return isset($result['success']) && $result['success'];
    }
    
    /**
     * Remove the media item from the list.
     *
     * @param int $mediaId
     * @return void
     */
    protected function removeMediaFromList($mediaId)
    {
        $this->mediaItems = collect($this->mediaItems)->filter(function($item) use ($mediaId) {
            return $item->id != $mediaId;
        });
    }
    
    /**
     * Flash a success message to the session.
     *
     * @param string $message
     * @return void
     */
    protected function flashSuccessMessage($message)
    {
        session()->flash('success', $message);
    }
    
    /**
     * Flash an error message to the session.
     *
     * @param string $message
     * @return void
     */
    protected function flashErrorMessage($message)
    {
        session()->flash('error', $message);
    }
    
    /**
     * Handle exceptions thrown during media deletion.
     *
     * @param \Exception $e
     * @return void
     */
    protected function handleDeletionException(\Exception $e)
    {
        session()->flash('error', 'Deletion failed: ' . $e->getMessage());
    }    

    /**
     * Formats the given date.
     *
     * @param string $date
     * @return string
     */
    public function getFormattedDate($date) {
        return $this->getMediaUploader()->getFormattedDate($date);
    }

    /**
     * Loads distinct months from the media records.
     *
     * @return void
     */
    public function loadMonths()
    {
        $this->months = MediaModel::select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month'))
        ->whereNotNull('media_name')
        ->distinct()
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();

        $this->monthCount = $this->months->count();
    }

    /**
     * Loads the media items for the current page.
     *
     * @return void
     */
    public function loadMedia(): void
    {
        $this->mediaItems = collect();
        $this->page = 1;
        $this->hasMorePages = true;
        $this->loadMore();
    }

    /**
     * Loads more media items if available.
     *
     * @return void
     */
    public function loadMore()
    {
        if (!$this->hasMorePages) {
            return;
        }

        try {
            $mediaQuery = $this->buildMediaQuery();
            $this->totalMediaCount = $this->getTotalMediaCount($mediaQuery);
            
            $media = $this->getPagedMedia($mediaQuery);
            
            $this->updateMediaItems($media->items());
            $this->updatePaginationState($media);
        } catch (\Exception $e) {
            // Log the exception details for debugging
            \Log::error('Failed to load more media: ' . $e->getMessage(), [
                'exception' => $e,
                'search' => $this->search,
                'selectedDate' => $this->selectedDate,
                'page' => $this->page,
                'sortField' => $this->sortField,
                'sortDirection' => $this->sortDirection,
            ]);
        
            // Flash an error message to the session for user feedback
            session()->flash('error', 'Failed to load more media. Please try again later.');
        }
        
    }

    /**
     * Build the media query based on search and date filters.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildMediaQuery()
    {
        $mediaQuery = MediaModel::query();

        if ($this->search) {
            $mediaQuery->where('media_name', 'like', '%' . $this->search . '%');
        }
        
        if ($this->selectedDate !== 'all') {
            $year = substr($this->selectedDate, 0, 4);
            $month = substr($this->selectedDate, 4, 2);
            $mediaQuery->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month);
        }

        return $mediaQuery;
    }

    /**
     * Get the total count of media based on the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $mediaQuery
     * @return int
     */
    protected function getTotalMediaCount($mediaQuery)
    {
        return $mediaQuery->count();
    }

    /**
     * Retrieve the paginated media items.
     *
     * @param \Illuminate\Database\Eloquent\Builder $mediaQuery
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function getPagedMedia($mediaQuery)
    {
        return $mediaQuery->select('id', 'media_name', 'created_at', 'updated_at')
                        ->orderBy($this->sortField, $this->sortDirection)
                        ->paginate($this->perPage, ['*'], 'page', $this->page);
    }

    /**
     * Update the media items collection.
     *
     * @param \Illuminate\Support\Collection $mediaItems
     * @return void
     */
    protected function updateMediaItems($mediaItems)
    {
        $this->mediaItems = $this->mediaItems->merge($mediaItems);
    }

    /**
     * Update pagination state based on the paginated media.
     *
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator $media
     * @return void
     */
    protected function updatePaginationState($media)
    {
        $this->hasMorePages = $media->hasMorePages();
        $this->page++;
    }

    /**
     * Loads the details of the selected media item.
     *
     * @param int $mediaId
     * @return void
     */
    public function loadMediaDetails($mediaId)
    {
        $this->popupMedia = MediaModel::find($mediaId);
    }

    /**
     * Performs a search query and reloads the media items.
     *
     * @return void
     */
    public function performSearch()
    {
        $this->page = 1;
        $this->loadMedia();
    }

    /**
     * Updates the selection when 'Select All' is toggled.
     *
     * @param bool $value
     * @return void
     */
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedMedia = $this->mediaItems->pluck('id')->toArray();
        } else {
            $this->selectedMedia = [];
        }
    }

    /**
     * Updates the 'Select All' flag based on selected media.
     *
     * @return void
     */
    public function updatedSelectedMedia()
    {
        $this->selectAll = count($this->selectedMedia) === count($this->mediaItems);
    }

    /**
     * Toggles the 'Select All' action.
     *
     * @return void
     */
    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedMedia = $this->mediaItems->pluck('id')->toArray();
        } else {
            $this->selectedMedia = [];
        }
    }

    /**
     * Applies the selected bulk action to the media items.
     *
     * @return void
     */
    public function applyBulkAction()
    {
        if ($this->bulkAction !== 'delete') {
            return;
        }

        if (empty($this->selectedMedia)) {
            session()->flash('error', 'No media selected for deletion.');
            return;
        }

        $this->processBulkDeletion();
        $this->handlePostDeletionState();
        $this->dispatch('mediaDeleted');
        $this->updateTotalMediaCount();
        $this->bulkAction = '';
    }

    /**
     * Process the bulk deletion of media items.
     *
     * @return void
     */
    protected function processBulkDeletion()
    {
        $successCount = 0;
        $failCount = 0;

        foreach ($this->selectedMedia as $mediaId) {
            $result = $this->deleteMediaById($mediaId);

            if ($this->isDeletionSuccessful($result)) {
                $successCount++;
                $this->removeMediaFromList($mediaId);
            } else {
                $failCount++;
            }
        }

        $this->flashDeletionMessages($successCount, $failCount);
        $this->selectedMedia = [];
        $this->selectAll = false;
    }

    /**
     * Delete a single media item by ID.
     *
     * @param int $mediaId
     * @return array
     */
    protected function deleteMediaById($mediaId)
    {
        return $this->getMediaUploader()->deleteMedia($mediaId);
    }

    /**
     * Flash success and error messages based on the deletion result.
     *
     * @param int $successCount
     * @param int $failCount
     * @return void
     */
    protected function flashDeletionMessages($successCount, $failCount)
    {
        if ($successCount > 0) {
            session()->flash('success', "$successCount media file(s) have been deleted successfully.");
        }
        if ($failCount > 0) {
            session()->flash('error', "Failed to delete $failCount media file(s).");
        }
    }

    /**
     * Handle state updates and pagination after deletion.
     *
     * @return void
     */
    protected function handlePostDeletionState()
    {
        if (collect($this->mediaItems)->isEmpty() && $this->page > 1) {
            $this->page--;
            $this->loadMore();
        }
    }

    /**
     * Updates the total media count.
     *
     * @return void
     */
    protected function updateTotalMediaCount(): void
    {
        $this->totalMediaCount = MediaModel::count();
    }

    /**
     * Sets the view mode (list or grid).
     *
     * @param string $mode
     * @return void
     */
    public function sortBy($field)
    {
        $this->sortDirection = $this->determineSortDirection($field);
        $this->sortField = $field;
        
        $this->loadMedia();
    }
    
    /**
     * Determine the sort direction based on the current field.
     *
     * @param string $field
     * @return string
     */
    private function determineSortDirection($field)
    {
        return $this->sortField === $field && $this->sortDirection === 'desc' ? 'asc' : 'desc';
    }
    
    /**
     * Pads a number with leading zeros up to the specified threshold.
     *
     * @param int $number The number to be padded.
     * @param int $threshold The total length after padding.
     * @return string The padded number as a string.
     */
    public function zeroise($number, $threshold)
    {
        return sprintf('%0' . $threshold . 's', $number);
    }

    /**
     * Trigger media reload when the selected date is updated.
     *
     * @param string $value The new selected date.
     */
    public function updatedSelectedDate($value)
    {
        $this->loadMedia();
    }

    /**
     * Filter media items based on the selected date.
     */
    public function filterByDate()
    {
        $this->loadMedia();
    }

    /**
     * Initialize component and load initial data.
     */
    public function mount()
    {
        $this->mode = request()->query('mode', 'list');
        $this->selectedDate = 'all';
        $this->loadMonths();
        $this->loadMedia();
    }

    /**
     * Render the media component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.media.media', [
            'mediaItems' => $this->mediaItems,
            'mode' => $this->mode,
            'months' => $this->months,
            'isEmptyResult' => $this->mediaItems->isEmpty() && $this->totalMediaCount === 0,
            'selectedDate' => $this->selectedDate,
        ]);
    }

}