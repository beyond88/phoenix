<?php

namespace App\Livewire\Pages;

use App\Services\PostService;
use App\Services\CategoryService;
use App\Services\MessageService;
use Livewire\Component;
use App\Models\PostCategory;
use App\Livewire\Quill;

class Edit extends Component
{

    public $postTitle;
    public $postContent;
    public $postStatus = 'draft';
    public $postType = 'page';
    public $mediaId;
    public $mediaName = 'img/placeholders/posts-featured-image.jpg';
    public $userId;
    public $listeners = [
        Quill::EVENT_VALUE_UPDATED
    ];

    public $resetQuillFlag = false;

    protected $rules = [
        'postTitle' => 'required|string|max:255',
        'postContent' => 'nullable|string',
        'postStatus' => 'in:draft,publish',
        'postType' => 'in:page',
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

    public function mount($id)
    {
        $this->postId = $id;
        $this->loadContent();
    }

    public function loadContent(){

        $post = $this->postService->getPostById($this->postId);
        if( empty($post) ){
            return null;
        }

        $this->postTitle = $post['post_title']; 
        $this->postContent = $post['post_content'];
        $this->postStatus = $post['status'];
        $this->mediaId = $post['media_id'];
        if( !empty($post['media_name']) ){
            $this->mediaName = '/storage/media/' . $post['media_name'];
        }
    }

    public function setStatusAndUpdate($status)
    {
        $this->postStatus = $status;
    
        try {
            $validatedData = $this->validate();
            $this->updatePost($validatedData);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->messageService->message('error', 'Validation Failed: ' . implode(', ', $e->validator->errors()->all()));
        }
    }

    public function updatePost($validatedData)
    {
        $data = array_merge($validatedData, [
            'id' => $this->postId,
            'post_title' => $this->postTitle,
            'post_status' => $this->postStatus,
            'post_content' => $this->postContent,
            'media_id' => $this->mediaId,
        ]);
        $this->postService->update($data);
        $this->messageService->message('success', 'Post updated successfully.');
    }

    public function render()
    {
        return view('livewire.pages.edit');
    }
}
