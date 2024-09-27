<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Services\MessageService;
use Livewire\WithPagination;
use App\Services\PostService;
use Carbon\Carbon;

class Pages extends Component
{
    use WithPagination;

    /**
     * Array to hold pages items.
     *
     * @var array
     */
    public $pageItems = [];

    /**
     * Number of posts per page.
     *
     * @var int
     */
    public $perPage = 10;

    /**
     * Current page for post pagination.
     *
     * @var int
     */
    public $currentPage = 1;

    /**
     * Total number of post items.
     *
     * @var int
     */
    public $totalPageCount = 0;

    /**
     * Boolean flag indicating if more pages are available.
     *
     * @var bool
     */
    public $hasMorePages = true;

    /**
     * Total number of publish post items.
     *
     * @var int
     */
    public $publish = 0;

    /**
     * Total number of draft post items.
     *
     * @var int
     */
    public $draft = 0;

    /**
     * Search query for filtering posts.
     *
     * @var string
     */
    public string $search = '';

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
    public $selectedPages = [];

    /**
     * Selected bulk action.
     *
     * @var string
     */
    public $bulkAction = '';

    /**
     * Collection of months for filtering by date.
     *
     * @var mixed
     */
    public $months;

    /**
     * The name of the selected category.
     *
     * @var string
     */
    public $selectedDateName = 'All Dates'; // Default display text

    /**
     * The ID of the selected date.
     *
     * @var string
     */
    public $selectedDate = 'all'; // Default date for "All dates"

    /**
     * The ID of the selected category.
     *
     * @var string
     */
    public $pageStatus = 'all'; // Default status for "All pages"

    /**
     * Service for handling post-related operations.
     *
     * @var PostService
     */
    protected $postService;

    /**
     * Service for handling message-related operations.
     *
     * @var MessageService
     */
    protected $messageService;

