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

    public int $postId;
    public string $postTitle = '';
    public ?string $postContent = null;
    public string $postStatus = 'draft';
    public string $postType = 'page';
    public ?int $mediaId = null;
    public string $mediaName = 'img/placeholders/posts-featured-image.jpg';
    public ?int $userId = null;
    public $listeners = [
        Quill::EVENT_VALUE_UPDATED
    ];

    public bool $resetQuillFlag = false;

    protected $rules = [
        'postTitle' => 'required|string|max:255',
        'postContent' => 'nullable|string',
        'postStatus' => 'in:draft,publish',
        'postType' => 'in:page',
        'mediaId' => 'nullable|exists:media,id',
        'userId' => 'nullable|exists:users,id',
    ];

    private $postService;
    private $messageService;

    public function boot(PostService $postService, MessageService $messageService)
    {
        $this->postService = $postService;
        $this->messageService = $messageService;
    }

    public function quill_value_updated(string $value): void
    {
        $this->postContent = $value;
    }

    public function mount(string $id): void
    {
        $this->postId = $id;
        $this->loadContent();
    }

    public function loadContent(): void
    {

        $post = $this->postService->getPostById($this->postId);
        if( empty($post) ) {
            return;
        }

        $this->postTitle = $post['post_title']; 
        $this->postContent = $post['post_content'];
        $this->postStatus = $post['status'];
        $this->mediaId = $post['media_id'];
        if( !empty($post['media_name']) ){
            $this->mediaName = '/storage/media/' . $post['media_name'];
        }
    }

    public function setStatusAndUpdate(string $status): void
    {
        $this->postStatus = $status;

        try {
            $validatedData = $this->validate();
            $this->updatePost($validatedData);
        } catch (ValidationException $e) {
            $this->messageService->message('error', 'Validation Failed: ' . implode(', ', $e->validator->errors()->all()));
        } catch (\Exception $e) {
            $this->messageService->message('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function updatePost(array $validatedData): void
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
