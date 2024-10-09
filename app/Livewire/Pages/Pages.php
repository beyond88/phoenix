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

    public array $pageItems = [];
    public int $perPage = 10;
    public int $currentPage = 1;
    public int $totalPageCount = 0;
    public bool $hasMorePages = true;
    public int $publish = 0;
    public int $draft = 0;
    public string $search = '';
    public bool $selectAll = false;
    public array $selectedPages = [];
    public string $bulkAction = '';
    public ?object $months;
    public string $selectedDateName = 'All Dates';
    public string $selectedDate = 'all';
    public string $pageStatus = 'all';

    private $postService;
    private $messageService;

    public function boot(PostService $postService, MessageService $messageService)
    {
        $this->postService = $postService;
        $this->messageService = $messageService;
    }

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selectedPages = collect($this->pageItems)->pluck('id')->toArray();
        } else {
            $this->selectedPages = [];
        }
    }
    
    public function updatedSelectedPost(): void
    {
        $this->selectAll = count($this->selectedPages) === count($this->pageItems);
    }

    public function toggleSelectAll(): void
    {
        if ($this->selectAll) {
            $this->selectedPages = collect($this->pageItems)->pluck('id')->toArray();
        } else {
            $this->selectedPages = [];
        }
    }

    public function applyBulkAction(): void
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

    public function deletePageById($pageId): bool
    {
        return $this->postService->delete($pageId);
    }

    protected function processBulkDeletion(): void
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

    public function zeroise($number, $threshold): string
    {
        return sprintf('%0' . $threshold . 's', $number);
    }

    public function mount(): void
    {
        $this->loadMonths();
        $this->loadPages();
    }

    public function loadMonths(): void
    {
        $this->months = $this->postService->loadMonths();
    }

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

    public function updatedSearch(): void
    {
        $this->resetPage();
        $this->loadPages();
    }

    public function formatDate($timestamp, $timezone = null): ? string
    {
        if($timestamp == null){
            return null;
        }
        return $this->postService->formatDate($timestamp, $timezone = null);
    }

    protected function performPageDeletion($id): bool
    {
        return $this->postService->delete($id);
    }

    protected function isDeletionSuccessful($result): bool
    {
        return isset($result['success']) && $result['success'];
    }

    protected function removePageFromList(int $id): void
    {
        $this->pageItems = collect($this->pageItems)->filter(function ($item) use ($id) {
            return $item['id'] !== $id; // Use strict comparison for safety
        })->toArray();
    }

    protected function handlePageDeletionState(): void
    {
        if (collect($this->pageItems)->isEmpty() && $this->currentPage > 1) {
            $this->currentPage--;
        }
    }

    protected function flashDeletionMessages(int $successCount, int $failCount): void
    {
        if ($successCount > 0) {
            $this->messageService->message('success', "$successCount page(s) have been deleted successfully.");
        }
        if ($failCount > 0) {
            $this->messageService->message('error', "Failed to delete $failCount page(s).");
        }
    }

    public function deletePage(int $id): void
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
            // Log the exception for debugging
            \Log::error('Deletion failed: ' . $e->getMessage());
            // Provide a generic error message to the user
            $this->messageService->message('error', 'Deletion failed. Please try again.');
        }
    }

    public function nextPage(): void
    {
        $totalPages = (int) ceil($this->totalPageCount / $this->perPage);
        if ($this->currentPage < $totalPages) {
            $this->currentPage++;
            $this->loadPages();
        }
    }

    public function previousPage(): void
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
            $this->loadPages(); // Load the pages for the previous page
        }
    }

    public function gotoPage(int $page): void
    {
        $totalPages = (int) ceil($this->totalPageCount / $this->perPage);
        
        if ($page >= 1 && $page <= $totalPages) {
            $this->currentPage = $page;
            $this->loadPages(); // Load the pages for the specified page
        }
    }

    public function performSearch(): void
    {
        $this->currentPage = 1; // Reset to the first page on search
        $this->loadPages(); // Load pages based on the search criteria
    }

    public function selectDate(string $name, string $date): void
    {
        $this->selectedDateName = $name;
        $this->selectedDate = $date;
        $this->loadPages(); // Load pages based on the selected date
    }

    public function getPostByStatus(string $status): void
    {
        $this->pageStatus = $status;
        $this->loadPages(); // Load pages based on the post status
    }

    public function render()
    {
        $this->loadMonths(); // Load months for display
        return view('livewire.pages.pages', [
            'pages' => $this->pageItems,
            'total' => $this->totalPageCount,
            'page' => $this->currentPage,
            'lastPage' => ceil($this->totalPageCount / $this->perPage),
        ]);
    }
}
