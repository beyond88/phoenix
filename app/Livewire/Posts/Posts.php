<?php

namespace App\Livewire\Posts;

use App\Services\MessageService;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\PostService;
use App\Services\categoryService;
use App\Models\PostCategory;
use Carbon\Carbon;

class Posts extends Component
{
    use WithPagination;

     /**
     * Array to hold category items.
     *
     * @var array
     */
    public $cats;

    /**
     * Array to hold post items.
     *
     * @var array
     */
    public $postItems = [];

    /**
     * Number of posts per page.
     *
     * @var int
     */
    public $perPage = 3;

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
    public $totalPostCount = 0;

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
    public $selectedPosts = [];

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
    public $selectedCategoryName = 'Category'; // Default display text

    /**
     * The ID of the selected category.
     *
     * @var int
     */
    public $selectedCategoryId = 0; // Default ID for "All Categories"

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
    public $postStatus = 'all'; // Default status for "All posts"

    /**
     * Service for handling post-related operations.
     *
     * @var PostService
     */
    protected $postService;

    /**
     * Service for handling category-related operations.
     *
     * @var CategoryService
     */
    protected $categoryService;

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
        $this->categoryService = app(categoryService::class);
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
            $this->selectedPosts = collect($this->postItems)->pluck('id')->toArray();
        } else {
            $this->selectedPosts = [];
        }
    }    

    /**
     * Updates the 'Select All' flag based on selected media.
     *
     * @return void
     */
    public function updatedSelectedPost()
    {
        $this->selectAll = count($this->selectedPosts) === count($this->postItems);
    }

    /**
     * Toggles the 'Select All' action.
     *
     * @return void
     */
    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedPosts = collect($this->postItems)->pluck('id')->toArray();
        } else {
            $this->selectedPosts = [];
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

        if (empty($this->selectedPosts)) {
            $this->messageService->message('error', 'No post selected for deletion.');
            return;
        }

        $this->processBulkDeletion();
        $this->handlePostDeletionState();
        $this->dispatch('postDeleted');
        $this->bulkAction = '';
    }

    public function deletePostById($postId){
        return $this->postService->delete($postId);
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

        foreach ($this->selectedPosts as $postId) {
            $result = $this->deletePostById($postId);

            if ($this->isDeletionSuccessful($result)) {
                $successCount++;
                $this->removePostFromList($postId);
            } else {
                $failCount++;
            }
        }

        $this->flashDeletionMessages($successCount, $failCount);
        $this->selectedPosts = [];
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
        $this->loadCategories();
        $this->loadPosts();
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
     * Load all categories and assign them to the $cats property.
     *
     * @return void
     */
    public function loadCategories()
    {
        $this->cats = $this->categoryService->getAllCategories();
    }

    /**
     * Load the posts for the current page.
     *
     * @return void
     */
    public function loadPosts(): void
    {
        $filters = [
            'perPage' => $this->perPage,
            'search' => $this->search,
            'category_id' => $this->selectedCategoryId,
            'selected_date' => $this->selectedDate,
            'post_status' => $this->postStatus,
            'page' => $this->currentPage,
        ];

        $postsData = $this->postService->getAllPosts($filters);

        $this->postItems = collect($postsData['posts'])->map(function ($post) {
            return [
                'id' => $post['id'],
                'post_title' => $post['post_title'],
                'post_content' => $post['post_content'],
                'post_status' => $post['post_status'],
                'category_id' => $post['category_id'],
                'category_name' => $post['category_name'],
                'media_id' => $post['media_id'],
                'media_name' => $post['media_name'],
                'user_id' => $post['user_id'],
                'created_at' => Carbon::parse($post['created_at'])->utc()->timestamp,
                'updated_at' => Carbon::parse($post['updated_at'])->utc()->timestamp
            ];
        })->toArray();

        $this->totalPostCount = $postsData['total'];
        $this->publish = $postsData['publish'];
        $this->draft = $postsData['draft'];

        $this->currentPage = (int)$postsData['current_page'];
        $this->lastPage = (int)$postsData['last_page'];
    }

    /**
     * Update the list when the search term changes.
     */
    public function updatedSearch()
    {
        $this->resetPage(); // Reset pagination when search changes
        $this->loadPosts();
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
    protected function performPostDeletion($id)
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
    protected function removePostFromList($id)
    {
        $this->postItems = collect($this->postItems)->filter(function($item) use ($id) {
            return $item['id'] != $id;
        })->toArray(); // Make sure to convert the collection back to an array
    }
    
    /**
     * Handle state updates and pagination after deletion.
     *
     * @return void
     */
    protected function handlePostDeletionState()
    {
        if (collect($this->postItems)->isEmpty() && $this->currentPage > 1) {
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
            $this->messageService->message('success', "$successCount post(s) have been deleted successfully.");
        }
        if ($failCount > 0) {
            $this->messageService->message('error', "Failed to delete $failCount post(s).");
        }
    }

    /**
     * Deletes a post by its ID.
     *
     * This method checks if the provided ID is a valid integer and whether
     * a post with that ID exists before attempting to delete it.
     *
     * @param int $id The ID of the post to delete.
     * @return bool True if the post was deleted, false otherwise.
     */
    public function deletePost($id)
    {

        try {
            $result = $this->performPostDeletion($id);
            
            if ($this->isDeletionSuccessful($result)) {
                $this->removePostFromList($id);
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
        if ($this->currentPage < ceil($this->totalPostCount / $this->perPage)) {
            $this->currentPage++;
            $this->loadPosts();
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
            $this->loadPosts();
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
        if ($page >= 1 && $page <= ceil($this->totalPostCount / $this->perPage)) {
            $this->currentPage = $page;
            $this->loadPosts();
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
        $this->loadPosts();
    }

    /**
     * Selects a category and reloads the associated posts.
     *
     * @param string $name The name of the category to select.
     * @param int $id The ID of the category to select.
     * @return void
     */
    public function selectCategory($name, $id)
    {
        $this->selectedCategoryName = $name;
        $this->selectedCategoryId = $id;
        $this->loadPosts();
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
        $this->loadPosts();
    }

    public function getPostByStatus($status)
    {
        $this->postStatus = $status;
        $this->loadPosts();
    }

    /**
     * Livewire render method.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {

        $this->loadMonths();
        return view('livewire.posts.posts', [
            'posts' => $this->postItems,
            'total' => $this->totalPostCount,
            'page' => $this->currentPage,
            'lastPage' => ceil($this->totalPostCount / $this->perPage),
        ]);
    }

}