    /**
     * Constructor method for the controller.
     * Initializes the services needed for handling posts, categories, and messages.
     *
     * @return void
     */
    public function __construct()
    {
        $this->postService = app(PostService::class);
        $this->messageService = app(MessageService::class);
        
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
            $this->selectedPages = collect($this->pageItems)->pluck('id')->toArray();
        } else {
            $this->selectedPages = [];
        }
    }
    
    /**
     * Updates the 'Select All' flag based on selected page.
     *
     * @return void
     */
    public function updatedSelectedPost()
    {
        $this->selectAll = count($this->selectedPages) === count($this->pageItems);
    }

    /**
     * Toggles the 'Select All' action.
     *
     * @return void
     */
    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedPages = collect($this->pageItems)->pluck('id')->toArray();
        } else {
            $this->selectedPages = [];
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

        if (empty($this->selectedPages)) {
            $this->messageService->message('error', 'No page selected for deletion.');
            return;
        }

        $this->processBulkDeletion();
        $this->handlePageDeletionState();
        $this->dispatch('pageDeleted');
        $this->bulkAction = '';
        $this->loadPages();
    }

    public function deletePageById($pageId){
        return $this->postService->delete($pageId);
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

        foreach ($this->selectedPages as $pageId) {
            $result = $this->deletePageById($pageId);

            if ($this->isDeletionSuccessful($result)) {
                $successCount++;
                $this->removePageFromList($pageId);
            } else {
                $failCount++;
            }
        }

        $this->flashDeletionMessages($successCount, $failCount);
        $this->selectedPages = [];
        $this->selectAll = false;
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
     * Initialize component and load initial data.
     */
    public function mount()
    {
        $this->loadMonths();
        $this->loadPages();
    }

    /**
     * Loads distinct months from the media records.
     *
     * @return void
     */
    public function loadMonths()
    {
        $this->months = $this->postService->loadMonths();
    }

    /**
     * Load the posts for the current page.
     *
     * @return void
     */
    public function loadPages(): void
    {
        $filters = [
            'perPage' => $this->perPage,
            'search' => $this->search,
            'selected_date' => $this->selectedDate,
            'post_status' => $this->pageStatus,
            'page' => $this->currentPage,
            'post_type' => 'page',
        ];

        $pageData = $this->postService->getAllPosts($filters);

        $this->pageItems = collect($pageData['posts'])->map(function ($page) {
            return [
                'id' => $page['id'],
                'post_title' => $page['post_title'],
                'post_content' => $page['post_content'],
                'post_status' => $page['post_status'],
                'media_id' => $page['media_id'],
                'media_name' => $page['media_name'],
                'user_id' => $page['user_id'],
                'created_at' => Carbon::parse($page['created_at'])->utc()->timestamp,
                'updated_at' => Carbon::parse($page['updated_at'])->utc()->timestamp
            ];
        })->toArray();

        $this->totalPageCount = $pageData['total'];
        $this->publish = $pageData['publish'];
        $this->draft = $pageData['draft'];

        $this->currentPage = (int)$pageData['current_page'];
        $this->lastPage = (int)$pageData['last_page'];
    }

    /**
     * Update the list when the search term changes.
     */
    public function updatedSearch()
    {
        $this->resetPage(); // Reset pagination when search changes
        $this->loadPages();
    }

    /**
     * Formats a timestamp into a human-readable date string.
     *
     * @param string $timestamp The timestamp to format (e.g., 'Y-m-d H:i:s').
     * @param string|null $timezone Optional timezone for formatting. Defaults to the application's timezone if null.
     * @return string Formatted date string in 'M d, h:i A' format.
     */
    public function formatDate($timestamp, $timezone = null)
    {
        if($timestamp == null){
            return;
        }
        return $this->postService->formatDate($timestamp, $timezone = null);
    }

    /**
     * Perform the media deletion operation.
     *
     * @param int $id
     * @return array
     */
    protected function performPageDeletion($id)
    {
        return $this->postService->delete($id);
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
     * @param int $id
     * @return void
     */
    protected function removePageFromList($id)
    {
        $this->pageItems = collect($this->pageItems)->filter(function($item) use ($id) {
            return $item['id'] != $id;
        })->toArray(); // Make sure to convert the collection back to an array
    }
    
    /**
     * Handle state updates and pagination after deletion.
     *
     * @return void
     */
    protected function handlePageDeletionState()
    {
        if (collect($this->pageItems)->isEmpty() && $this->currentPage > 1) {
            $this->currentPage--;
        }
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
            $this->messageService->message('success', "$successCount page(s) have been deleted successfully.");
        }
        if ($failCount > 0) {
            $this->messageService->message('error', "Failed to delete $failCount post(s).");
        }
    }

    /**
     * Deletes a page by its ID.
     *
     * This method checks if the provided ID is a valid integer and whether
     * a page with that ID exists before attempting to delete it.
     *
     * @param int $id The ID of the page to delete.
     * @return bool True if the page was deleted, false otherwise.
     */
    public function deletePage($id)
    {

        try {
            $result = $this->performPageDeletion($id);
            
            if ($this->isDeletionSuccessful($result)) {
                $this->removePageFromList($id);
                $this->messageService->message('success', $result['message']);
            } else {
                $this->messageService->message('error', $result['message']);
            }
    
            $this->render();
            
        } catch (\Exception $e) {
            $this->messageService->message('error', 'Deletion failed: ' . $e->getMessage());

        }
        
    }

    /**
     * Advances to the next page.
     *
     * @return void
     */
    public function nextPage()
    {
        if ($this->currentPage < ceil($this->totalPageCount / $this->perPage)) {
            $this->currentPage++;
            $this->loadPages();
        }
    }

    /**
     * Returns to the previous page.
     *
     * @return void
     */
    public function previousPage()
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
            $this->loadPages();
        }
    }

    /**
     * Navigates to a specified page.
     *
     * @param int $page The page number to navigate to.
     * @return void
     */
    public function gotoPage($page)
    {
        if ($page >= 1 && $page <= ceil($this->totalPageCount / $this->perPage)) {
            $this->currentPage = $page;
            $this->loadPages();
        }
    }

    /**
     * Performs a search query and reloads the post items.
     *
     * @return void
     */
    public function performSearch()
    {
        $this->page = 1;
        $this->loadPages();
    }

    /**
     * Selects a date and reloads the associated posts.
     *
     * @param string $name The name of the category to select.
     * @param int $id The ID of the category to select.
     * @return void
     */
    public function selectDate($name, $date)
    {
        $this->selectedDateName = $name;
        $this->selectedDate = $date;
        $this->loadPages();
    }

    public function getPostByStatus($status)
    {
        $this->pageStatus = $status;
        $this->loadPages();
    }

    public function render()
    {
        $this->loadMonths();
        return view('livewire.pages.pages',[
            'pages' => $this->pageItems,
            'total' => $this->totalPageCount,
            'page' => $this->currentPage,
            'lastPage' => ceil($this->totalPageCount / $this->perPage),
        ]);
    }
}
