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

    public string $postTitle = '';
    public ?string $postContent = null;
    public string $postStatus = 'draft';
    public string $postType = 'page';
    public ?int $mediaId = null;
    public ?int $userId = null;

    protected array $listeners = [
        Quill::EVENT_VALUE_UPDATED => 'quillValueUpdated'
    ];

    public bool $resetQuillFlag = false;

    protected array $rules = [
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

    public function quillValueUpdated(string $value): void
    {
        $this->postContent = $value;
    }

    public function setStatusAndSave(string $status): void
    {
        $this->postStatus = $status;
    
        try {
            $validatedData = $this->validate();
            $this->savePost($validatedData);
        } catch (ValidationException $e) {
            $this->messageService->message('error', 'Validation Failed: ' . implode(', ', $e->validator->errors()->all()));
            $this->dispatch('reinit');
        } catch (\Exception $e) {
            $this->messageService->message('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    private function savePost(array $validatedData): void
    {
        $data = array_merge($validatedData, [
            'post_title' => $this->postTitle,
            'post_status' => $this->postStatus,
            'post_content' => $this->postContent,
            'post_type' => $this->postType,
            'media_id' => $this->mediaId,
        ]);
        $this->postService->create($data);
        $this->messageService->message('success', 'Page saved successfully.');
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->reset(['postTitle', 'postContent', 'postStatus', 'mediaId', 'userId']);
        $this->postStatus = 'draft';
        $this->resetQuillFlag = !$this->resetQuillFlag;
    }

    public function render()
    {
        return view('livewire.pages.add-new');
    }
}
