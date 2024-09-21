<?php
namespace App\Livewire\Posts;

use App\Services\PostService;
use Livewire\Component;
use App\Models\PostCategory;
use App\Livewire\Quill;

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
        'categoryId' => 'required|exists:post_categories,term_id',
        'mediaId' => 'nullable|exists:media,id',
        'userId' => 'nullable|exists:users,id',
    ];

    protected $postService;

    public function __construct()
    {
        $this->postService = app(PostService::class); // Ensure PostService is correctly instantiated
    }

    public function quill_value_updated($value){
        $this->postContent = $value;
    }

    public function mount()
    {
    }

    public function render()
    {
        $this->cats = PostCategory::select('term_id', 'name', 'slug')->get();
        return view('livewire.posts.add-new');
    }

    public function setStatusAndSave($status)
    {
        $this->postStatus = $status;
    
        try {
            $validatedData = $this->validate();
            $this->savePost($validatedData);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', 'Validation Failed: ' . implode(', ', $e->validator->errors()->all()));
            $this->dispatch('reinit');
            // \Log::error('Validation Failed:', ['errors' => $e->validator->errors()->all()]);
        }
    }

    public function updatedPostContent($value)
    {
        \Log::info('Post Content Updated:', ['content' => $value]);
        // $this->emit('contentUpdated', $this->postContent);
    }

    public function savePost($validatedData)
    {
        $data = array_merge($validatedData, [
            'post_title' => $this->postTitle,
            'post_status' => $this->postStatus,
            'post_content' => $this->postContent,
            'category_id' => $this->categoryId,
            'media_id' => $this->mediaId,
        ]);
        $this->postService->create($data);
        session()->flash('success', 'Post saved successfully.');
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->postTitle = '';
        $this->postContent = '';
        $this->postStatus = 'draft';
        $this->categoryId = null;
        $this->mediaId = null;
        $this->userId = null;
        $this->resetQuillFlag = !$this->resetQuillFlag; 
    }
}