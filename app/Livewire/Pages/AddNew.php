<?php

namespace App\Livewire\Pages;

use App\Services\PostService;
use App\Services\CategoryService;
use App\Services\MessageService;
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
        'postContent' => 'nullable|string',
        'postStatus' => 'in:draft,publish',
        'mediaId' => 'nullable|exists:media,id',
        'userId' => 'nullable|exists:users,id',
    ];

    protected $postService;
    protected $messageService;

    public function __construct()
    {
        $this->postService = app(PostService::class);
        $this->messageService = app(MessageService::class);
    }

    public function quill_value_updated($value){
        $this->postContent = $value;
    }

    public function mount()
    {

    }

    public function setStatusAndSave($status)
    {
        // $this->postStatus = $status;
    
        // try {
        //     $validatedData = $this->validate();
        //     $this->savePost($validatedData);
            
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     $this->messageService->message('error', 'Validation Failed: ' . implode(', ', $e->validator->errors()->all()));
        //     $this->dispatch('reinit');
        // }
        
    }

    public function savePost($validatedData)
    {
        // $data = array_merge($validatedData, [
        //     'post_title' => $this->postTitle,
        //     'post_status' => $this->postStatus,
        //     'post_content' => $this->postContent,
        //     'category_id' => $this->categoryId,
        //     'media_id' => $this->mediaId,
        // ]);
        // $this->postService->create($data);
        // $this->messageService->message('success', 'Post saved successfully.');
        // $this->resetForm();
    }

    public function resetForm()
    {
        $this->postTitle = '';
        $this->postContent = '';
        $this->postStatus = 'draft';
        $this->mediaId = null;
        $this->userId = null;
        $this->resetQuillFlag = !$this->resetQuillFlag; 
    }

    public function render()
    {
        return view('livewire.pages.add-new');
    }
}
