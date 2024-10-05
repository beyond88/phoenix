<?php
namespace App\Livewire\Posts;

use App\Services\PostService;
use App\Services\CategoryService;
use App\Services\MessageService;
use Livewire\Component;
use App\Models\Terms;
use App\Livewire\Quill;
use Illuminate\Support\Facades\Log;

class AddNew extends Component
{
    public $cats;
    public $postTitle;
    public $postContent;
    public $postStatus = 'draft';
    public $categoryId;
    public $mediaId;
    public $userId;
    public $listeners = [
        Quill::EVENT_VALUE_UPDATED
    ];

    public $resetQuillFlag = false;

    protected $rules = [
        'postTitle' => 'required|string|max:255',
        'postContent' => 'required|string',
        'postStatus' => 'in:draft,publish',
        'categoryId' => 'required|exists:terms,term_id',
        'mediaId' => 'nullable|exists:media,id',
        'userId' => 'nullable|exists:users,id',
    ];

    private $postService;
    private $categoryService;
    private $messageService;

    public function boot(PostService $postService, CategoryService $categoryService, MessageService $messageService): void
    {
        $this->postService = $postService;
        $this->categoryService = $categoryService;
        $this->messageService = $messageService;
    }

    public function quill_value_updated($value): void
    {
        $this->postContent = $value;
    }

    public function loadCategories()
    {
        $this->cats = $this->categoryService->getAllCategories();
    }

    public function mount(): void
    {
        
        $this->loadCategories();
    }

    public function setStatusAndSave($status): void
    {
        $this->postStatus = $status;
    
        try {
            $validatedData = $this->validate();
            $this->savePost($validatedData);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->messageService->message('error', 'Validation Failed: ' . implode(', ', $e->validator->errors()->all()));
            $this->dispatch('reinit');
        }
    }

    public function savePost($validatedData): void
    {
        $data = array_merge($validatedData, [
            'post_title' => $this->postTitle,
            'post_status' => $this->postStatus,
            'post_content' => $this->postContent,
            'media_id' => $this->mediaId,
        ]);

        $postId = $this->postService->create($data);
        $termTaxonomy = $this->postService->getTermTaxonomy($this->categoryId);
        
        if ($termTaxonomy) {
            // Log::info('TermTaxonomy found', ['TermTaxonomy' => $termTaxonomy->term_taxonomy_id]);
            $termRelationships = [
                'object_id' => $postId,
                'term_taxonomy_id' => $termTaxonomy->term_taxonomy_id,
            ];
            $this->postService->addTermRelationships($termRelationships);
            $this->postService->increementTermTaxonomyCount($termTaxonomy->term_taxonomy_id);
        }

        $this->messageService->message('success', 'Post saved successfully.');
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->postTitle = '';
        $this->postContent = '';
        $this->postStatus = 'draft';
        $this->categoryId = null;
        $this->mediaId = null;
        $this->userId = null;
        $this->resetQuillFlag = !$this->resetQuillFlag; 
    }

    public function render()
    {
        return view('livewire.posts.add-new');
    }
}